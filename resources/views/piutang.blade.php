@extends('layouts.app')

@section('title', 'Manajemen Piutang')

@section('content')


<div class="p-4">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-semibold">Manajemen Piutang</h4>

        <button 
            type="button"
            onclick="window.location='{{ route('piutang.create') }}'"
            class="btn btn-dark rounded-pill px-3">
            <i class="bi bi-plus"></i> Tambah Tagihan
        </button>
    </div>

    <!-- FILTER -->
    <form method="GET" action="{{ route('piutang.index') }}" class="d-flex gap-2 mb-3">

        <input 
            type="text" 
            name="search"
            value="{{ request('search') }}"
            class="form-control" 
            placeholder="Cari klien, proyek, atau no tagihan..."
            oninput="clearTimeout(window.searchTimer); window.searchTimer = setTimeout(() => this.form.submit(), 500)">

        <select name="status" class="form-select w-auto" onchange="this.form.submit()">
            <option value="">Semua Status</option>
            <option value="tertunggak" {{ request('status') == 'tertunggak' ? 'selected' : '' }}>Tertunggak</option>
            <option value="segera" {{ request('status') == 'segera' ? 'selected' : '' }}>Segera</option>
            <option value="belum" {{ request('status') == 'belum' ? 'selected' : '' }}>Belum Tempo</option>
            <option value="lunas" {{ request('status') == 'lunas' ? 'selected' : '' }}>Lunas</option>
        </select>

        <select name="klien" class="form-select w-auto" onchange="this.form.submit()">
            <option value="">Semua Klien</option>
            @foreach ($klienList as $klien)
                <option value="{{ $klien }}" {{ request('klien') == $klien ? 'selected' : '' }}>
                    {{ $klien }}
                </option>
            @endforeach
        </select>

    </form>

    <!-- TABLE -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>No. Tagihan</th>
                            <th>Klien</th>
                            <th>Proyek</th>
                            <th>Termin</th>
                            <th>Metode Pembayaran</th>
                            <th class="text-end">Nilai (Rp)</th>
                            <th>Tanggal Terbit</th>
                            <th>Jatuh Tempo</th>
                            <th>Sisa Hari</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($piutangs as $item)

                            @php
                                $today = \Carbon\Carbon::today();
                                $jatuhTempo = \Carbon\Carbon::parse($item->tanggal_jatuh_tempo);
                                $sisaHari = $today->diffInDays($jatuhTempo, false);
                            @endphp

                            <tr>
                                <td>{{ $item->no_tagihan }}</td>
                                <td>{{ $item->nama_klien }}</td>
                                <td>{{ $item->nama_proyek }}</td>
                                <td>{{ $item->termin }}</td>
                                <td>{{ $item->metode_pembayaran }}</td>

                                <td class="text-end">
                                    {{ number_format($item->nilai_tagihan ?? 0, 0, ',', '.') }}
                                </td>

                                <td>
                                    {{ \Carbon\Carbon::parse($item->tanggal_terbit)->format('d M Y') }}
                                </td>

                                <td>
                                    {{ \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->format('d M Y') }}
                                </td>

                                <!-- SISA HARI -->
                                <td>
                                    @if ($item->status === 'lunas')
                                        <span class="text-muted">-</span>

                                    @else
                                        @php
                                            $today = \Carbon\Carbon::today();
                                            $jatuhTempo = \Carbon\Carbon::parse($item->tanggal_jatuh_tempo);
                                            $sisaHari = $today->diffInDays($jatuhTempo, false);
                                        @endphp

                                        @if ($sisaHari < 0)
                                            <span class="badge bg-danger">{{ abs($sisaHari) }} hari lewat</span>

                                        @elseif ($sisaHari == 0)
                                            <span class="badge bg-danger">Hari ini</span>

                                        @elseif ($sisaHari <= 7)
                                            <span class="badge bg-warning text-dark">{{ $sisaHari }} hari lagi</span>

                                        @else
                                            <span class="badge bg-success">{{ $sisaHari }} hari lagi</span>
                                        @endif
                                    @endif
                                </td>

                                
                                <!-- STATUS -->
                                <td>
                                    @if ($item->status === 'lunas')
                                        <span class="badge bg-success">Lunas</span>

                                    @else
                                        @php
                                            $today = \Carbon\Carbon::today();
                                            $jatuhTempo = \Carbon\Carbon::parse($item->tanggal_jatuh_tempo);
                                            $sisaHari = $today->diffInDays($jatuhTempo, false);
                                        @endphp

                                        @if ($sisaHari < 0)
                                            <span class="badge bg-secondary">Tertunggak</span>

                                        @elseif ($sisaHari <= 7)
                                            <span class="badge bg-warning text-dark">Segera</span>

                                        @else
                                            <span class="badge bg-light text-dark">Belum Tempo</span>
                                        @endif
                                    @endif
                                </td>
                                

                                <!-- AKSI -->
                                <td>
                                    <div class="d-flex gap-2 align-items-center">

                                        <!-- EDIT -->
                                        <a href="{{ route('piutang.edit', $item->id) }}" class="text-primary">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <!-- LUNAS -->
                                        @if ($item->status !== 'lunas')
                                            <form action="{{ route('piutang.lunas', $item->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')

                                                <button type="submit"
                                                    class="btn p-0 text-success border-0 bg-transparent"
                                                    onclick="return confirm('Tandai piutang sebagai lunas?')">
                                                    <i class="bi bi-check-circle"></i>
                                                </button>
                                            </form>
                                        @endif

                                        <!-- DELETE -->
                                        <form action="{{ route('piutang.destroy', $item->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin hapus data?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="btn p-0 text-danger border-0 bg-transparent">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>

                            </tr>

                        @empty
                            <tr>
                                <td colspan="11" class="text-center">Belum ada data</td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>

@endsection