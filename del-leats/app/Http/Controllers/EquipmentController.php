<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EquipmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Equipment::with('category');

        if ($request->filled('search')) {
            $keyword = $request->search;
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                  ->orWhere('asset_code', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status', $request->status);
        }

        $equipments = $query->latest('id')
                            ->paginate(6)
                            ->appends(request()->query());

        $categories = Category::orderBy('name')->get();

        return view('equipments.index', compact('equipments', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('equipments.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id'      => 'required|exists:categories,id',
            'asset_code'       => 'required|max:20|unique:equipments,asset_code',
            'name'             => 'required|min:5|max:150',
            'specification'    => 'nullable|string',
            'condition'        => 'required|in:baik,rusak_ringan,rusak_berat',
            'daily_rental_fee' => 'required|numeric|min:0',
        ], [
            'asset_code.unique' => 'Kode aset sudah terdaftar.',
            'name.min'          => 'Nama perangkat minimal 5 karakter.',
        ]);

        $equipment = Equipment::create([
            'category_id'      => $validated['category_id'],
            'asset_code'       => $validated['asset_code'],
            'name'             => $validated['name'],
            'specification'    => $validated['specification'] ?? null,
            'condition'        => $validated['condition'],
            'status'           => 'tersedia',
            'daily_rental_fee' => (int) $validated['daily_rental_fee'],
            'image_path'       => $path,
        ]);

        return redirect()->route('equipments.index')->with('success',
            "Perangkat '{$equipment->name}' (Kode: {$equipment->asset_code}) berhasil didaftarkan!");
    }

    public function show($id)
    {
        $equipment = Equipment::with(['category', 'loanRequests' => fn ($q) => $q->latest()])
                              ->findOrFail($id);
        return view('equipments.show', compact('equipment'));
    }
}
