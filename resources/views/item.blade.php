@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        @if(Session::has('success'))
            <div class="alert alert-success">
                <p>{{ session::get('success') }}</p>
            </div>
        @endif
        <div class="col-7">
            <div class="card">
                <div class="card-header">
                    Data Item
                </div>
                <div class="card-body">
                    <table class="table  table-striped">
                        <tr>
                            <th>#</th>
                            <th>Nama Item</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Action</th>
                        </tr>
                        @foreach($datas as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->getCategory->name ?? 'No category'}}</td>
                                <td>{{ $data->price }}</td>
                                <td>{{ $data->stock }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button onclick="edit({{$data->id}})" class="btn btn-sm btn-warning">Edit</button>
                                        <div class="delete">
                                            <form action="{{ route('item.destroy', $data->id) }}" method="post">
                                                @method('DELETE')
                                                @csrf
                                                <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"> Delete</button>
                                            </form>
                                        </div>
                                    </div>
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
                    <span id="card-head">Tambah Item</span>
                </div>
                <div class="card-body">
                    <form action="{{ route('item.store') }}" method="post" id="form-item">
                        @csrf
                        @method('POST')
                        <div class="form-group mb-3">
                            <label for="name" class="">Nama Item</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="formGroupExampleInput" class="">Ketegori Barang</label>
                            <select name="category_id" class="form-select" id="category_id">
                                <option value="" disabled selected>Open this select menu</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : null }} >{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="name" class="">Harga</label>
                            <input type="text" name="price" id="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}">
                            @error('price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="name" class="">Stok</label>
                            <input type="text" name="stock" id="stock" class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock') }}">
                            @error('stock')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <input type="reset" value="Reset" class="btn btn-danger">
                            <input type="submit" value="Simpan" class="btn btn-success"> 
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function edit(a){
        document.getElementById("card-head").innerHTML = "Edit Item";
        $.get('item/' + a + '/edit', function(data) {
            $('#name').val(data.name);
            $('#price').val(data.price);
            $('#stock').val(data.stock);
            $('#category_id').val(data.category_id);
            var action = '{{ route("item.update", ":id") }}';
            action = action.replace(":id", data.id);
            $("#form-item").attr("action", action);
            $("input[name='_method']").val("PUT");
        })
    }
</script>
@if (Session::has('error_update'))
<script>
    edit(`{{ session('error_update')['updateUrl'] }}`, `{{ session('error_update')['editUrl'] }}`)
</script>
@endif
@endsection