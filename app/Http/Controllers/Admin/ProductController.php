<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\{Size, Color, Image, Product, Category};
use Illuminate\Http\Request;
use App\Services\Backend\ProductService;
use Illuminate\Support\Facades\{Log, Storage};
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\{StoreProductRequest, UpdateProductRequest};

class ProductController extends Controller
{
    public function __construct(private ProductService $service) {}

    public function index()
    {
        $products = $this->service->all();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::select('id', 'name')->get();
        $colors = Color::select('id', 'name')->get();
        $sizes = Size::select('id', 'name')->get();
        return view('admin.products.create', compact(['categories', 'colors', 'sizes']));
    }

    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        $images = $request->allFiles()['images'] ?? [];

        try {
            $this->service->create($data, $images);
            return redirect()
                ->route('admin.products.index')
                ->with('success', 'تم إنشاء المنتج بنجاح');
        } catch (Exception $e) {
            Log::error(['create product error' => $e->getMessage()]);
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'حدث خطأ غير متوقع');
        }
    }


    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $colors = Color::all();
        $sizes = Size::all();

        $product->load(['colors', 'sizes', 'price', 'images']);

        return view('admin.products.edit', compact('product', 'categories', 'colors', 'sizes'));
    }


    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();
        $images = $request->allFiles()['images'] ?? [];

        try {
            $this->service->update($product, $data, $images);
            return redirect()
                ->route('admin.products.index')
                ->with('success', 'تم تعديل المنتج بنجاح');
        } catch (Exception $e) {
            Log::error(['update product error' => $e->getMessage()]);
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'حدث خطأ غير متوقع');
        }
    }



    public function destroy(Product $product)
    {
        $this->service->delete($product);
        return redirect()
            ->route('admin.products.index')
            ->with('success', 'تم حذف المنتج بنجاح');
    }

    public function destroyImage(Image $image)
    {
        if ($image->path && Storage::disk('public')->exists($image->path)) {
            Storage::disk('public')->delete($image->path);
        }

        $image->delete();

        return response()->json(['message' => 'تم الحذف بنجاح.']);
    }

    public function filterByCategory(Request $request)
    {
        $products = Product::with(['featuredImage', 'price', 'colors', 'sizes'])
            ->where('category_id', $request->category_id)->get();
        $view = view('products-list', compact('products'))->render();

        return response()->json(['html' => $view]);
    }

    public function filterFeaturedOrNew(Request $request)
    {
        $type = $request->type;

        $products = Product::with(['featuredImage', 'price', 'colors', 'sizes'])
            ->when($type === 'featured', fn($q) => $q->where('is_featured', true))
            ->when($type === 'new', fn($q) => $q->where('is_new', true))
            ->where('is_active', true)
            ->get();

        $view = view('products-list', compact('products'))->render();

        return response()->json(['html' => $view]);
    }
}
