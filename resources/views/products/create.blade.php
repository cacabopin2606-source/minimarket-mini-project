@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">

    <h1 class="h3 mb-0 text-gray-800">
        Tambah Produk
    </h1>

</div>


<div class="card shadow">

    <div class="card-header">
        <h6 class="m-0 font-weight-bold text-primary">
            Form Tambah Produk
        </h6>
    </div>

    <div class="card-body">

        {{-- Menambahkan enctype="multipart/form-data" agar form dapat mengirimkan file --}}
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">

            @csrf

            <div class="form-group">

                <label>Kode Produk</label>

                <input type="text"
                       name="code"
                       class="form-control @error('code') is-invalid @enderror"
                       value="{{ old('code') }}"
                       required>
                @error('code')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

            </div>


            <div class="form-group">

                <label>Barcode</label>

                <input type="text"
                       name="barcode"
                       class="form-control @error('barcode') is-invalid @enderror"
                       value="{{ old('barcode') }}">
                @error('barcode')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

            </div>


            <div class="form-group">

                <label>Nama Produk</label>

                <input type="text"
                       name="name"
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name') }}"
                       required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

            </div>


            <div class="form-group">

                <label>Harga</label>

                <input type="number"
                       name="price"
                       class="form-control @error('price') is-invalid @enderror"
                       value="{{ old('price') }}"
                       required>
                @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

            </div>


            <div class="form-group">

                <label>Stok</label>

                <input type="number"
                       name="stock"
                       class="form-control @error('stock') is-invalid @enderror"
                       value="{{ old('stock') }}"
                       required>
                @error('stock')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

            </div>


            <div class="form-group">

                <label>Deskripsi</label>

                <textarea name="description"
                          class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

            </div>

            {{-- Input Gambar Produk --}}
            <div class="form-group">

                <label>Gambar Produk</label>

                <input type="file"
                       name="image"
                       class="form-control-file @error('image') is-invalid @enderror"
                       accept="image/*">
                <small class="form-text text-muted">Format yang diperbolehkan: JPG, JPEG, PNG, WEBP (Max 2MB)</small>
                @error('image')
                    <div class="text-danger mt-1 small">{{ $message }}</div>
                @enderror

            </div>


            <button type="submit" class="btn btn-primary">
                Simpan
            </button>

            <a href="{{ route('products.index') }}"
               class="btn btn-secondary">
                Kembali
            </a>

        </form>

    </div>

</div>

@endsection