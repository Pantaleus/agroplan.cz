<?php require 'header.php'; ?>
<div class="min-h-screen flex items-center justify-center -mt-8">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Přihlášení</h2>
            <p class="text-gray-500 mt-2">Zadejte své údaje pro přístup do administrace</p>
        </div>

        <?php if(isset($error)): ?>
            <div class="bg-red-50 text-red-600 p-4 rounded-lg mb-6 text-sm border border-red-200">
                <?= $error ?>
            </div>
        <?php endif; ?>
        <?php if(isset($_GET['timeout'])): ?>
            <div class="bg-yellow-50 text-yellow-600 p-4 rounded-lg mb-6 text-sm border border-yellow-200">
                Byli jste automaticky odhlášeni z důvodu neaktivity.
            </div>
        <?php endif; ?>

        <form action="/admin/login" method="POST" class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">E-mail</label>
                <input type="email" name="email" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-agroplan focus:border-transparent outline-none transition-all">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Heslo</label>
                <input type="password" name="password" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-agroplan focus:border-transparent outline-none transition-all">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">2FA Kód (Máte-li aktivní)</label>
                <input type="text" name="totp" placeholder="123456" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-agroplan focus:border-transparent outline-none transition-all text-center tracking-widest text-lg font-mono">
                <p class="text-xs text-gray-500 mt-1">Zadejte 6místný kód z aplikace Google Authenticator.</p>
            </div>
            
            <button type="submit" class="w-full py-3 bg-agroplan hover:bg-agroplan-dark text-white rounded-lg font-bold transition-colors shadow-lg hover:shadow-xl">
                Přihlásit se
            </button>
        </form>
    </div>
</div>
<?php require 'footer.php'; ?>
