<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ParticipantController extends Controller
{
    public function index()
    {
        $participants = User::where('role', User::ROLE_PARTICIPANT)
            ->latest()
            ->paginate(15);

        return view('admin.peserta.index', compact('participants'));
    }

    public function create()
    {
        return view('admin.peserta.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'email' => ['required','email','max:255', Rule::unique('users','email')],
            'password' => ['required','string','min:8'],
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => User::ROLE_PARTICIPANT, // KUNCI: peserta selalu participant
        ]);

        return redirect()->route('admin.peserta.index')->with('success', 'Peserta berhasil ditambahkan.');
    }

    public function destroy(User $user)
    {
        // biar aman, jangan sampai hapus selain peserta
        abort_unless($user->role === User::ROLE_PARTICIPANT, 403);

        $user->delete();
        return back()->with('success', 'Peserta dihapus.');
    }
}

