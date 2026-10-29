@extends('layouts.app')

@section('title', 'Riwayat Peminjaman')

@section('content')
<section>
    <h2 style="margin-bottom:12px;">Riwayat Peminjaman</h2>
    <div style="overflow-x:auto;">
        <table>
            <tr>
                <th>Perangkat</th><th>Peminjam</th><th>NIM</th><th>Periode</th><th>Estimasi Biaya</th><th>Status</th>
            </tr>
            @forelse ($loans as $loan)
                <tr>
                    <td>{{ $loan->equipment->asset_code }} - {{ $loan->equipment->name }}</td>
                    <td>{{ $loan->borrower_name }}</td>
                    <td>{{ $loan->borrower_nim }}</td>
                    <td>{{ $loan->loan_date->format('d/m/Y') }} - {{ $loan->expected_return_date->format('d/m/Y') }}</td>
                    <td>Rp {{ number_format($loan->total_estimated_fee, 0, ',', '.') }}</td>
                    <td>{{ ucfirst($loan->status) }}</td>
                </tr>
            @empty
                <tr><td colspan="6">Belum ada pengajuan peminjaman.</td></tr>
            @endforelse
        </table>
    </div>
    <div class="pagination-wrap">{{ $loans->links() }}</div>
</section>
@endsection

