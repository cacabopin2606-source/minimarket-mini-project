@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')

<div id="wrapper">
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <div id="content">

            <!-- Page -->

            <div class="container-fluid">


                <h1 class="h3 mb-4 text-gray-800">
                    Edit Produk
                </h1>


                <div class="card shadow mb-4">

                    <div class="card-body">


                        @if($errors->any())

                            <div class="alert alert-danger">

                                <ul class="mb-0">

                                    @foreach($errors->all() as $error)

                                        <li>
                                            {{ $error }}
                                        </li>

                                    @endforeach

                                </ul>

                            </div>

                        @endif


                        <form action="{{ route('products.update', $product) }}"
                              method="POST">

                            @csrf

                            @method('PUT')

                            <div class="form-group">
                                <label for="code">Kode Produk</label>
                                <input type="text"
                                    name="code"
                                    id="code"
                                    class="form-control"
                                    value="{{ old('code', $product->code) }}"
                                    required>
                            </div>

                            <div class="form-group">
                                <label for="barcode">Barcode</label>
                                <input type="text"
                                    name="barcode"
                                    id="barcode"
                                    class="form-control"
                                    value="{{ old('barcode', $product->barcode) }}">
                            </div>

                            <div class="form-group">

                                <label>
                                    Nama Produk
                                </label>

                                <input type="text"
                                       name="name"
                                       class="form-control"
                                       value="{{ old('name', $product->name) }}"
                                       required>

                            </div>


                            <div class="form-group">

                                <label>
                                    Harga
                                </label>

                                <input type="number"
                                       name="price"
                                       class="form-control"
                                       value="{{ old('price', $product->price) }}"
                                       min="0"
                                       required>

                            </div>


                            <div class="form-group">

                                <label>
                                    Stok
                                </label>

                                <input type="number"
                                       name="stock"
                                       class="form-control"
                                       value="{{ old('stock', $product->stock) }}"
                                       min="0"
                                       required>

                            </div>


                            <div class="form-group">

                                <label>
                                    Deskripsi
                                </label>

                                <textarea name="description"
                                          class="form-control"
                                          rows="4">{{ old('description', $product->description) }}</textarea>

                            </div>


                            <button type="submit"
                                    class="btn btn-primary">

                                <i class="fas fa-save"></i>

                                Update

                            </button>


                            <a href="{{ route('products.index') }}"
                               class="btn btn-secondary">

                                Kembali

                            </a>


                        </form>


                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>

<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

<script src="{{ asset('js/main.js') }}"></script>

@endsection