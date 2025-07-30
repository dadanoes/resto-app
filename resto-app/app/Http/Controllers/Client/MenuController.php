<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display the menu page
     */
    public function index(Request $request)
    {
        $categories = Category::where('is_active', true)->with(['products' => function($query) {
            $query->where('is_available', true);
        }])->get();

        $selectedCategory = $request->get('category');
        
        if ($selectedCategory) {
            $products = Product::where('is_available', true)
                ->where('category_id', $selectedCategory)
                ->with('category')
                ->orderBy('name')
                ->get();
        } else {
            $products = Product::where('is_available', true)
                ->with('category')
                ->orderBy('name')
                ->get();
        }

        return view('client.menu.index', compact('categories', 'products', 'selectedCategory'));
    }

    /**
     * Display products by category
     */
    public function category($id)
    {
        $category = Category::where('is_active', true)->findOrFail($id);
        $products = Product::where('is_available', true)
            ->where('category_id', $id)
            ->with('category')
            ->orderBy('name')
            ->get();

        return view('client.menu.category', compact('category', 'products'));
    }

    /**
     * Display product details
     */
    public function show($id)
    {
        $product = Product::where('is_available', true)
            ->with('category')
            ->findOrFail($id);

        $relatedProducts = Product::where('is_available', true)
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(4)
            ->get();

        return view('client.menu.show', compact('product', 'relatedProducts'));
    }

    /**
     * Search products
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        
        $products = Product::where('is_available', true)
            ->where(function($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            })
            ->with('category')
            ->orderBy('name')
            ->get();

        $categories = Category::where('is_active', true)->get();

        return view('client.menu.search', compact('products', 'categories', 'query'));
    }
}
