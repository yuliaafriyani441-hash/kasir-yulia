<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class GuruController extends Controller
{
    public function index(Request $request)
    {
	    //Filter search
        $gurus = Guru::query()
            ->when($request->search, function ($query, $search) {
                $query->where('nama_guru', 'like', "%{$search}%")
                      ->orWhere('nip', 'like', "%{$search}%");
            })
            ->paginate(10); 

        return view('guru.index', compact('gurus'));
    }
    
     public function create()
    {
        return view('guru.create');
    }
    
    public function store(Request $request)
    {
        // Validasi sekaligus simpan hasilnya ke variabel $data
        $data = $request->validate([
            'nama_guru'       => 'required|string|max:255',
            'nis'             => 'required|string|unique:gurus|max:20',
            'mata_pelajaran'  => 'required|string|max:100',
            'jenis_kelamin'   => 'required|string|max:50',
            'email'           => 'nullable|email|unique:guru',
        ]);
        if($request->hasFile('foto')){
            $data['foto'] = $request->file('foto')->store('foto-guru', 'public');
        }

        // Simpan data langsung (tanpa perlu definisikan satu-satu)
        Gurus::create($data);

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil ditambahkan.');
    }
    
    public function edit(Gurus $guru)
    {
        return view('guru.edit',compact('guru'));
    }
    
    public function update(Request $request, Gurus $guru)
    {
        // Validasi data
        $data = $request->validate([
            'nama_guru'      => 'required|string|max:255',
            'nip'            => 'required|string|max:20|unique:gurus,nis,'.$guru->id, 
            'mata_pelajaran' => 'required|string|max:100',
            'jenis_kelamin'  => 'required|string|max:50',
            'email'          => 'nullable|email|unique:gurus,email,'.$guru->id,
        ]);
        if ($request->hasFile('foto')) {
            
            // Hapus foto LAMA jika ada
            if ($guru->foto && Storage::disk('public')->exists($guru->foto)) {
                Storage::disk('public')->delete($guru->foto);
            }

            $data['foto'] = $request->file('foto')->store('foto-guru', 'public');
        }

        // Update data langsung
        $guru->update($data);

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil diperbarui.');
    }
    
    public function show(Guru $guru)
    {
        return view('guru.show', compact('guru'));
    }
    
    public function destroy(Guru $guru)
    {
        if ($guru->foto && Storage::disk('public')->exists($guru->foto)) {
            Storage::disk('public')->delete($guru->foto);
        }

        $guru->delete();

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil dihapus.');
    }
    public function cetakPdf()
    {
        // 1. Ambil semua data guru
        $gurus = Guru::all();

        // 2. Load view khusus untuk PDF dan kirim datanya
        // Kita set ukuran kertas A4 dan orientasi landscape agar tabel muat
        $pdf = Pdf::loadView('guru.pdf', compact('gurus'))
                  ->setPaper('a4', 'landscape');

        // 3. Stream pdf ke browser (agar bisa dipreview dulu sebelum download)
        return $pdf->stream('laporan-data-guru.pdf');
    }
}
