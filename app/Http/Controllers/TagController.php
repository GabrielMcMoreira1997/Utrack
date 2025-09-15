<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companyId = Auth::user()->company_id;

        $tags = Tag::where('company_id', $companyId)->paginate(10);

        return view('admin.tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tags.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        $validated['company_id'] = Auth::user()->company_id;
        $validated['user_id']    = Auth::id();

        Tag::create($validated);

        return redirect()->route('tags.index')
                         ->with('success', 'Tag criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $companyId = Auth::user()->company_id;

        $tag = Tag::where('company_id', $companyId)->findOrFail($id);

        return view('admin.tags.show', compact('tag'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $companyId = Auth::user()->company_id;

        $tag = Tag::where('company_id', $companyId)->findOrFail($id);

        return view('admin.tags.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $companyId = Auth::user()->company_id;

        $tag = Tag::where('company_id', $companyId)->findOrFail($id);

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        $validated['company_id'] = $companyId;
        $validated['user_id']    = Auth::id();

        $tag->update($validated);

        return redirect()->route('tags.index')
                         ->with('success', 'Tag atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $companyId = Auth::user()->company_id;

        $tag = Tag::where('company_id', $companyId)->findOrFail($id);

        $tag->delete();

        return redirect()->route('tags.index')
                         ->with('success', 'Tag removida com sucesso!');
    }
}
