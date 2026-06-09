<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublisherController extends Controller
{
    public function index(): View
    {
        $publishers = Publisher::orderBy('name')->get();
        return view('publishers.index', compact('publishers'));
    }

    public function create(): View
    {
        return view('publishers.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate(['name' => ['required','string','max:50']]);
        Publisher::create($data);
        return redirect()->route('publishers.index')->with('success', 'Az új kiadó sikeresen létrehozva.');
    }

    public function edit(Publisher $publisher): View
    {
        return view('publishers.edit', compact('publisher'));
    }

    public function update(Request $request, Publisher $publisher): RedirectResponse
    {
        $data = $request->validate(['name' => ['required','string','max:50']]);
        $publisher->update($data);
        return redirect()->route('publishers.index')->with('success', 'A(z) kiadó sikeresen módosítva.');
    }

    public function destroy(Publisher $publisher): RedirectResponse
    {
        $publisher->delete();
        return redirect()->route('publishers.index')->with('success', 'A(z) kiadó sikeresen törölve.');
    }
}
