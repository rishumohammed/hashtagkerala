<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$h = App\Models\Hotel::where('name', 'like', '%Lake Crest Houseboat%')->first();
if($h){ 
    $h->image_path = null;
    $h->save(); 
    echo 'Cleared main featured image for Lake Crest Houseboat'; 
} else {
    echo 'Hotel not found';
}
