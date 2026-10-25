<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Menampilkan semua produk.
     */
    public function index()
    {
        $products = Product::latest()->get();

        return view('products.index', compact('products'));
    }
    

    /**
     * Menampilkan form tambah produk.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Menyimpan produk baru.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|unique:products,code',
            'barcode' => 'nullable|unique:products,barcode',
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $file = $request->file('image');

        if ($file) {
            $original = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $ext = strtolower($file->getClientOriginalExtension());
            $filename = time() . '_' . preg_replace('/[^A-Za-z0-9\-\_]/', '_', $original) . '.' . $ext;
            $folder = 'products';
            $path = $folder . '/' . $filename;

            $manager = new ImageManager(Driver::class);

            $image = $manager->decodePath($file->getRealPath())
                             ->cover(800, 800);

            if ($ext === 'png') {
                $encoded = $image->encodeUsingFileExtension('png', quality: 90);
            } else {
                $encoded = $image->encodeUsingFileExtension('jpg', quality: 85);
            }

            Storage::disk('public')->put($path, $encoded->toString());

            $data['image'] = $path;
        }

        Product::create($data);

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit.
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Memperbarui produk.
     */
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'code' => 'required|unique:products,code,' . $product->id,
            'barcode' => 'nullable|unique:products,barcode,' . $product->id,
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $file = $request->file('image');

        if ($file) {

            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            $original = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $ext = strtolower($file->getClientOriginalExtension());
            $filename = time() . '_' . preg_replace('/[^A-Za-z0-9\-\_]/', '_', $original) . '.' . $ext;
            $folder = 'products';
            $path = $folder . '/' . $filename;

            $manager = new ImageManager(Driver::class);

            $image = $manager->decodePath($file->getRealPath())
                             ->cover(800, 800);

            if ($ext === 'png') {
                $encoded = $image->encodeUsingFileExtension('png', quality: 90);
            } else {
                $encoded = $image->encodeUsingFileExtension('jpg', quality: 85);
            }

            Storage::disk('public')->put($path, $encoded->toString());

            $data['image'] = $path;
        }

        $product->update($data);

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Menghapus produk.
     */
    public function destroy(Product $product)
    {
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}