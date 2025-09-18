<?php

namespace App\Http\Controllers;

use App\Models\OfferProduct;
use App\Models\Product;
use App\Models\Offer;
use Illuminate\Http\Request;

class OfferProductController extends Controller
{
    public function index()
    {
        $offerProducts = OfferProduct::with(['product', 'offer'])->get();
        return view('offer_products.index', compact('offerProducts'));
    }

    public function create()
    {
        $products = Product::all();
        $offers = Offer::all();
        return view('offer_products.create', compact('products', 'offers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'offer_id' => 'required|exists:offers,id',
        ]);

        OfferProduct::create($request->all());

        return redirect()->route('offer_products.index')->with('success', 'Offer assigned to product successfully.');
    }

    public function edit(OfferProduct $offerProduct)
    {
        $products = Product::all();
        $offers = Offer::all();
        return view('offer_products.edit', compact('offerProduct', 'products', 'offers'));
    }

    public function update(Request $request, OfferProduct $offerProduct)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'offer_id' => 'required|exists:offers,id',
        ]);

        $offerProduct->update($request->all());

        return redirect()->route('offer_products.index')->with('success', 'Offer-Product updated successfully.');
    }

    public function destroy(OfferProduct $offerProduct)
{
    $offerProduct->delete();
    return redirect()->route('offer_products.index')->with('success', 'Offer-Product deleted successfully.');
}

}
