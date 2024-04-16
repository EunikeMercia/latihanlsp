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
                    Data Kategori
                </div>
                <div class="card-body">
                    <table class="table  table-striped">
                        <tr>
                            <th>#</th>
                            <th>Nama Kategori</th>
                            <th>Action</th>
                        </tr>
                        @foreach($datas as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->name }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button onclick="edit({{$data->id}})" class="btn btn-sm btn-warning">Edit</button>
                                        <div class="delete">
                                            <form action="{{ route('category.destroy', $data->id) }}" method="post">
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
                    <span id="card-head">
                        Tambah Kategori
                    </span>
                </div>
                <div class="card-body">
                    <form id="form-category" action="{{ route('category.store') }}" method="post">
                        @csrf
                        @method('POST')
                        <div class="form-group mb-3">
                            <label for="name" class="">Nama Kategori</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                            @error('name')
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
        document.getElementById("card-head").innerHTML = "Edit Category";
        $.get('category/' + a + '/edit', function(data) {
            $('#name').val(data.name);
            var action = '{{ route("category.update", ":id") }}';
            action = action.replace(":id", data.id);
            $("#form-category").attr("action", action);
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