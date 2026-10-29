<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'DEL-LEATS')</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; background: #f3f4f6; color: #1f2937; }
        header { background: #1e3a8a; color: #fff; padding: 16px 24px; }
        header h1 { font-size: 20px; }
        nav { display: flex; gap: 8px; flex-wrap: wrap; margin-top: 10px; }
        nav a { color: #dbeafe; text-decoration: none; padding: 6px 12px; border-radius: 6px; }
        nav a.active, nav a:hover { background: #fff; color: #1e3a8a; font-weight: bold; }
        main { max-width: 1100px; margin: 24px auto; padding: 0 16px; }
        footer { text-align: center; padding: 16px; color: #6b7280; font-size: 13px; }

        .alert { padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-weight: bold; }
        .alert-success { background: #DCFCE7; color: #166534; border: 1px solid #86efac; }
        .alert-danger  { background: #FEE2E2; color: #991B1B; border: 1px solid #fca5a5; }

        /* Grid responsif: 3 kolom desktop, 2 tablet, 1 ponsel */
        .grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
        @media (max-width: 992px) { .grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 600px) { .grid { grid-template-columns: 1fr; } }

        .card { background: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 1px 4px rgba(0,0,0,.1); display: flex; flex-direction: column; }
        .card img, .card .noimg { width: 100%; height: 170px; object-fit: cover; background: #e5e7eb; display: flex; align-items: center; justify-content: center; color: #9ca3af; }
        .card-body { padding: 14px; flex: 1; display: flex; flex-direction: column; gap: 6px; }
        .card-actions { display: flex; gap: 8px; margin-top: auto; padding-top: 8px; flex-wrap: wrap; }

        .badge { display: inline-block; padding: 3px 10px; border-radius: 999px; font-size: 12px; font-weight: bold; }
        .badge-tersedia        { background: #DCFCE7; color: #166534; }
        .badge-dipinjam        { background: #FEF9C3; color: #854D0E; }
        .badge-dalam_perbaikan { background: #FEE2E2; color: #991B1B; }

        .btn { display: inline-block; padding: 8px 14px; border-radius: 6px; border: none; cursor: pointer; text-decoration: none; font-size: 14px; }
        .btn-primary { background: #1e3a8a; color: #fff; }
        .btn-outline { background: #fff; color: #1e3a8a; border: 1px solid #1e3a8a; }
        .btn-disabled { background: #d1d5db; color: #6b7280; pointer-events: none; }

        .form-box { background: #fff; padding: 20px; border-radius: 10px; }
        .form-group { margin-bottom: 14px; }
        .form-group label { display: block; font-weight: bold; margin-bottom: 4px; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 8px; border: 1px solid #d1d5db; border-radius: 6px; }
        .is-invalid { border-color: #dc2626 !important; }
        .error { color: #dc2626; font-size: 13px; margin-top: 4px; }

        .filter { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 16px; }
        .filter input, .filter select { padding: 8px; border: 1px solid #d1d5db; border-radius: 6px; flex: 1; min-width: 150px; }

        .pagination-wrap { margin-top: 20px; }
        .pagination-wrap nav { margin: 0; }
        table { width: 100%; border-collapse: collapse; background: #fff; }
        th, td { padding: 10px; border-bottom: 1px solid #e5e7eb; text-align: left; font-size: 14px; }
    </style>
</head>
<body>
    <header>
        <h1>DEL-LEATS &mdash; Lab Equipment & Asset Tracking</h1>
        <nav>
            <a href="{{ route('equipments.index') }}"  class="{{ request()->routeIs('equipments.index', 'equipments.show') ? 'active' : '' }}">Katalog Aset</a>
            <a href="{{ route('equipments.create') }}" class="{{ request()->routeIs('equipments.create') ? 'active' : '' }}">Tambah Aset</a>
            <a href="{{ route('loans.create') }}"      class="{{ request()->routeIs('loans.create') ? 'active' : '' }}">Ajukan Pinjam</a>
            <a href="{{ route('loans.index') }}"       class="{{ request()->routeIs('loans.index') ? 'active' : '' }}">Riwayat Peminjaman</a>
        </nav>
    </header>

    <main>
        @if (session('success'))
            <div class="alert alert-success">[SUKSES] {{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">[GAGAL] Pengajuan tidak dapat diproses. Silakan periksa kembali seluruh masukan data Anda.</div>
        @endif

        @yield('content')
    </main>

    <footer>&copy; {{ date('Y') }} Laboratorium RPL & Jaringan - Institut Teknologi Del</footer>
</body>
</html>

