<?php

// app/Http/Controllers/SpecialRequestController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SpecialRequest;



class SpecialRequestController extends Controller
{
    public function index()
    {
        // جلب كل الـ special requests
        $requests = SpecialRequest::all();

        return view('special-requests.index', compact('requests'));
    }



    public function store(Request $request)
    {
        $validated = $request->validate([
            'person_name' => 'required|string|max:255',
            'person_phone' => 'required|string|max:20',
            'note' => 'nullable|string'
        ]);

        $requestCreated = SpecialRequest::create($validated);

        return response()->json([
            'message' => 'Special request saved successfully.',
            'data' => $requestCreated
        ], 201);
    }
}
