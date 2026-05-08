<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $categories = Kategori::all();
            return response()->json([
                'message' => 'Data category berhasil diambil',
                'data' => $categories
            ], 200); // 200 OK
        } catch (\Throwable $e) {
            Log::error('Error get category', ['message' => $e->getMessage()]);
            return response()->json(['message' => 'Internal Server Error'], 500); // 500 Error[cite: 1]
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                // Tambahkan field lain sesuai struktur table categories kamu
            ]);

            $category = Kategori::create($validated);

            Log::info('Menambah data category', ['data' => $category]);

            return response()->json([
                'message' => 'Category berhasil ditambahkan!!',
                'data' => $category,
            ], 201); // 201 Created[cite: 1]
        } catch (\Throwable $e) {
            Log::error('Error saat menambah category', ['message' => $e->getMessage()]);
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $category = Kategori::find($id);

            if (!$category) {
                return response()->json(['message' => 'Category tidak ditemukan'], 404); // 404 Not Found[cite: 1]
            }

            return response()->json([
                'message' => 'Category retrieved successfully',
                'data' => $category
            ], 200);
        } catch (\Throwable $e) {
            Log::error('Error get category', ['message' => $e->getMessage()]);
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $category = Kategori::find($id);

            if (!$category) {
                return response()->json(['message' => 'Category tidak ditemukan'], 404);
            }

            $validated = $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $category->update($validated);

            return response()->json([
                'message' => 'Category berhasil diupdate!!',
                'data' => $category,
            ], 200);
        } catch (\Throwable $e) {
            Log::error('Error update category', ['message' => $e->getMessage()]);
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
public function destroy($id)
    {
        try {
            $category = Kategori::find($id);

            if (!$category) {
                return response()->json(['message' => 'Category tidak ditemukan'], 404);
            }

            $category->delete();

            return response()->json([
                'message' => 'Category berhasil dihapus!!'
            ], 200); // Atau bisa pakai 204 No Content sesuai standar[cite: 1]
        } catch (\Throwable $e) {
            Log::error('Error delete category', ['message' => $e->getMessage()]);
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }
}

