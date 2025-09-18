<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;

class OffersController extends Controller
{
    // 🟢 عرض كل العروض
    public function index()
    {
        $offers = Offer::all();
        return view('offers.index', compact('offers'));
    }

    // 🟢 عرض الفورم لإضافة عرض جديد
    public function create()
    {
        return view('offers.create');
    }

    // 🟢 حفظ العرض الجديد
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount_value' => 'required|numeric|min:0',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after_or_equal:start_at',
        ]);

        Offer::create($request->all());

        return redirect()->route('offers.index')->with('success', 'Offer created successfully.');
    }

    // 🟢 عرض الفورم لتعديل عرض موجود
    public function edit(Offer $offer)
    {
        return view('offers.edit', compact('offer'));
    }

    // 🟢 تحديث العرض
    public function update(Request $request, Offer $offer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount_value' => 'required|numeric|min:0',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after_or_equal:start_at',
        ]);

        $offer->update($request->all());

        return redirect()->route('offers.index')->with('success', 'Offer updated successfully.');
    }

    // 🟢 حذف العرض
    public function destroy(Offer $offer)
    {
        $offer->delete();
        return redirect()->route('offers.index')->with('success', 'Offer deleted successfully.');
    }
}
