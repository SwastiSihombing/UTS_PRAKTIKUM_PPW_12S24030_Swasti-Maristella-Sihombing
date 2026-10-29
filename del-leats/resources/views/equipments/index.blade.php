@extends('layouts.app')

@section('title', 'Katalog Aset')

@section('content')
<section>
    <h2 style="margin-bottom:12px;">Katalog Aset Laboratorium</h2>

    <form method="GET" action="{{ route('equipments.index') }}" class="filter">
        <input type="text" name="search" placeholder="Cari nama / kode aset..." value="{{ request('search') }}">
        <select name="category_id">
            <option value="">Semua Kategori</option>
            @foreach ($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>
        <select name="status">
            @foreach (['semua' => 'Semua Status', 'tersedia' => 'Tersedia', 'dipinjam' => 'Dipinjam', 'dalam_perbaikan' => 'Dalam Perbaikan'] as $val => $label)
                <option value="{{ $val }}" {{ request('status', 'semua') == $val ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-primary">Cari</button>
    </form>

    <p style="margin-bottom:12px;color:#4b5563;">
        Menampilkan {{ $equipments->count() }} dari {{ $equipments->total() }} hasil
        @if (request('search')) pencarian untuk kata kunci "{{ request('search') }}" @endif
    </p>

    <div class="grid">
        @forelse ($equipments as $eq)
            <article class="card">
                @if ($eq->image_path)
                    <img src="{{ asset('storage/' . $eq->image_path) }}" alt="{{ $eq->name }}">
                @else
                    <div class="noimg">Tidak ada foto</div>
                @endif
                <div class="card-body">
                    <small>{{ $eq->asset_code }}</small>
                    <h3 style="font-size:16px;">{{ $eq->name }}</h3>
                    <div>{{ $eq->category->name }}</div>
                    <div><span class="badge badge-{{ $eq->status }}">{{ $eq->status_label }}</span></div>
                    <div>Rp {{ number_format($eq->daily_rental_fee, 0, ',', '.') }} / hari</div>
                    <div class="card-actions">
                        <a href="{{ route('equipments.show', $eq->id) }}" class="btn btn-outline">Detail Spesifikasi</a>
                        @if ($eq->status === 'tersedia')
                            <a href="{{ route('loans.create', ['equipment_id' => $eq->id]) }}" class="btn btn-primary">Ajukan Peminjaman</a>
                        @else
                            <span class="btn btn-disabled">Tidak Tersedia</span>
                        @endif
                    </div>
                </div>
            </article>
        @empty
            <p>Tidak ada perangkat yang cocok.</p>
        @endforelse
    </div>

    <div class="pagination-wrap">
        {{ $equipments->links() }}
    </div>
</section>
@endsection