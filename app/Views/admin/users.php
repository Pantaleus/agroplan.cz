<?php require 'header.php'; ?>

<div class="flex-none w-full">

<div class="mb-8">
    <h2 class="text-3xl font-bold text-gray-900">Správa uživatelů a 2FA</h2>
    <p class="text-gray-500 mt-1">Nastavení zabezpečení a automatického odhlášení</p>
</div>

<?php if(isset($_GET['success'])): ?>
    <div class="bg-green-50 text-green-700 p-4 rounded-lg mb-6 text-sm border border-green-200">
        Akce byla úspěšně provedena.
    </div>
<?php endif; ?>

<?php if(isset($_GET['error']) && $_GET['error'] === 'password_mismatch'): ?>
    <div class="bg-red-50 text-red-700 p-4 rounded-lg mb-6 text-sm border border-red-200">
        Chyba: Zadaná nová hesla se neshodují! Úpravy nebyly uloženy.
    </div>
<?php endif; ?>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-left text-sm text-gray-600">
        <thead class="bg-gray-50 text-gray-700">
            <tr>
                <th class="px-6 py-3">Jméno</th>
                <th class="px-6 py-3">E-mail / Telefon</th>
                <th class="px-6 py-3">Auto Odhlášení</th>
                <th class="px-6 py-3">2FA (Autentifikátor)</th>
                <th class="px-6 py-3">Akce pro můj účet</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            <?php foreach($users as $u): ?>
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <?php if(!empty($u['profile_picture'])): ?>
                            <img src="/uploads/profiles/<?= htmlspecialchars($u['profile_picture']) ?>" alt="" class="w-10 h-10 rounded-full object-cover border border-gray-200 flex-none">
                        <?php else: ?>
                            <div class="w-10 h-10 rounded-full bg-agroplan/10 flex items-center justify-center text-agroplan font-bold text-sm flex-none">
                                <?= mb_substr($u['first_name'], 0, 1) . mb_substr($u['last_name'], 0, 1) ?>
                            </div>
                        <?php endif; ?>
                        <div>
                            <div class="font-bold text-gray-900"><?= htmlspecialchars($u['first_name'] . ' ' . $u['last_name']) ?></div>
                            <?php if($u['id'] == $_SESSION['admin_id']): ?>
                                <span class="text-xs bg-agroplan text-white px-2 py-0.5 rounded mt-0.5 inline-block">To jste vy</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <div><?= htmlspecialchars($u['email']) ?></div>
                    <div class="text-gray-400 text-xs"><?= htmlspecialchars($u['phone']) ?: 'Nezadáno' ?></div>
                </td>
                <td class="px-6 py-4">
                    <?= $u['auto_logout_minutes'] ?> minut
                </td>
                <td class="px-6 py-4">
                    <?php if(!empty($u['two_factor_secret'])): ?>
                        <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-bold flex items-center gap-1 inline-flex"><div class="w-2 h-2 rounded-full bg-green-500"></div>Aktivní</span>
                    <?php else: ?>
                        <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs font-bold">Neaktivní</span>
                    <?php endif; ?>
                </td>
                <td class="px-6 py-4">
                    <?php if($u['id'] == $_SESSION['admin_id']): ?>
                        <form action="/admin/users" method="POST" class="inline-block">
                            <?php if(empty($u['two_factor_secret'])): ?>
                                <button type="submit" name="enable_2fa" class="text-blue-600 hover:text-blue-800 font-medium underline">Zapnout 2FA</button>
                            <?php else: ?>
                                <button type="submit" name="disable_2fa" class="text-red-600 hover:text-red-800 font-medium underline" onclick="return confirm('Opravdu vypnout 2FA?')">Vypnout 2FA</button>
                            <?php endif; ?>
                        </form>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
// Najdeme aktuálního uživatele pro 2FA sekci
$me2fa = null;
foreach($users as $u) {
    if($u['id'] == $_SESSION['admin_id']) { $me2fa = $u; break; }
}
?>
<?php if(!empty($me2fa['two_factor_secret'])): ?>

<!-- Lightbox overlay -->
<div id="qr-lightbox" style="display:none; position:fixed; inset:0; z-index:9999; background:rgba(0,0,0,0.55); backdrop-filter:blur(4px);" onclick="if(event.target===this) closeLightbox()">
    <div style="position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); background:white; border-radius:24px; padding:40px; max-width:480px; width:90%; box-shadow:0 25px 50px rgba(0,0,0,0.25); text-align:center;">
        <button onclick="closeLightbox()" style="position:absolute; top:16px; right:16px; width:32px; height:32px; border-radius:50%; border:none; background:#f3f4f6; cursor:pointer; font-size:18px; color:#6b7280; display:flex; align-items:center; justify-content:center; line-height:1;">×</button>
        <h4 style="font-weight:700; font-size:1.3rem; color:#111827; margin:0 0 6px 0;">Nastavení Google Authenticator</h4>
        <p style="color:#6b7280; font-size:0.85rem; margin:0 0 24px 0;">Naskenujte QR kód nebo zadejte klíč ručně</p>
        <div style="width:220px; height:220px; margin:0 auto 20px auto; background:white; padding:12px; border:1px solid #e5e7eb; border-radius:16px; box-shadow:0 4px 12px rgba(0,0,0,0.08);">
            <img src="<?= $totp->getQRUrl($me2fa['email'], $me2fa['two_factor_secret']) ?>" alt="QR Code" style="width:100%; height:100%; object-fit:contain; display:block;">
        </div>
        <p style="color:#4b5563; font-size:0.9rem; margin:0 0 16px 0;">Naskenujte tento QR kód do aplikace <strong>Google Authenticator</strong> nebo <strong>Authy</strong>. Při přihlášení budete dotázáni na 6místný kód.</p>
        <p style="font-size:0.8rem; color:#9ca3af; margin:0 0 8px 0;">Nebo zadejte tajný klíč ručně:</p>
        <div style="background:#f9fafb; padding:12px 20px; border-radius:10px; display:inline-block; font-family:monospace; font-size:1.1rem; letter-spacing:0.18em; color:#1f2937; border:1px solid #d1d5db;">
            <?= $me2fa['two_factor_secret'] ?>
        </div>
    </div>
