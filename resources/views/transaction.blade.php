@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        @if(Session::has('success'))
            <div class="alert alert-success">
                <p>{{ session::get('success') }}</p>
            </div>
        @elseif(Session::has('error'))
            <div class="alert alert-danger">
                <p>{{ session::get('error') }}</p>
            </div>
        @endif
        <div class="col-7">
            <div class="card">
                <div class="card-header">
                    Data Transaksi
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <tr>
                            <th>#</th>
                            <th>Item</th>
                            <th>Category</th>
                            <th>Stok</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($datas as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->getCategory->name }}</td>
                            <td>{{ $item->stock }}</td>
                            <td>Rp {{ number_format($item->price)}}</td>
                            <td>
                                <a href="{{ route('transaction.add', $item->id) }}" class="btn btn-sm btn-success">Add to cart</a>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        <div class="col-5">
            <div class="card">
                <div class="card-header">
                    Cart
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <td>#</td>
                            <td>Item</td>
                            <td class="col-md-2">Qty</td>
                            <td>Subtotal</td>
                            <td>Action</td>
                        </thead>
                        @php $total = 0; @endphp
                        @if(session('cart'))
                            @foreach(session()->get('cart') as $id => $item)
                            @php $total += $item['subtotal']; @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item['name'] }}</td>
                                <form action="{{ route('cart.update') }}" method="post">
                                    @csrf     
                                    <input type="hidden" name="id" value="{{ $item['id'] }}">
                                    <td><input type="number" name="qty" id="" class="form-control" value="{{ $item['qty']}}" onchange="ubah({{ $loop->iteration }})" min="1"></td>
                                    <td>Rp {{ number_format( $item['subtotal'] )}}</td>
                                    <td>
                                        <a id="delete-{{$loop->iteration}}" class="btn btn-sm btn-danger" type="reset" href="{{ route('cart.delete', $item['id']) }}">Hapus</a>
                                        <input id="update-{{$loop->iteration}}" class="btn btn-sm btn-primary" style="display: none" value="Update" type="submit">
                                    </td>
                                </form>
                            </tr>
                            <script>
                                function ubah(no) { 
                                    $(`#update-${no}`).show();
                                    $(`#delete-${no}`).hide();
                                 }
                            </script>
                            @endforeach
                        @else
                        <tr>
                            <td colspan="5" class="text-center">
                                Tidak ada item dalam cart
                            </td>
                        </tr>
                        @endif
                    </table>
                    <form action="{{ route('transaction.store') }}" method="post">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="name" class="">Grand Total</label>
                            <input type="text" name="total" value="{{ $total }}" id="" class="form-control" readonly>
                        </div>
                        <div class="form-group mb-3">
                            <label for="name" class="">Payment</label>
                            <input type="text" name="pay_total" id="" value="{{ $total }}" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <input type="reset" value="Reset" class="btn btn-danger">
                            <input type="submit" value="Checkout" class="btn btn-success"> 
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection