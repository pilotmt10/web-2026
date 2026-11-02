<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Справочники')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-100 text-slate-900">
    <header class="bg-white border-b border-slate-200">
        <div class="mx-auto max-w-7xl px-4 py-4 flex flex-wrap items-center gap-4">
            <a href="{{ route('dict.index', 'calc-methods') }}" class="text-lg font-semibold tracking-tight">
                Справочники
            </a>
            <nav class="flex flex-wrap gap-2">
                @foreach (config('dictionaries') as $key => $config)
                    <a href="{{ route('dict.index', $key) }}"
                        class="rounded px-3 py-1.5 text-sm {{ request()->routeIs('dict.*') && request()->route('dictionary') === $key
                            ? 'bg-slate-900 text-white'
                            : 'text-slate-600 hover:bg-slate-100' }}">
                        {{ $config['title'] }}
                    </a>
                @endforeach
            </nav>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-4 py-6 space-y-4">
        @if (session('success'))
            <div class="rounded border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="rounded border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                <ul class="list-disc ps-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>
</body>

</html>
