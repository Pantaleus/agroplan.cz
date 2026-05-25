<?php require 'header.php'; ?>

<div class="mb-8 flex justify-between items-end">
    <div>
        <h2 class="text-3xl font-bold text-gray-900">Nástěnka</h2>
        <p class="text-gray-500 mt-1">Komplexní přehled o návštěvnosti a chování uživatelů</p>
    </div>
</div>

<!-- Key Metrics -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
        <div class="text-gray-500 text-sm font-medium mb-1">Celkem návštěv (Sessions)</div>
        <div class="text-3xl font-bold text-gray-900"><?= $totalSessions ?></div>
    </div>
    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
        <div class="text-gray-500 text-sm font-medium mb-1">Skuteční lidé vs Boti</div>
        <div class="text-3xl font-bold text-agroplan"><?= $totalHumans ?> <span class="text-lg text-gray-400">/ <?= $totalBots ?></span></div>
    </div>
    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
        <div class="text-gray-500 text-sm font-medium mb-1">Průměrný čas na webu</div>
        <div class="text-3xl font-bold text-gray-900"><?= $avgTimeMinutes ?></div>
    </div>
    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
        <div class="text-gray-500 text-sm font-medium mb-1">Průměrný Scroll (Zájem)</div>
        <div class="text-3xl font-bold text-blue-600"><?= $avgScroll ?>%</div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
    <!-- OS -->
    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
        <h3 class="font-bold text-gray-900 mb-4 border-b pb-2">Nejčastější OS</h3>
        <ul class="space-y-3">
            <?php foreach($topOs as $os): ?>
            <li class="flex justify-between items-center">
                <span class="text-gray-600"><?= htmlspecialchars($os['os']) ?></span>
                <span class="font-bold bg-gray-100 px-2 py-1 rounded text-sm"><?= $os['count'] ?></span>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- Prohlížeče -->
    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
        <h3 class="font-bold text-gray-900 mb-4 border-b pb-2">Prohlížeče</h3>
        <ul class="space-y-3">
            <?php foreach($topBrowsers as $b): ?>
            <li class="flex justify-between items-center">
                <span class="text-gray-600"><?= htmlspecialchars($b['browser']) ?></span>
                <span class="font-bold bg-gray-100 px-2 py-1 rounded text-sm"><?= $b['count'] ?></span>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- GEO -->
    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
        <h3 class="font-bold text-gray-900 mb-4 border-b pb-2">Země (GEO)</h3>
        <ul class="space-y-3">
            <?php foreach($topCountries as $c): ?>
            <li class="flex justify-between items-center">
                <span class="text-gray-600 flex items-center gap-2">
                    <?php if($c['flag']): ?>
                        <img src="https://flagcdn.com/w20/<?= $c['flag'] ?>.png" alt="flag">
                    <?php else: ?>
                        🌍
                    <?php endif; ?>
                    <?= htmlspecialchars($c['country'] ?: 'Neznámá') ?>
                </span>
                <span class="font-bold bg-gray-100 px-2 py-1 rounded text-sm"><?= $c['count'] ?></span>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

<!-- Detailní Log Návštěv -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100">
        <h3 class="font-bold text-gray-900">Posledních 20 detailních logů návštěv</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-gray-600">
            <thead class="bg-gray-50 text-gray-700">
                <tr>
                    <th class="px-6 py-3">Datum a Čas</th>
                    <th class="px-6 py-3">IP / Lokace</th>
                    <th class="px-6 py-3">Zařízení / OS / Prohlížeč</th>
                    <th class="px-6 py-3">Rozlišení</th>
                    <th class="px-6 py-3">Doba</th>
                    <th class="px-6 py-3">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php foreach($recentSessions as $s): ?>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap"><?= $s['created_at'] ?></td>
                    <td class="px-6 py-4">
                        <div class="font-medium text-gray-900"><?= $s['ip_address'] ?></div>
                        <div class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                            <?php if($s['flag']): ?>
                                <img src="https://flagcdn.com/w20/<?= $s['flag'] ?>.png" alt="flag" class="h-3">
                            <?php endif; ?>
                            <?= htmlspecialchars($s['city']) ?>, <?= htmlspecialchars($s['country']) ?>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-medium"><?= $s['device'] ?> / <?= $s['os'] ?></div>
                        <div class="text-xs text-gray-500 mt-1"><?= $s['browser'] ?></div>
                    </td>
                    <td class="px-6 py-4"><?= $s['resolution'] ?></td>
                    <td class="px-6 py-4"><?= $s['total_time_spent'] ?>s</td>
                    <td class="px-6 py-4 flex flex-col gap-1 items-start">
                        <?php if($s['is_bot']): ?>
                            <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-[10px] font-bold tracking-wider">BOT</span>
                        <?php else: ?>
                            <span class="px-2 py-1 bg-purple-100 text-purple-700 rounded text-[10px] font-bold tracking-wider">ČLOVĚK</span>
                        <?php endif; ?>

                        <?php if($s['is_new_visitor']): ?>
                            <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-[10px] font-bold tracking-wider">NOVÝ</span>
                        <?php else: ?>
                            <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-[10px] font-bold tracking-wider">OPAKUJÍCÍ</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require 'footer.php'; ?>
