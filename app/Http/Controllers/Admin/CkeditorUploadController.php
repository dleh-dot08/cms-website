<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CkeditorUploadController extends Controller
{
    public function store(Request $request)
    {
        // CKEditor biasanya kirim field "upload"
        $file = $request->file('upload') ?? $request->file('file');

        if (!$file) {
            return response()->json([
                'message' => 'File tidak ditemukan di request (field upload/file).'
            ], 422);
        }

        // Naikkan limit jadi 5MB biar aman untuk mockup/infografis
        $request->validate([
            'upload' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:5120'],
            'file'   => ['nullable','image','mimes:jpg,jpeg,png,webp','max:5120'],
        ]);

        $filename = Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();

        // simpan ke storage/app/public/posts/konten
        $path = $file->storeAs('public/posts/konten', $filename);

        $url = asset('storage/' . str_replace('public/', '', $path));

        return response()->json(['url' => $url], 201);
    }
}
