<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PelangganController extends Controller
{
    public function index(Request $request)
    {
        $pelanggan = Pelanggan::all();

        if($request->ajax()) {
            return DataTables::of($pelanggan)->make(true);
        }
        return view('pelanggan.index', compact('pelanggan'));
    }

    public function create()
    {
        return view('pelanggan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'tipe' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'notelp' => 'required|string|max:15',
        ]);

        Pelanggan::create([
            'nama_pelanggan' => $request->nama_pelanggan,
            'tipe' => $request->tipe,
            'alamat' => $request->alamat,
            'notelp' => $request->notelp,
        ]);

        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        return view('pelanggan.edit', compact('pelanggan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'tipe' => 'required|in:Reguler,VIP,VVIP',
            'alamat' => 'nullable|string',
            'notelp' => 'required|string|max:15',
            'poin' => 'integer|min:0',
        ]);

        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->update([
            'nama_pelanggan' => $request->nama_pelanggan,
            'tipe' => $request->tipe,
            'alamat' => $request->alamat,
            'notelp' => $request->notelp,
            'poin' => $request->poin,
        ]);

        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->delete();

        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil dihapus.');
    }
    public function show($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        return view('pelanggan.show', compact('pelanggan'));
    }
}
