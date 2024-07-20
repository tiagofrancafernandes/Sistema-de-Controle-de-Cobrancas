<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Web\MiniGameController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'tenant' => tenant(),
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('base_home');

Route::get('/another', fn () => 'another web')->name('teste');

Route::get('/homepage', fn () => redirect()->route('base_home'))->name('home');

Route::get('/tailadmin/{path}', function (string $path) {
    $path = trim(substr($path, 0, str_ends_with($path, '-view') ? -5 : null), '/\\');
    $path = trim(substr($path, 0, str_ends_with($path, 'View') ? -4 : null), '/\\');

    $file = str($path)?->replace('//', '/')?->ltrim('/\\')?->rtrim('/\\')?->afterLast('/')?->append('View')?->studly();

    $newPath = str(substr_count($path, '/') ? $path : '')
            ?->ltrim('/\\')
            ?->rtrim('/\\')
            ?->beforeLast('/')
            ?->append('/' . $file)
            ?->replace('//', '/')
            ?->toString();

    $newPath = str(
        implode('/', array_map(fn ($item) => str($item)->studly(), explode('/', $newPath)))
    )
            ?->prepend('tailadmin/')
            ?->replace('//', '/')
            ?->toString();

    return Inertia::render($newPath, [
        'path' => $path,
        'newPath' => $newPath,
    ]);
})?->where('path', '.*')?->name('tailadmin_view');

Route::get('/tables', function () {
    return Inertia::render('tailadmin/TablesView', [
        //
    ]);
})?->name('tables');

Route::get('/dashboard', fn () => Inertia::render('Dashboard'))->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('mini-game')->name('mini_game.')->group(function () {
    Route::get('{game}/play', [MiniGameController::class, 'play'])->name('play');
});

require __DIR__ . '/auth.php';

Route::get('/__open-in-editor', function (Illuminate\Http\Request $request) {
    $filePath = $request->input('file');

    //     //__open-in-editor
    return <<<'BLADE'
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Open on Editor</title>
</head>
<body>
<script>
    (() => {
        let searchParams = new URLSearchParams(window.location.search);
        let file = searchParams.get('file');

        if (!file || !file.trim()) {
            // window.close();
            return;
        }

        window.location.href = 'vscode://file/' + encodeURIComponent(file);
        // window.close();
    })();
</script>
</body>
</html>
BLADE;
})->name('dev.open-in-editor');
