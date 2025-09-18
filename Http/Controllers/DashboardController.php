<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\Branch;
use App\Models\Warehouse;
use App\Models\SpecialRequest;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // التحقق من تسجيل الدخول
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }

        try {
            // بيانات الكروت الأساسية
            $totalProducts = Product::count();
            $totalBranches = Branch::count();
            $totalWarehouses = Warehouse::count();
            $totalTransactions = Transaction::count();

            // جلب كل المعاملات بدون أي فلترة
            $transactions = Transaction::with(['from_warehouse', 'to_warehouse', 'branch'])
                ->latest()
                ->get();

            // Special Requests (عام للجميع)
            $specialRequests = SpecialRequest::all();

        } catch (\Exception $e) {
            return back()->with('error', 'خطأ في قاعدة البيانات: ' . $e->getMessage());
        }

        return view('dashboard', [
            'user' => $user,
            'data' => [
                'totalProducts' => $totalProducts,
                'totalBranches' => $totalBranches,
                'totalWarehouses' => $totalWarehouses,
                'totalTransactions' => $totalTransactions,
                'transactions' => $transactions,
                'specialRequests' => $specialRequests,
            ]
        ]);
    }
}
