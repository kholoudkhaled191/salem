<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller; 
use App\Models\Stock;
use App\Models\Warehouse;
use App\Models\Product;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        $stocks = Stock::with(['warehouse', 'product'])->get();
        return view('stocks.index', compact('stocks'));
    }

    public function create()
    {
        $warehouses = Warehouse::all();
        $products = Product::all();
        return view('stocks.create', compact('warehouses', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'product_id' => 'required|exists:products,id',
            'storage_date' => 'required|date',
            'meters_quantity' => 'nullable|numeric|min:0',
            'rolls_quantity' => 'nullable|integer|min:0',
            'price' => 'nullable|numeric|min:0'
        ]);

        Stock::create($validated);

        return redirect()->route('stocks.index')->with('success', 'Stock added successfully.');
    }

    public function edit($id)
    {
        $stock = Stock::findOrFail($id);
        $warehouses = Warehouse::all();
        $products = Product::all();

        return view('stocks.edit', compact('stock', 'warehouses', 'products'));
    }

    public function update(Request $request, $id)
    {
        $stock = Stock::findOrFail($id);

        $validated = $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            'product_id' => 'required|exists:products,id',
            'storage_date' => 'required|date',
            'meters_quantity' => 'nullable|numeric|min:0',
            'rolls_quantity' => 'nullable|integer|min:0',
            'price' => 'nullable|numeric|min:0'
        ]);

        $stock->update($validated);

        return redirect()->route('stocks.index')->with('success', 'Stock updated successfully.');
    }

    public function destroy($id)
    {
        $stock = Stock::findOrFail($id);
        $stock->delete();

        return redirect()->route('stocks.index')->with('success', 'Stock deleted successfully.');
    }
}