<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Models\Link;
use App\Models\Tag;
use App\Models\User;
use App\Models\Role;

class DashboardController extends Controller
{
    public function index()
    {
        $links = Link::where('company_id', Auth()->user()->company_id)->with('company')->get();
        $company = Company::where('id', Auth()->user()->company_id)->first();
        $tags = $allTags = Tag::all();
        $authors = User::where('company_id', Auth()->user()->company_id)->get();
        $roles = Role::all();

        return view('dashboard', compact('links', 'company', 'tags', 'allTags', 'authors', 'roles'));
    }
}
