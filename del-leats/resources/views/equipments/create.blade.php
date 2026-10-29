@extends('layouts.app')

@section('title', 'Tambah Aset')

@section('content')
<section class="form-box">
    <h2 style="margin-bottom:16px;">Tambah Aset Baru</h2>

    <form method="POST" action="{{ route('equipments.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label>Kategori Perangkat</label>
            <select name="category_id" class="@error('category_id') is-invalid @enderror">
                <option value="">Pilih Kategori</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
            @error('category_id') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label>Kode Aset Inventaris (EQ-KODE-NOMOR)</label>
            <input type="text" name="asset_code" value="{{ old('asset_code') }}" placeholder="EQ-IOT-005" class="@error('asset_code') is-invalid @enderror">
            @error('asset_code') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label>Nama Perangkat</label>
            <input type="text" name="name" value="{{ old('name') }}" class="@error('name') is-invalid @enderror">
            @error('name') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label>Spesifikasi Teknis</label>
            <textarea name="specification" rows="4" class="@error('specification') is-invalid @enderror">{{ old('specification') }}</textarea>
            @error('specification') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label>Kondisi Fisik</label>
            <select name="condition" class="@error('condition') is-invalid @enderror">
                @foreach (['baik' => 'Baik', 'rusak_ringan' => 'Rusak Ringan', 'rusak_berat' => 'Rusak Berat'] as $val => $label)
                    <option value="{{ $val }}" {{ old('condition', 'baik') == $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            @error('condition') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label>Tarif Kompensasi Harian (Rp)</label>
            <input type="number" name="daily_rental_fee" min="0" value="{{ old('daily_rental_fee') }}" class="@error('daily_rental_fee') is-invalid @enderror">
            @error('daily_rental_fee') <div class="error">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Simpan Aset</button>
    </form>
</section>
@endsection