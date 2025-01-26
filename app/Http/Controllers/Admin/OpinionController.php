<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OpinionController extends Controller
{
    public function index()
    {
        return view('admin.opinions.index');
    }

    public function create()
    {
        return view('admin.opinions.create');
    }

    public function store(Request $request)
    {
        // سيتم إضافة المنطق لاحقاً
    }

    public function edit($id)
    {
        return view('admin.opinions.edit');
    }

    public function update(Request $request, $id)
    {
        // سيتم إضافة المنطق لاحقاً
    }

    public function destroy($id)
    {
        // سيتم إضافة المنطق لاحقاً
    }
}
