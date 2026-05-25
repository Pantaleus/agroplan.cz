<?php require 'header.php'; ?>

<div class="mb-8">
    <h2 class="text-3xl font-bold text-gray-900">Logy administrátorů</h2>
    <p class="text-gray-500 mt-1">Historie přístupů a akcí provedených v administraci</p>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-left text-sm text-gray-600">
        <thead class="bg-gray-50 text-gray-700">
            <tr>
                <th class="px-6 py-3 w-48">Datum a Čas</th>
                <th class="px-6 py-3 w-48">Uživatel</th>
                <th class="px-6 py-3 w-40">IP Adresa</th>
                <th class="px-6 py-3">Akce</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            <?php foreach($logs as $log): ?>
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap text-gray-500"><?= $log['created_at'] ?></td>
                <td class="px-6 py-4 font-medium text-gray-900"><?= htmlspecialchars($log['first_name'] . ' ' . $log['last_name']) ?></td>
                <td class="px-6 py-4 font-mono text-xs"><?= htmlspecialchars($log['ip_address']) ?></td>
                <td class="px-6 py-4">
                    <?php if(strpos($log['action'], 'Úspěšné přihlášení') !== false): ?>
                        <span class="text-green-600 font-medium"><?= htmlspecialchars($log['action']) ?></span>
                    <?php elseif(strpos($log['action'], 'neaktivitě') !== false || strpos($log['action'], 'Neplatný') !== false): ?>
                        <span class="text-red-600 font-medium"><?= htmlspecialchars($log['action']) ?></span>
                    <?php else: ?>
                        <?= htmlspecialchars($log['action']) ?>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if(empty($logs)): ?>
            <tr>
                <td colspan="4" class="px-6 py-8 text-center text-gray-500">Zatím žádné záznamy</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require 'footer.php'; ?>
