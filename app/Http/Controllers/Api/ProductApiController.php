<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProductApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $products = Product::with('kategori')->get(); 
            return response()->json([
                'message' => 'Data product berhasil diambil',
                'data' => $products
            ], 200);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Di dalam method store() dan update() pada ProductApiController.php
            $validated = $request->validate([
                'name' => 'required|string',
                'price' => 'required|numeric',
                'quantity' => 'required|integer',
                'category_id' => 'required|exists:kategoris,id', 
            ]);

            $validated['user_id'] = Auth::id(); // Ambil ID user yang login (dari token)

            $product = Product::create($validated);

            return response()->json([
                'message' => 'Produk berhasil ditambahkan!!',
                'data' => $product,
            ], 201);
        } catch (\Throwable $e) {
            Log::error('Error saat menambah product', ['message' => $e->getMessage()]);
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        try {
            $product = Product::with('kategori')->find($id);

            if (!$product) {
                return response()->json(['message' => 'Product tidak ditemukan'], 404);
            }

            return response()->json([
                'message' => 'Product retrieved successfully',
                'data' => $product
            ], 200);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
public function update(Request $request, int $id)
    {
        try {
            $product = Product::find($id);

            if (!$product) {
                return response()->json(['message' => 'Product tidak ditemukan'], 404);
            }

            // Di dalam method store() dan update() pada ProductApiController.php
            $validated = $request->validate([
                'name' => 'required|string',
                'price' => 'required|numeric',
                'quantity' => 'required|integer',
                'category_id' => 'required|exists:kategoris,id', 
            ]);
                        
            $product->update($validated);

            return response()->json([
                'message' => 'Produk berhasil diupdate!!',
                'data' => $product,
            ], 200);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {
            $product = Product::find($id);

            if (!$product) {
                return response()->json(['message' => 'Product tidak ditemukan'], 404);
            }

            $product->delete();

            return response()->json(['message' => 'Produk berhasil dihapus!!'], 200);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }
}
