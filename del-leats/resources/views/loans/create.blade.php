@extends('layouts.app')

@section('title', 'Ajukan Peminjaman')

@section('content')
<section class="form-box">
    <h2 style="margin-bottom:16px;">Formulir Pengajuan Peminjaman</h2>

    <form method="POST" action="{{ route('loans.store') }}">
        @csrf

        <div class="form-group">
            <label>Pilihan Perangkat</label>
            <select name="equipment_id" class="@error('equipment_id') is-invalid @enderror">
                <option value="">-- Pilih Perangkat --</option>
                @foreach ($equipments as $eq)
                    <option value="{{ $eq->id }}" {{ old('equipment_id', $selected) == $eq->id ? 'selected' : '' }}>
                        {{ $eq->asset_code }} - {{ $eq->name }} ({{ $eq->status_label }})
                    </option>
                @endforeach
            </select>
            @error('equipment_id') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label>Nama Peminjam</label>
            <input type="text" name="borrower_name" value="{{ old('borrower_name') }}" class="@error('borrower_name') is-invalid @enderror">
            @error('borrower_name') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label>NIM Mahasiswa</label>
            <input type="text" name="borrower_nim" value="{{ old('borrower_nim') }}" maxlength="10" class="@error('borrower_nim') is-invalid @enderror">
            @error('borrower_nim') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label>Surel Mahasiswa</label>
            <input type="text" name="borrower_email" value="{{ old('borrower_email') }}" class="@error('borrower_email') is-invalid @enderror">
            @error('borrower_email') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label>Tanggal Pinjam</label>
            <input type="date" name="loan_date" value="{{ old('loan_date') }}" class="@error('loan_date') is-invalid @enderror">
            @error('loan_date') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label>Rencana Tanggal Kembali (maks 7 hari)</label>
            <input type="date" name="expected_return_date" value="{{ old('expected_return_date') }}" class="@error('expected_return_date') is-invalid @enderror">
            @error('expected_return_date') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label>Tujuan Peminjaman</label>
            <textarea name="purpose" rows="3" class="@error('purpose') is-invalid @enderror">{{ old('purpose') }}</textarea>
            @error('purpose') <div class="error">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Ajukan Peminjaman</button>
    </form>
</section>
@endsection

