<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\LoanRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class LoanController extends Controller
{
    public function index()
    {
        $loans = LoanRequest::with('equipment')->latest()->paginate(10);
        return view('loans.index', compact('loans'));
    }

    public function create(Request $request)
    {
        $equipments = Equipment::orderBy('asset_code')->get();
        $selected   = $request->query('equipment_id');
        return view('loans.create', compact('equipments', 'selected'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'equipment_id' => [
                'required', 'exists:equipments,id',
                function ($attr, $value, $fail) {
                    $eq = Equipment::find($value);
                    if ($eq && $eq->status !== 'tersedia') {
                        $label = $eq->status === 'dipinjam' ? 'sedang dipinjam' : 'dalam perbaikan';
                        $fail("Perangkat {$eq->name} saat ini {$label} dan tidak tersedia.");
                    }
                },
            ],
            'borrower_name'  => 'required|min:3|max:100',
            'borrower_nim'   => ['required', 'regex:/^[A-Za-z0-9]{8}$/'],
            'borrower_email' => 'required|email|max:100',
            'loan_date'      => 'required|date|after_or_equal:today',
            'expected_return_date' => [
                'required', 'date', 'after_or_equal:loan_date',
                function ($attr, $value, $fail) use ($request) {
                    try {
                        $start = Carbon::parse($request->loan_date);
                        $end   = Carbon::parse($value);
                        if ($start->diffInDays($end) > 7) {
                            $fail('Durasi peminjaman maksimal adalah 7 hari kalender.');
                        }
                    } catch (\Exception $e) {
                    }
                },
            ],
            'purpose' => 'required|string',
        ], [
            'equipment_id.required'   => 'Perangkat wajib dipilih.',
            'borrower_name.required'  => 'Nama peminjam wajib diisi minimal 3 karakter.',
            'borrower_name.min'       => 'Nama peminjam wajib diisi minimal 3 karakter.',
            'borrower_nim.required'   => 'Format NIM harus terdiri dari tepat 8 digit angka/huruf institusi.',
            'borrower_nim.regex'      => 'Format NIM harus terdiri dari tepat 8 digit angka/huruf institusi.',
            'borrower_email.required' => 'Format alamat surel yang Anda masukkan tidak valid.',
            'borrower_email.email'    => 'Format alamat surel yang Anda masukkan tidak valid.',
            'loan_date.after_or_equal' => 'Tanggal peminjaman tidak boleh sebelum tanggal hari ini.',
            'expected_return_date.after_or_equal' => 'Tanggal kembali tidak boleh sebelum tanggal pinjam.',
            'purpose.required'        => 'Tujuan peminjaman wajib diisi.',
        ]);
        $loan = DB::transaction(function () use ($request) {
            $equipment = Equipment::lockForUpdate()->findOrFail($request->equipment_id);

            if ($equipment->status !== 'tersedia') {
                throw ValidationException::withMessages([
                    'equipment_id' => "Perangkat {$equipment->name} baru saja dipinjam dan tidak tersedia.",
                ]);
            }

            $days = max(1, Carbon::parse($request->loan_date)
                                ->diffInDays(Carbon::parse($request->expected_return_date)));

            $loan = LoanRequest::create([
                'equipment_id'         => $equipment->id,
                'borrower_name'        => $request->borrower_name,
                'borrower_nim'         => $request->borrower_nim,
                'borrower_email'       => $request->borrower_email,
                'loan_date'            => $request->loan_date,
                'expected_return_date' => $request->expected_return_date,
                'purpose'              => $request->purpose,
                'status'               => 'diajukan',
                'total_estimated_fee'  => $days * $equipment->daily_rental_fee,
            ]);

            $equipment->update(['status' => 'dipinjam']);

            return $loan;
        });

        return redirect()->route('loans.index')->with('success',
            "Pengajuan peminjaman {$loan->equipment->name} berhasil! Estimasi biaya: Rp "
            . number_format($loan->total_estimated_fee, 0, ',', '.'));
    }
}


