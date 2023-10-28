<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        {{-- <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" /> --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Rock+Salt&display=swap" rel="stylesheet">
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="antialiased">
        <div class="relative min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
            <div class="flex space-x-2 items-center justify-start px-6 pt-3">
                <div><img src="/logo.png" alt="Bear SQL" class="block mx-auto h-20"></div>
                <div class="font-bold text-2xl text-white/70 transition ease-in-out hover:text-white" style="font-family: 'Rock Salt', serif">
                    <span>Bear</span>
                    <span class="ml-2 text-lg opacity-40">SQL</span>
                </div>
            </div>
            <div class="max-w-7xl w-full mx-auto p-6 lg:p-8 pt-0 lg:pt-0">
                <livewire:query-editor :connection="App\Models\Connection::first()" />
            </div>
        </div>
    </body>
</html>
