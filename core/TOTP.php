<?php
namespace Core;

class TOTP {
    private static $base32chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';

    public static function createSecret($length = 16) {
        $secret = '';
        for ($i = 0; $i < $length; $i++) {
            $secret .= self::$base32chars[random_int(0, 31)];
        }
        return $secret;
    }

    public static function verifyCode($secret, $code, $discrepancy = 1) {
        $currentTimeSlice = floor(time() / 30);

        for ($i = -$discrepancy; $i <= $discrepancy; $i++) {
            $calculatedCode = self::getCode($secret, $currentTimeSlice + $i);
            if ($calculatedCode == $code) {
                return true;
            }
        }
        return false;
    }

    private static function getCode($secret, $timeSlice) {
        $secretKey = self::base32Decode($secret);
        // Pack time into binary string
        $time = chr(0).chr(0).chr(0).chr(0).pack('N*', $timeSlice);
        $hmac = hash_hmac('SHA1', $time, $secretKey, true);
        $offset = ord(substr($hmac, -1)) & 0x0F;
        $hashpart = substr($hmac, $offset, 4);
        
        $value = unpack('N', $hashpart);
        $value = $value[1];
        
        $value = $value & 0x7FFFFFFF;
        $modulo = pow(10, 6);
        return str_pad($value % $modulo, 6, '0', STR_PAD_LEFT);
    }

    private static function base32Decode($secret) {
        if (empty($secret)) return '';
        
        $base32chars = self::$base32chars;
        $base32charsFlipped = array_flip(str_split($base32chars));
        
        $paddingCharCount = substr_count($secret, '=');
        $allowedValues = array(6, 4, 3, 1, 0);
        if (!in_array($paddingCharCount, $allowedValues)) return false;
        
        for ($i = 0; $i < 4; $i++){
            if ($paddingCharCount == $allowedValues[$i] &&
                substr($secret, -($allowedValues[$i])) != str_repeat('=', $allowedValues[$i])) return false;
        }
        $secret = str_replace('=', '', $secret);
        $secret = str_split($secret);
        $binaryString = "";
        for ($i = 0; $i < count($secret); $i = $i+8) {
            $x = "";
            if (!in_array($secret[$i], str_split($base32chars))) return false;
            for ($j = 0; $j < 8; $j++) {
                $x .= str_pad(base_convert(@$base32charsFlipped[@$secret[$i + $j]], 10, 2), 5, '0', STR_PAD_LEFT);
            }
            $eightBits = str_split($x, 8);
            for ($z = 0; $z < count($eightBits); $z++) {
                $binaryString .= ( ($y = chr(base_convert($eightBits[$z], 2, 10))) || ord($y) == 48 ) ? $y : "";
            }
        }
        return $binaryString;
    }

    public static function getQRUrl($name, $secret, $issuer = 'Agroplan') {
        $url = "otpauth://totp/" . rawurlencode($issuer) . ":" . rawurlencode($name) . "?secret=" . $secret . "&issuer=" . rawurlencode($issuer);
        return "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=" . urlencode($url);
    }
}