</div>

<!-- Trigger tlačítko v informačním baneru -->
<div class="mt-8 bg-blue-50 border border-blue-200 rounded-2xl px-6 py-4 flex items-center justify-between gap-4">
    <div class="flex items-center gap-3">
        <div style="width:36px; height:36px; background:#dbeafe; border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><path d="M14 14h3v3h-3zM17 17h3v3h-3zM14 20h3"/></svg>
        </div>
        <div>
            <p class="font-semibold text-blue-900 text-sm">Dvoufaktorové ověření je aktivní</p>
            <p class="text-blue-600 text-xs">Potřebujete znovu naskenovat QR kód nebo zobrazit tajný klíč?</p>
        </div>
    </div>
    <button onclick="openLightbox()" class="flex-none px-4 py-2 bg-blue-600 text-white text-sm font-bold rounded-xl hover:bg-blue-700 transition-colors whitespace-nowrap">
        Zobrazit QR kód
    </button>
</div>

<script>
function openLightbox() {
    document.getElementById('qr-lightbox').style.display = 'block';
    document.body.style.overflow = 'hidden';
}
function closeLightbox() {
    document.getElementById('qr-lightbox').style.display = 'none';
    document.body.style.overflow = '';
}
document.addEventListener('keydown', function(e){ if(e.key === 'Escape') closeLightbox(); });
</script>
<?php endif; ?>

<div class="mt-8 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 bg-gray-50 border-b border-gray-100 flex items-center gap-4">
        <h3 class="text-xl font-bold text-gray-900">Upravit můj profil</h3>
    </div>
    <div class="p-6">
        <?php 
            // Najdeme aktuálního uživatele
            $me = null;
            foreach($users as $u) {
                if($u['id'] == $_SESSION['admin_id']) {
                    $me = $u;
                    break;
                }
            }
        ?>
        <form action="/admin/users" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <div class="md:col-span-2 flex items-center gap-6 mb-4">
                <?php if(!empty($me['profile_picture'])): ?>
                    <img src="/uploads/profiles/<?= htmlspecialchars($me['profile_picture']) ?>" alt="Profilovka" class="w-24 h-24 rounded-full object-cover shadow-sm border border-gray-200">
                <?php else: ?>
                    <div class="w-24 h-24 rounded-full bg-agroplan-light/20 flex items-center justify-center text-agroplan-dark font-bold text-3xl">
                        <?= mb_substr($me['first_name'], 0, 1) . mb_substr($me['last_name'], 0, 1) ?>
                    </div>
                <?php endif; ?>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nahrát novou profilovku</label>
                    <input type="file" name="profile_picture" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-agroplan-light/10 file:text-agroplan hover:file:bg-agroplan-light/20">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jméno</label>
                <input type="text" name="first_name" value="<?= htmlspecialchars($me['first_name'] ?? '') ?>" required class="w-full border-gray-300 rounded-xl shadow-sm focus:border-agroplan focus:ring-agroplan">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Příjmení</label>
                <input type="text" name="last_name" value="<?= htmlspecialchars($me['last_name'] ?? '') ?>" required class="w-full border-gray-300 rounded-xl shadow-sm focus:border-agroplan focus:ring-agroplan">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">E-mail</label>
                <input type="email" name="email" value="<?= htmlspecialchars($me['email'] ?? '') ?>" required class="w-full border-gray-300 rounded-xl shadow-sm focus:border-agroplan focus:ring-agroplan">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Telefon</label>
                <input type="text" name="phone" value="<?= htmlspecialchars($me['phone'] ?? '') ?>" class="w-full border-gray-300 rounded-xl shadow-sm focus:border-agroplan focus:ring-agroplan">
            </div>
            <div class="md:col-span-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nové heslo (ponechte prázdné pro zachování starého)</label>
                <input type="password" name="password" placeholder="Zadejte nové heslo..." class="w-full border-gray-300 rounded-xl shadow-sm focus:border-agroplan focus:ring-agroplan">
            </div>
            <div class="md:col-span-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nové heslo znovu (pro kontrolu)</label>
                <input type="password" name="password_confirm" placeholder="Zopakujte nové heslo..." class="w-full border-gray-300 rounded-xl shadow-sm focus:border-agroplan focus:ring-agroplan">
            </div>
            <div class="md:col-span-2 pt-4">
                <button type="submit" name="update_profile" class="px-6 py-3 bg-agroplan text-white font-bold rounded-xl hover:bg-agroplan-dark shadow-md hover:shadow-lg transition-all w-full md:w-auto">
                    Uložit změny
                </button>
            </div>
        </form>
    </div>
</div>

</div><!-- end flex-none w-full -->

<?php require 'footer.php'; ?>