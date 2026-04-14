<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AnggotaController extends Controller
{
    public function index(Request $request)
{
    $search = $request->input('search');

    $anggotas = Anggota::with('user')
        ->when($search, function ($query) use ($search) {
            $query->where('nis', 'LIKE', "%{$search}%")
                  ->orWhere('kelas', 'LIKE', "%{$search}%")
                  ->orWhereHas('user', function ($q) use ($search) {
                      $q->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%");
                  });
        })
        ->paginate(10)
        ->withQueryString(); 

    return view('anggota.index', compact('anggotas'));
}

    public function create()
    {
        return view('anggota.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'nis' => 'required|unique:anggotas',
            'kelas' => 'required',
            'no_tlp' => 'required',
            'jenis_kelamin' => 'required'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'Anggota'
        ]);

        Anggota::create([
            'user_id' => $user->id,
            'nis' => $request->nis,
            'kelas' => $request->kelas,
            'no_tlp' => $request->no_tlp,
            'jenis_kelamin' => $request->jenis_kelamin
        ]);

        return redirect()->route('anggota.index');
    }

    public function edit($id)
    {
        $anggota = Anggota::with('user')->findOrFail($id);
        return view('anggota.edit', compact('anggota'));
    }

    public function update(Request $request, $id)
    {
        $anggota = Anggota::findOrFail($id);

        $anggota->update([
            'nis' => $request->nis,
            'kelas' => $request->kelas,
            'no_tlp' => $request->no_tlp,
            'jenis_kelamin' => $request->jenis_kelamin
        ]);

        $anggota->user->update([
            'name' => $request->name,
            'email' => $request->email
        ]);

        return redirect()->route('anggota.index');
    }

    public function show($id)
    {
        $anggota = Anggota::with('user')->findOrFail($id);
        return view('anggota.show', compact('anggota'));
    }

    public function destroy($id)
    {
        $anggota = Anggota::findOrFail($id);
        $anggota->user->delete(); 
        return redirect()->route('anggota.index');
    }

    public function profile()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }
        $anggota = $user->anggota;

        if (!$anggota) {
            return "Anda login sebagai Admin atau data anggota belum dibuat.";
        }

        return view('user.profile', compact('anggota'));

    }
}