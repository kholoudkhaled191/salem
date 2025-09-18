<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Exception;

class ProductController extends Controller
{
    use ApiResponse;

    // 🟢 عرض كل المنتجات (لـ Web أو API)
    public function index(Request $request)
    {
        try {
            $products = Product::all();
            
            if ($request->expectsJson() || $request->is('api/*')) {
                return $this->successResponse($products, 'Products retrieved successfully');
            }
            
            return view('products.index', compact('products'));
        } catch (Exception $e) {
            Log::error('Error fetching products: ' . $e->getMessage());
            
            if ($request->expectsJson() || $request->is('api/*')) {
                return $this->serverErrorResponse('حدث خطأ في جلب المنتجات');
            }
            
            return redirect()->back()->with('error', 'حدث خطأ في جلب المنتجات. يرجى المحاولة مرة أخرى.');
        }
    }

    // 🟢 عرض فورم إنشاء جديد
    public function create()
    {
        return view('products.create');
    }

    // 🟢 تخزين منتج جديد
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price_before' => 'required|numeric',
            'price_after' => 'required|numeric',
            'colors' => 'nullable|array',
            'images' => 'nullable|array',
        ]);

        // 🟢 لو الصور معمولة upload
        if ($request->hasFile('images')) {
            $paths = [];
            foreach ($request->file('images') as $file) {
                $paths[] = $file->store('products', 'public');
            }
            $data['images'] = $paths;
        }

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    // 🟢 عرض منتج واحد
    public function show(Request $request, Product $product)
    {
        if ($request->expectsJson() || $request->is('api/*')) {
            return $this->successResponse($product, 'Product retrieved successfully');
        }
        return view('products.show', compact('product'));
    }

    // 🟢 عرض فورم تعديل
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    // 🟢 تحديث منتج
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price_before' => 'required|numeric',
            'price_after' => 'required|numeric',
            'colors' => 'nullable|array',
            'images' => 'nullable|array',
        ]);

        if ($request->hasFile('images')) {
            $paths = [];
            foreach ($request->file('images') as $file) {
                $paths[] = $file->store('products', 'public');
            }
            $data['images'] = $paths;
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    // 🟢 حذف منتج
    public function destroy(Request $request, Product $product)
    {
        try {
            DB::beginTransaction();

            if (is_array($product->images)) {
                foreach ($product->images as $image) {
                    Storage::disk('public')->delete($image);
                }
            }

            $product->delete();

            DB::commit();

            return $request->expectsJson() || $request->is('api/*')
                ? $this->successResponse(null, 'تم حذف المنتج بنجاح')
                : redirect()->route('products.index')->with('success', 'تم حذف المنتج بنجاح.');

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error deleting product: ' . $e->getMessage());

            return $request->expectsJson() || $request->is('api/*')
                ? $this->serverErrorResponse('حدث خطأ في حذف المنتج')
                : redirect()->back()->with('error', 'حدث خطأ في حذف المنتج. يرجى المحاولة مرة أخرى.');
        }
    }

    // 🟢 جلب كل المنتجات مع الفروع
    public function getAllProducts()
    {
        $products = Product::with(['stocks.warehouse.branch'])->get();

        $products->transform(function ($product) {
            $branch = $product->stocks->first()?->warehouse->branch;
            unset($product->stocks);
            $product->branch = $branch;
            return $product;
        });

        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }

    // 🟢 جلب المنتجات المرتبطة بعروض
    public function getProductsWithOffers()
    {
        $products = Product::whereHas('offers')
                           ->with(['offers', 'stocks.warehouse.branch'])
                           ->get();

        $products->transform(function ($product) {
            $branch = $product->stocks->first()?->warehouse->branch;
            unset($product->stocks);
            $product->branch = $branch;
            return $product;
        });

        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }
}
