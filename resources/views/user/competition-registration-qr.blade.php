@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 p-6 gap-8">
            {{-- <form action="{{ route('admin.dashboard.registration.update') }}" method="POST" enctype="multipart/form-data"
                class="mx-auto max-w-xl"> --}}
            <div class="mx-auto max-w-xl">
                @if(isset($qrCode))
                    <div class="text-center flex flex-col justify-center items-center">
                        {{ $qrCode }}
                        <h1 class="mt-4 text-gray-600 dark:text-gray-300 text-2xl font-bold">{{ $data->registration_number }}</h1>
                        <p class="mt-4 text-gray-600 dark:text-gray-300">Tunjukkan QR Code ini saat registrasi ulang.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
