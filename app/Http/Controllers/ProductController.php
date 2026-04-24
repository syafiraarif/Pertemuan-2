<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreProductRequest;

class ProductController extends Controller
{
    // app/Http/Controllers/ProductController.php
    public function index()
    {
        // User hanya melihat produk yang SUDAH memiliki kategori sesuai permintaanmu
        $products = Product::has('kategori')->with('kategori', 'user')->get();

        return view('product.index', compact('products'));
    }

    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();

        $validated['user_id'] = auth()->id();

        Product::create($validated);

        return redirect()->route('product.index')->with('success', 'Product created successfully.');
    }

    public function create()
    {
        // Hapus pengambilan data User karena Owner otomatis adalah yang sedang login
        $categories = \App\Models\Kategori::orderBy('name')->get();

        return view('product.create', compact('categories'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);

        return view('product.view', compact('product'));
    }

    // ... (bagian atas tetap sama)
    public function update(StoreProductRequest $request, $id)
    {
        // 1. Cari produknya, bukan kategorinya
        $product = Product::findOrFail($id);

        // 2. Ambil data yang sudah divalidasi dari StoreProductRequest
        $validated = $request->validated();

        // 3. Update produknya
        $product->update($validated);

        return redirect()->route('product.index')->with('success', 'Product updated successfully.');
    }

    public function edit(Product $product)
    {
        // Mengambil semua data kategori untuk dropdown
        $categories = \App\Models\Kategori::orderBy('name')->get();

        // Kirim data product dan categories ke view
        return view('product.edit', compact('product', 'categories'));
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);

        $product->delete();

        return redirect()->route('product.index')->with('success', 'Product berhasil dihapus');
    }
}