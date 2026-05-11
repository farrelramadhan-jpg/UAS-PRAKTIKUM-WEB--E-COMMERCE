<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    public function index()
    {
        return view('admin.products.index');
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        // For now, just redirect back with success message
        return redirect()->route('products.index')->with('success', 'Product created successfully!');
    }

    public function edit($id)
    {
        return view('admin.products.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        // For now, just redirect back with success message
        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        // For now, just redirect back with success message
        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }
}