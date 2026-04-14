<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index(Request $request)
    {
        $query = Buku::with('kategori');

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhere('pengarang', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        $bukus = $query->paginate(8);
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        $isFiltered = $request->filled('search') || $request->filled('kategori');

        return view('page.index', compact('bukus', 'kategoris', 'isFiltered'));
    }

    public function detail($id)
    {
        $buku = Buku::with('kategori')->findOrFail($id);
        
        $relatedBooks = Buku::with('kategori')
            ->where('kategori_id', $buku->kategori_id)
            ->where('id', '!=', $buku->id)
            ->limit(4)
            ->get();
        
        return view('page.detail', compact('buku', 'relatedBooks'));
    }
}