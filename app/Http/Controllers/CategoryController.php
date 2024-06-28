<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    // Display all categories
    public function index(Request $request)
    {
        $query = Category::where('user_id', auth()->id());

        if ($search = $request->input('search')) {
            $query->where('name', 'LIKE', "%{$search}%");
        }

        // Check the requested route and adjust the query accordingly
        if ($request->is('dashboard')) {
            $categories = $query->get();
            return view('dashboard', compact('categories'));
        } else if ($request->is('categories')) {
            // Use pagination for 'categories.index'
            $categories = $query->paginate(5);
            return view('categories.index', compact('categories'));
        }
    }

    // Create a new category
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
    
        Category::create([
            'name' => $request->name,
            'user_id' => auth()->id()
        ]);
    
        return redirect()->route('categories.index');
    }    

    // Delete a category
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index');
    }
}

