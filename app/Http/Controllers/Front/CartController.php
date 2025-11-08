<?php

namespace App\Http\Controllers\Front;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\CartRepositoryInterface;

class CartController extends Controller
{
    public function __construct(private CartRepositoryInterface $cartRepo) {}

    public function index()
    {
        $carts = $this->cartRepo->get();
        $total = $this->cartRepo->total();
        return view('cart', compact('carts', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty' => 'nullable|integer|min:1',
        ]);

        $product = Product::findOrFail($request->post('product_id'));
        /** @var \App\Repositories\CartRepositoryInterface $cartRepo */
        $this->cartRepo->add($product, $request->post('qty'));
        $cartRepo = app(CartRepositoryInterface::class);
        $totals = $cartRepo->totals();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'تمت إضافة المنتج إلى السلة بنجاح',
                'cartCount' => $cartRepo->count(),
                'cartTotal' => $totals['total'],
            ]);
        }

        return redirect()
            ->route('shop')
            ->with('success', 'تم إضافة المنتج إلى سلتك');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'qty' => 'required|integer|min:1',
        ]);

        $this->cartRepo->update($id, $request->post('qty'));

        return redirect()
            ->route('admin.banners.index')
            ->with('success', 'Cart item updated.');
    }

    public function destroy($id)
    {
        $this->cartRepo->delete($id);
        $cartRepo = app(CartRepositoryInterface::class);
        $totals = $cartRepo->totals();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'تمت إضافة المنتج إلى السلة بنجاح',
                'cartCount' => $cartRepo->count(),
                'cartTotal' => $totals['total'],
            ]);
        }
        return redirect()
            ->route('admin.banners.index')
            ->with('success', 'Cart item removed.');
    }
}
