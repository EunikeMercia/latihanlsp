<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas = Item::where('stock', '>', 0)->get();
        // dd($datas);
        // session()->flush();
        return view('transaction', compact('datas'));
    }

    public function add($id){
        $barang = Item::findorfail($id);
        $cart = session()->get('cart');

        if(isset($cart[$id])){
            $cart[$id]['qty'] += 1;
            $cart[$id]['subtotal'] = $barang->price *  $cart[$id]['qty'];
        }elseif ($barang->stock <= 0) {
            return redirect()->back()->with('error', 'Failed to add cart');
        }
        else{
            $cart[$id] = [
                "id" => $barang->id,
                "name" => $barang->name,
                "qty" => 1,
                "subtotal" => $barang->price,
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Item added to cart');

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
        Transaction::create([
            'user_id' => Auth::id(),
            'date' => Carbon::now(),
            'total' => $request->total,
            'pay_total' => $request->pay_total,
            
        ]);

        $cart = session()->get('cart');
        foreach ($cart as $item) {
            TransactionDetail::create([
                'transaction_id' => Transaction::latest()->first()->id,
                'item_id' => $item['id'],
                'qty' => $item['qty'],
                'subtotal' => $item['subtotal'],
            ]);

            $product = Item::find($item['id']);
            $stock = $product->stock - $item['qty'];

            $product->update([
                'stock' => $stock,
            ]);

        }

        session()->forget('cart');

        return redirect()->route('transaction.show', Transaction::latest()->first()->id);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $transaksi = Transaction::findorfail($id);
        return view('invoice', compact('transaksi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       
    }

    public function cartUpdate(Request $request){
        $item = Item::findorfail($request->id);
        $cart = session()->get('cart');
        $cart[$request->id]['qty'] = $request->qty;
        $cart[$request->id]['subtotal'] = $item->price * $request->qty;

        if ($item->stock < $cart[$request->id]['qty']) {
            return redirect()->back()->with('error', 'Failed to add more qty');
        }


        session()->put('cart', $cart);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function delete($id){
        $cart = session()->get('cart');
        
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Item deleted successfully');
        }else {
            return redirect()->back()->with('error', 'Failed to delete item');
        }

    }
}
