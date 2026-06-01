<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{
    public function apply(Request $request)
    {
        $request->validate(['code' => 'required|string']);

        $coupon = Coupon::where('code', strtoupper(trim($request->code)))->first();

        if (!$coupon) {
            return response()->json(['success' => false, 'message' => 'Invalid coupon code.'], 422);
        }

        // Calculate cart subtotal
        $cart = session()->get('cart', []);
        $subtotal = 0;
        foreach ($cart as $id => $item) {
            $product = \App\Models\Product::find($id);
            if ($product) {
                $subtotal += $product->selling_price * $item['quantity'];
            }
        }

        // Validate coupon
        $validation = $coupon->isValid($subtotal, Auth::id(), $request->input('email'));

        if (!$validation['valid']) {
            return response()->json(['success' => false, 'message' => $validation['message']], 422);
        }

        $discount = $coupon->calculateDiscount($subtotal);

        // Store coupon in session
        session()->put('coupon', [
            'id' => $coupon->id,
            'code' => $coupon->code,
            'name' => $coupon->name,
            'discount_type' => $coupon->discount_type,
            'discount_value' => $coupon->discount_value,
            'discount' => $discount,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Coupon applied! You save ₹' . number_format($discount),
            'discount' => $discount,
            'coupon_code' => $coupon->code,
            'coupon_name' => $coupon->name,
        ]);
    }

    public function remove()
    {
        session()->forget('coupon');

        return response()->json([
            'success' => true,
            'message' => 'Coupon removed.',
        ]);
    }
}
