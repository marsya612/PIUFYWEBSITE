@extends('layouts.app')

@section('content')

<div class="container p-4">
    <h4 class="fw-semibold mb-3">Notifikasi Pengingat</h4>

    <div class="card shadow-sm border-0">
        <div class="card-body">

            @forelse($notifikasi as $item)
                <div class="border-bottom py-2">
                    <strong>{{ $item->nama_klien }}</strong><br>
                    {{ $item->nama_proyek }}<br>

                    <span class="text-muted">
                        Jatuh tempo {{ $item->sisaHari }} hari lagi
                    </span>
                </div>
            @empty
                <div class="text-center text-muted">
                    Tidak ada notifikasi
                </div>
            @endforelse

        </div>
    </div>
</div>

@endsection