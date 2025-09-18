<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['items.product', 'from_warehouse', 'to_warehouse', 'branch'])
            ->latest()
            ->get();

        $user = Auth::user();
        return view('transactions.index', compact('transactions', 'user'));
    }

    public function create()
    {
        $products = Product::all();
        return view('transactions.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'branch_id' => 'nullable|exists:branches,id',
            'from_warehouse_id' => 'nullable|exists:warehouses,id',
            'to_warehouse_id' => 'nullable|exists:warehouses,id',
            'status' => 'nullable|string',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity_rolls' => 'required|numeric|min:0',
            'items.*.quantity_rows' => 'required|numeric|min:0',
        ]);

        $transaction = Transaction::create($request->only('type','branch_id','from_warehouse_id','to_warehouse_id','status'));

        foreach ($request->items as $item) {
            $transaction->items()->create($item);
        }

        return redirect()->route('transactions.index')->with('success', 'Transaction created successfully.');
    }
}
