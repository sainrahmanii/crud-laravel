<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\ProductRequest;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get product
        $product = Product::latest()->paginate(5);

        //render view with product
        return view('master', compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        //upload image
        $image = $request->file('gambar');
        $image->storeAs('public/product', $image->hashName());

        //create post
        Product::create([
            'nama'     => $request->nama,
            'harga'     => $request->harga,
            'gambar'   => $image->hashName()
        ]);

        //redirect to index
        return redirect()->route('product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('product.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $this->validate($request, [
            'nama'     => 'required|min:5',
            'harga'   => 'required|min:3',
            'gambar'     => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        //check if image is uploaded
        if ($request->hasFile('gambar')) {

            //upload new image
            $image = $request->file('gambar');
            $image->storeAs('public/product', $image->hashName());

            //delete old image
            Storage::delete('public/product/'.$product->gambar);

            //update post with new image
            $product->update([
                'nama'     => $request->nama,
                'harga'   => $request->harga,
                'gambar'     => $image->hashName()
            ]);

        } else {

            //update post without image
            $product->update([
                'nama'     => $request->nama,
                'harga'   => $request->harga
            ]);
        }

        //redirect to index
        return redirect()->route('product.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        Storage::delete('public/product/'.$product->gambar);

        $product->delete();

        return redirect()->route('product.index');
    }
}
