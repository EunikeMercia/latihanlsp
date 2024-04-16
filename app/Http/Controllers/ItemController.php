<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas = Item::with('getCategory')->get();
        // dd($datasq);
        $categories = Category::all();
        return view('item', compact('datas', 'categories'));
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
            'integer' => ':attribute harus berbentuk angka',
        ];

        $this->validate($request, [
            'name' => 'required|min:3|max:20|unique:items',
            'price' => 'required|integer',
            'stock' => 'required|integer|min:1',
        ], $message);


        $item = Item::create([
            'category_id' => $request->category_id, 
            'name' => $request->name, 
            'price' => $request->price, 
            'stock' => $request->stock, 
        ]);

        if ($item) {
            return redirect()->back()->with('success', 'Item added successfully');
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
        $data = Item::find($id);
        return $data;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $item = Item::find($id);
        $message = [
            'required' => ':attribute harus diisi',
            'min' => ':attribute minimal :min karakter',
            'integer' => ':attribute harus berbentuk angka bulat',
        ];

        $validation = Validator::make($request->all(), [
            'name' => 'required|min:3|max:20',
            'price' => 'required|integer',
            'stock' => 'required|integer',
        ], $message);

        if ($validation->fails()) {
            return back()->withErrors($validation)->withInput()->with('error_update', [
                'updateUrl' => route('item.update', $item),
                'editUrl' => route('item.edit', $item),
            ]);
        }

        $item->update([
            'category_id' => $request->category_id, 
            'name' => $request->name, 
            'price' => $request->price, 
            'stock' => $request->stock, 
        ]);
        return redirect()->back()->with('success', 'Item updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Item::find($id);
        $item->delete();
        return redirect()->back()->with('success', 'Item deleted successfully');
    }
}
