<?php



namespace App\Http\Controllers;

use App\Models\Warehouse;
use App\Models\Branch;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function index()
    {
        $warehouses = Warehouse::with('branch')->get();
        return view('warehouses.index', compact('warehouses'));
    }

    public function create()
    {
        $branches = Branch::all();
        return view('warehouses.create', compact('branches'));
    }

    public function store(Request $request)
{
    $request->validate([
        'branch_id' => 'required|exists:branches,id',
        'name'      => 'required|string',
        'location'  => 'required|string',
    ]);

    Warehouse::create($request->only(['branch_id', 'name', 'location']));

    return redirect()->route('warehouses.index')->with('success', 'تمت إضافة المخزن بنجاح ✅');
}



    public function edit(Warehouse $warehouse)
    {
        $branches = Branch::all();
        return view('warehouses.edit', compact('warehouse', 'branches'));
    }
public function update(Request $request, Warehouse $warehouse)
{
    $request->validate([
        'branch_id' => 'required|exists:branches,id',
        'name'      => 'required|string',
        'location'  => 'required|string',
    ]);

    $warehouse->update($request->only(['branch_id', 'name', 'location']));

    return redirect()->route('warehouses.index')->with('success', 'تم تعديل بيانات المخزن ✅');
}


    public function destroy(Warehouse $warehouse)
    {
        $warehouse->delete();
        return redirect()->route('warehouses.index')->with('success', 'Warehouse deleted successfully.');
    }
}