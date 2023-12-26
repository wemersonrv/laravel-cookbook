<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('upload:cleanup', function () {
    $this->info('Cleaning up the temp uploads folder...');

    $files = Storage::disk('public')->listContents('temp');

    $deleted = collect($files)
        ->filter(function($file) {
            return $file['type'] === 'file' && $file['lastModified'] < now()->subDays(1)->getTimestamp();
        })
        ->each(function($file) use(&$c){
            Storage::disk('public')->delete($file['path']);
        })->count();

    $this->info("$deleted file(s) have been deleted on " . now());
})->purpose('Cleanup the temp uploads folder');
