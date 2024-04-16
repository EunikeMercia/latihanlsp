<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas = Category::all();
        return view('category', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $message = [
            'required' => ':attribute harus diisi',
            'min' => ':attribute minimal :min karakter',
        ];

        $this->validate($request, [
            'name' => 'required|min:3|max:20|unique:categories',
        ], $message);

        $category = Category::create([
            'name' => $request->name, 
        ]);

        if ($category) {
            return redirect()->back()->with('success', 'Category added successfully');
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Category::find($id);
        return $data;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::find($id);
        $message = [
            'required' => ':attribute harus diisi',
            'min' => ':attribute minimal :min karakter',
        ];

        $validation = Validator::make($request->all(), [
            'name' => 'required|min:3|max:20',
        ], $message);

        if ($validation->fails()) {
            return back()->withErrors($validation)->withInput()->with('error_update', [
                'updateUrl' => route('category.update', $category),
                'editUrl' => route('category.edit', $category),
            ]);
        }

        $category->update([
            'name' => $request->name,
        ]);
      
        return redirect()->back()->with('success', 'Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);
        $category->delete();
        return redirect()->back()->with('success', 'Category deleted successfully');
    }
}
