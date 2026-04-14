<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function index(Request $request)
{
    $search = $request->search;
    $bukus = Buku::with('kategori')
        ->when($search, function ($query) use ($search) {
            $query->where('judul', 'like', "%{$search}%")
                  ->orWhere('pengarang', 'like', "%{$search}%");
        })
        ->paginate(10); // Gunakan paginate

    return view('buku.index', compact('bukus'));
}

    public function create()
    {
        $kategoris = Kategori::all();
        return view('buku.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'judul' => 'required|string',
            'pengarang' => 'required|string',
            'tahun_terbit' => 'required|digits:4',
            'deskripsi' => 'required|string',
            'file_cover' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'stok' => 'required|integer|min:0',
        ]);

        // kalau ada file cover, simpan ke storage
        if ($request->hasFile('file_cover')) {
            $path = $request->file('file_cover')->store('cover', 'public');
            $validatedData['cover'] = $path;
        }

        // hapus file_cover dari array sebelum simpan ke DB
        unset($validatedData['file_cover']);

        Buku::create($validatedData);

        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan');
    }


    public function show(Buku $buku)
    {
        return view('buku.show', compact('buku'));
    }


    public function edit(Buku $buku)
    {
        $kategoris = Kategori::all();
        return view('buku.edit', compact('buku', 'kategoris'));
    }

    public function update(Request $request, Buku $buku)
    {
        $validatedData = $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'judul' => 'required|string',
            'pengarang' => 'required|string',
            'tahun_terbit' => 'required|digits:4',
            'deskripsi' => 'required|string',
            'file_cover' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'stok' => 'required|integer|min:0',
        ]);

        if ($request->hasFile('file_cover')) {

            if ($buku->cover && Storage::disk('public')->exists($buku->cover)) {
                Storage::disk('public')->delete($buku->cover);
            }

            $path = $request->file('file_cover')->store('cover', 'public');
            $validatedData['cover'] = $path;
        }

        unset($validatedData['file_cover']);

        $buku->update($validatedData);

        return redirect()->route('buku.index')->with('success', 'Buku berhasil diupdate');
    }

    public function destroy(Buku $buku)
    {
        if ($buku->cover && Storage::exists('public/' . $buku->cover)) {
            Storage::delete('public/' . $buku->cover);
        }

        $buku->delete();

        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus');
    }

}