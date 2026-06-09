<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::orderBy('name')->get();
        return view('categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate(['name' => ['required','string','max:50']]);
        Category::create($data);
        return redirect()->route('categories.index')->with('success', 'Az új kategória sikeresen létrehozva.');
    }

    public function edit(Category $category): View
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $data = $request->validate(['name' => ['required','string','max:50']]);
        $category->update($data);
        return redirect()->route('categories.index')->with('success', 'A(z) kategória sikeresen módosítva.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'A(z) kategória sikeresen törölve.');
    }
}
