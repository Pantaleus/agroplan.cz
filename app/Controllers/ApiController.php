<?php
namespace App\Controllers;

use Core\Controller;
use Core\Database;
use PDO;

class ApiController extends Controller {

    public function track() {
        // Získání raw dat
        $rawData = file_get_contents("php://input");
        $data = json_decode($rawData, true);

        if (!$data) {
            $this->json(['status' => 'error', 'msg' => 'No data']);
        }

        $pdo = Database::getInstance();

        // 1. Ošetření tabulky, pokud neexistuje (Pro jednoduchost vytvoříme tabulky rovnou zde, abychom nemuseli řešit migrace ručně na hostingu)
        $this->ensureTablesExist($pdo);

        $sessionId = $data['session_id'] ?? '';
        $isNew = ($data['is_new'] ?? false) ? 1 : 0;
        $resolution = $data['resolution'] ?? '';
        $url = $data['url'] ?? '';
        $maxScroll = $data['max_scroll'] ?? 0;
        $timeSpent = $data['time_spent'] ?? 0;
        $ipAddress = $_SERVER['REMOTE_ADDR'] ?? '';
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';

        // Detekce Botů
        $isBot = preg_match('/bot|crawl|slurp|spider|mediapartners/i', $userAgent) ? 1 : 0;

        // Parsování Browser a OS jednoduše
        $browser = $this->getBrowser($userAgent);
        $os = $this->getOS($userAgent);
        $device = $this->getDevice($userAgent);

        // Získání GEO podle IP (zde simulace rychlého API - v produkci opatrně na rate limit, 
        // pro skutečný server by bylo lepší stáhnout mmdb databázi)
        // Využijeme ip-api.com zdarma, ale jen pro nové sessiony, ať nevoláme moc často.
        
        $country = '';
        $city = '';
        $flag = '';
        
        // Check jestli session už existuje
        $stmt = $pdo->prepare("SELECT id, country, city, flag FROM visitor_sessions WHERE session_id = ?");
        $stmt->execute([$sessionId]);
        $existing = $stmt->fetch();

        if ((!$existing || empty($existing['country'])) && $ipAddress !== '127.0.0.1' && $ipAddress !== '::1') {
            // Zkus zjistit z geojs.io, obaleno v try/catch
            try {
                $geoUrl = "https://get.geojs.io/v1/ip/geo/{$ipAddress}.json";
                if (function_exists('curl_version')) {
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $geoUrl);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 3);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    $geoDataRaw = curl_exec($ch);
                    curl_close($ch);
                } else {
                    $geoDataRaw = @file_get_contents($geoUrl);
                }
                
                if ($geoDataRaw) {
                    $geoInfo = json_decode($geoDataRaw, true);
                    if ($geoInfo && !empty($geoInfo['country'])) {
                        $country = $geoInfo['country'];
                        $city = $geoInfo['city'] ?? '';
                        $flag = strtolower($geoInfo['country_code'] ?? '');
                        
                        // Pokud jde o opravu u již existující session
                        if ($existing) {
                            $updateGeo = $pdo->prepare("UPDATE visitor_sessions SET country = ?, city = ?, flag = ? WHERE session_id = ?");
                            $updateGeo->execute([$country, $city, $flag, $sessionId]);
                            $existing['country'] = $country;
                            $existing['city'] = $city;
                            $existing['flag'] = $flag;
                        }
                    }
                }
            } catch (\Exception $e) {
                // Tiše ignorovat chybu GEO, hlavní je zaznamenat návštěvu
            }
        } 
        
        if ($existing) {
            $country = $existing['country'] ?? '';
            $city = $existing['city'] ?? '';
            $flag = $existing['flag'] ?? '';
        }

        if (!$existing) {
            // Insert nová session
            $insert = $pdo->prepare("INSERT INTO visitor_sessions (session_id, ip_address, country, city, flag, user_agent, browser, os, device, resolution, is_bot, is_new_visitor, created_at, updated_at, total_time_spent) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW(), ?)");
            $insert->execute([$sessionId, $ipAddress, $country, $city, $flag, $userAgent, $browser, $os, $device, $resolution, $isBot, $isNew, $timeSpent]);
        } else {
            // Update session čas
            $update = $pdo->prepare("UPDATE visitor_sessions SET total_time_spent = ?, updated_at = NOW() WHERE session_id = ?");
            $update->execute([$timeSpent, $sessionId]);
        }

        // Uložení/Update page návštěvy (scroll, time)
        $stmtUrl = $pdo->prepare("SELECT id FROM page_visits WHERE session_id = ? AND url = ?");
        $stmtUrl->execute([$sessionId, $url]);
        $existingUrl = $stmtUrl->fetch();

        if (!$existingUrl) {
            $insertUrl = $pdo->prepare("INSERT INTO page_visits (session_id, url, max_scroll_percent, time_spent_seconds, created_at) VALUES (?, ?, ?, ?, NOW())");
            $insertUrl->execute([$sessionId, $url, $maxScroll, $timeSpent]);
        } else {
            $updateUrl = $pdo->prepare("UPDATE page_visits SET max_scroll_percent = GREATEST(max_scroll_percent, ?), time_spent_seconds = GREATEST(time_spent_seconds, ?) WHERE id = ?");
            $updateUrl->execute([$maxScroll, $timeSpent, $existingUrl['id']]);
        }

        $this->json(['status' => 'ok']);
    }

    private function getBrowser($ua) {
        if(strpos($ua, 'MSIE') !== false || strpos($ua, 'Trident') !== false) return 'Internet Explorer';
        if(strpos($ua, 'Edge') !== false) return 'Edge';
        if(strpos($ua, 'Chrome') !== false) return 'Chrome';
        if(strpos($ua, 'Firefox') !== false) return 'Firefox';
        if(strpos($ua, 'Safari') !== false) return 'Safari';
        if(strpos($ua, 'Opera') !== false) return 'Opera';
        return 'Unknown';
    }

    private function getOS($ua) {
        if(strpos($ua, 'Windows NT 10.0') !== false) return 'Windows 10/11';
        if(strpos($ua, 'Windows NT 6.3') !== false) return 'Windows 8.1';
        if(strpos($ua, 'Windows NT 6.2') !== false) return 'Windows 8';
        if(strpos($ua, 'Windows NT 6.1') !== false) return 'Windows 7';
        if(strpos($ua, 'Mac OS X') !== false) return 'Mac OS X';
        if(strpos($ua, 'Linux') !== false) return 'Linux';
        if(strpos($ua, 'Android') !== false) return 'Android';
        if(strpos($ua, 'iOS') !== false || strpos($ua, 'iPhone') !== false || strpos($ua, 'iPad') !== false) return 'iOS';
        return 'Unknown';
    }

    private function getDevice($ua) {
        if(preg_match('/mobile|android|touch|webos|hpwos/i', $ua)) {
            if(preg_match('/ipad|tablet|playbook|silk/i', $ua)) return 'Tablet';
            return 'Mobile';
        }
        return 'Desktop';
    }

    private function ensureTablesExist(PDO $pdo) {
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS visitor_sessions (
                id INT AUTO_INCREMENT PRIMARY KEY,
                session_id VARCHAR(100) UNIQUE,
                ip_address VARCHAR(50),
                country VARCHAR(100),
                city VARCHAR(100),
                flag VARCHAR(10),
                user_agent TEXT,
                browser VARCHAR(50),
                os VARCHAR(50),
                device VARCHAR(50),
                resolution VARCHAR(20),
                is_bot TINYINT(1) DEFAULT 0,
                is_new_visitor TINYINT(1) DEFAULT 1,
                total_time_spent INT DEFAULT 0,
                created_at DATETIME,
                updated_at DATETIME
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ");

        $pdo->exec("
            CREATE TABLE IF NOT EXISTS page_visits (
                id INT AUTO_INCREMENT PRIMARY KEY,
                session_id VARCHAR(100),
                url VARCHAR(255),
                max_scroll_percent INT DEFAULT 0,
                time_spent_seconds INT DEFAULT 0,
                created_at DATETIME,
                FOREIGN KEY (session_id) REFERENCES visitor_sessions(session_id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ");
        
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS admin_users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                email VARCHAR(255) UNIQUE,
                password VARCHAR(255),
                first_name VARCHAR(100),
                last_name VARCHAR(100),
                phone VARCHAR(50),
                auto_logout_minutes INT DEFAULT 30,
                two_factor_secret VARCHAR(255) NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ");

        $pdo->exec("
            CREATE TABLE IF NOT EXISTS admin_logs (
                id INT AUTO_INCREMENT PRIMARY KEY,
                admin_id INT,
                action VARCHAR(255),
                ip_address VARCHAR(50),
                created_at DATETIME,
                FOREIGN KEY (admin_id) REFERENCES admin_users(id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ");
        
        // Vytvoř defaultního admina pokud neexistuje (Heslo admin123 pro první login, lze změnit)
        $stmt = $pdo->query("SELECT id FROM admin_users LIMIT 1");
        if (!$stmt->fetch()) {
            $hash = password_hash('admin123', PASSWORD_DEFAULT);
            $pdo->exec("INSERT INTO admin_users (email, password, first_name, last_name, auto_logout_minutes) VALUES ('admin@agroplan.cz', '$hash', 'Hlavní', 'Admin', 30)");
        }
    }
}
