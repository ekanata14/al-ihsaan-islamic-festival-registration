@props(['links' => []])

@php
    // 1. Tentukan Base Route (Home Link) berdasarkan Role
    $homeRoute = route('login');
    if (auth()->check()) {
        if (auth()->user()->role == 'admin') {
            $homeRoute = route('admin.dashboard');
        } elseif (auth()->user()->role == 'khitan' || request()->routeIs('khitan.*')) {
            $homeRoute = route('khitan.dashboard');
        } else {
            $homeRoute = route('user.dashboard');
        }
    }

    // 2. Generate Breadcrumb Otomatis Berdasarkan URL (Jika $links tidak diisi manual)
    if (empty($links)) {
        $segments = request()->segments();
        $cumulativeUrl = '';

        foreach ($segments as $index => $segment) {
            $cumulativeUrl .= '/' . $segment;

            // Skip kata 'admin', 'user', 'khitan', atau 'dashboard' jika berada di awal URL
            // Supaya tidak terjadi: Dashboard > Admin > Dashboard > Lomba
            if ($index <= 1 && in_array(strtolower($segment), ['admin', 'user', 'khitan', 'dashboard'])) {
                continue;
            }

            // Format label teks: Jika angka (ID), jadikan "Detail", jika teks, hilangkan strip (-)
            if (is_numeric($segment)) {
                $label = 'Detail';
            } else {
                $label = ucwords(str_replace(['-', '_'], ' ', $segment));
            }

            // Cegah duplikasi key array (tambah spasi kosong jika label sama)
            while (array_key_exists($label, $links)) {
                $label .= ' ';
            }

            $links[$label] = url($cumulativeUrl);
        }
    }
@endphp

<nav class="flex px-5 py-3 mb-6 bg-white border border-gray-100 rounded-2xl shadow-sm overflow-x-auto custom-scrollbar"
    aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-2 whitespace-nowrap">

        @foreach ($links as $label => $url)
            <li>
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd"></path>
                    </svg>

                    @if ($loop->last)
                        <span class="ml-1 md:ml-2 text-sm font-bold text-[#1D6594] cursor-default capitalize">
                            {{ trim($label) }}
                        </span>
                    @else
                        <a href="{{ $url }}"
                            class="ml-1 md:ml-2 text-sm font-medium text-gray-500 hover:text-[#1D6594] transition-colors duration-200 capitalize">
                            {{ trim($label) }}
                        </a>
                    @endif
                </div>
            </li>
        @endforeach

    </ol>
</nav>
