<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrace | AGROPLAN</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        agroplan: {
                            light: '#4ade80',
                            DEFAULT: '#16a34a',
                            dark: '#14532d',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100 font-sans text-gray-800">
<?php if(isset($_SESSION['admin_logged_in'])): ?>
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-agroplan-dark text-white flex flex-col">
            <div class="p-6">
                <h1 class="text-2xl font-bold">Admin Panel</h1>
                <p class="text-sm text-gray-300 mt-2">AGROPLAN s.r.o.</p>
            </div>
            <nav class="flex-1 px-4 space-y-2">
                <a href="/admin" class="block px-4 py-3 rounded-lg <?= $_SERVER['REQUEST_URI'] == '/admin' ? 'bg-agroplan' : 'hover:bg-agroplan/50' ?> transition-colors">
                    Nástěnka
                </a>
                <a href="/admin/users" class="block px-4 py-3 rounded-lg <?= $_SERVER['REQUEST_URI'] == '/admin/users' ? 'bg-agroplan' : 'hover:bg-agroplan/50' ?> transition-colors">
                    Správa uživatelů & 2FA
                </a>
                <a href="/admin/logs" class="block px-4 py-3 rounded-lg <?= $_SERVER['REQUEST_URI'] == '/admin/logs' ? 'bg-agroplan' : 'hover:bg-agroplan/50' ?> transition-colors">
                    Admin Logy
                </a>
            </nav>
            <div class="p-4 border-t border-white/10">
                <?php
                    // Vždy načti aktuální profilovku přímo z DB
                    $headerPic = null;
                    if (!empty($_SESSION['admin_id'])) {
                        try {
                            $headerPdo = \Core\Database::getInstance();
                            $headerStmt = $headerPdo->prepare("SELECT profile_picture FROM admin_users WHERE id = ? LIMIT 1");
                            $headerStmt->execute([$_SESSION['admin_id']]);
                            $headerPic = $headerStmt->fetchColumn();
                        } catch (\Exception $e) {}
                    }
                ?>
                <div class="flex items-center gap-3 mb-3">
                    <?php if(!empty($headerPic)): ?>
                        <img src="/uploads/profiles/<?= htmlspecialchars($headerPic) ?>"
                             alt="" class="w-10 h-10 rounded-full object-cover border-2 border-white/20 flex-none">
                    <?php else: ?>
                        <?php
                            $parts = explode(' ', trim($_SESSION['admin_name']));
                            $initials = mb_substr($parts[0], 0, 1) . (isset($parts[1]) ? mb_substr($parts[1], 0, 1) : '');
                        ?>
                        <div class="w-10 h-10 rounded-full bg-agroplan flex items-center justify-center text-white font-bold text-sm flex-none">
                            <?= htmlspecialchars($initials) ?>
                        </div>
                    <?php endif; ?>
                    <div class="min-w-0">
                        <p class="text-white/50 text-xs leading-none mb-0.5">Přihlášen</p>
                        <p class="text-white font-semibold text-sm truncate"><?= htmlspecialchars($_SESSION['admin_name']) ?></p>
                    </div>
                </div>
                <a href="/admin/logout" class="block w-full text-center px-4 py-2 bg-red-600 hover:bg-red-700 rounded-lg transition-colors text-sm font-medium">Odhlásit se</a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col h-screen overflow-y-auto bg-gray-100 p-8">
<?php endif; ?>