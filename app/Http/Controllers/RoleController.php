<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companyId = Auth::user()->company_id;

        $roles = Role::where('company_id', $companyId)->paginate(10);

        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:roles,slug',
        ]);

        $validated['company_id'] = Auth::user()->company_id;

        Role::create($validated);

        return redirect()->route('roles.index')
                         ->with('success', 'Role criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $companyId = Auth::user()->company_id;

        $role = Role::where('company_id', $companyId)->findOrFail($id);

        return view('admin.roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $companyId = Auth::user()->company_id;

        $role = Role::where('company_id', $companyId)->findOrFail($id);

        return view('admin.roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $companyId = Auth::user()->company_id;

        $role = Role::where('company_id', $companyId)->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:roles,slug,' . $role->id,
        ]);

        $validated['company_id'] = $companyId;

        $role->update($validated);

        return redirect()->route('roles.index')
                         ->with('success', 'Role atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $companyId = Auth::user()->company_id;

        $role = Role::where('company_id', $companyId)->findOrFail($id);

        $role->delete();

        return redirect()->route('roles.index')
                         ->with('success', 'Role removida com sucesso!');
    }
}
