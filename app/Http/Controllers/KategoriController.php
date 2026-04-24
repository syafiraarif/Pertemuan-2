<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\Product; // Wajib dipanggil untuk dropdown produk

class KategoriController extends Controller
{
    public function index()
    {
        // Gunakan 'products' (jamak) sesuai dengan fungsi di model Kategori
        $kategoris = Kategori::with('products')->get(); 
        
        return view('kategori.index', compact('kategoris'));
    }

    public function create()
    {
        // Hapus pengambilan data produk, karena kita hanya buat nama kategori
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        // Cukup validasi 'name' saja, karena kategori berdiri sendiri
        $request->validate([
            'name' => 'required|string|max:255|unique:kategoris,name',
        ]);

        Kategori::create([
            'name' => $request->name,
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function show($id)
    {
        $kategori = Kategori::with('product')->findOrFail($id);
        return view('kategori.view', compact('kategori'));
    }

    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);
        // Cukup kirim kategori saja
        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        // 1. Hapus validasi product_id karena kategori sekarang berdiri sendiri
        $request->validate([
            'name' => 'required|string|max:255|unique:kategoris,name,' . $id,
        ]);

        // 2. Cari data kategori
        $kategori = Kategori::findOrFail($id);

        // 3. Update hanya kolom name saja
        $kategori->update([
            'name' => $request->name,
        ]);

        // 4. Redirect dengan pesan sukses
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diupdate!');
    }

    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus!');
    }
}