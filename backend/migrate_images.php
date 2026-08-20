<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

foreach (App\Models\Hotel::all() as $h) {
    $u = $h->images->pluck('url')->toArray();
    $g = is_array($h->gallery) ? $h->gallery : [];
    $m = array_unique(array_merge($g, $u));
    $h->gallery = array_values($m);
    $h->save();
}
echo "Done\n";
