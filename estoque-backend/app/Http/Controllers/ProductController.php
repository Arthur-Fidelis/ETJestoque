<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $products = Product::query();

    if ($request->has('nome')) {
        $products->where('nome', 'like', '%' . $request->nome . '%');
    }

    return response()->json($products->get());
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'nome' => 'required|string|max:255',
        'quantidade' => 'required|integer|min:0',
        'categoria' => 'required|string|max:255',
        'preco' => 'required|numeric|min:0',
    ]);

    $product = Product::create($validated);

    return response()->json($product, 201);
}

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return response()->json(Product::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $product = Product::findOrFail($id);

    $validated = $request->validate([
        'nome' => 'required|string|max:255',
        'quantidade' => 'required|integer|min:0',
        'categoria' => 'required|string|max:255',
        'preco' => 'required|numeric|min:0',
    ]);

    $product->update($validated);

    return response()->json($product);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    $product = Product::findOrFail($id);

    $product->delete();

    return response()->json([
        'message' => 'Produto removido com sucesso'
    ]);
}
}
