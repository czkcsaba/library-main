<?php

namespace App\Http\Controllers;

use App\Models\Writer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WriterController extends Controller
{
    public function index(): View
    {
        $writers = Writer::orderBy('name')->get();
        return view('writers.index', compact('writers'));
    }

    public function create(): View
    {
        return view('writers.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate(['name' => ['required','string','max:50'], 'bio' => ['required','string','max:400']]);
        Writer::create($data);
        return redirect()->route('writers.index')->with('success', 'Az új szerző sikeresen létrehozva.');
    }

    public function edit(Writer $writer): View
    {
        return view('writers.edit', compact('writer'));
    }

    public function update(Request $request, Writer $writer): RedirectResponse
    {
        $data = $request->validate(['name' => ['required','string','max:50'], 'bio' => ['required','string','max:400']]);
        $writer->update($data);
        return redirect()->route('writers.index')->with('success', 'A(z) szerző sikeresen módosítva.');
    }

    public function destroy(Writer $writer): RedirectResponse
    {
        $writer->delete();
        return redirect()->route('writers.index')->with('success', 'A(z) szerző sikeresen törölve.');
    }
}
