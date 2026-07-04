<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;

class BuyerCartController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'auth',
            'role:buyer',
        ];
    }

    public function index()
    {
        $cartData = session()->get('cart', []);
        $cartIds = array_keys($cartData);
        
        // Fetch listings based on session IDs
        $cartItemsRaw = \App\Models\WasteListing::with('seller', 'category', 'primaryImage')
                            ->whereIn('id', $cartIds)
                            ->get();
        
        // To match the previous UI structure where $item->listing was used in the view:
        // We will map it so $item->listing works, or update the view. It's easier to just pass the listings
        // and adjust the view to expect $item as the listing. Wait, in my previous view I did:
        // @php $listing = $item->listing; @endphp.
        // Let's create dummy objects so I don't have to change the view again!
        $cartItems = $cartItemsRaw->map(function ($listing) use ($cartData) {
            return (object) [
                'listing' => $listing,
                'quantity' => $cartData[$listing->id]['quantity'] ?? 1
            ];
        });

        // We wrap it in a LengthAwarePaginator just to make the links() method not fail in the view
        $cartItems = new \Illuminate\Pagination\LengthAwarePaginator($cartItems, $cartItems->count(), 15, 1);

        return view('buyer.cart.index', compact('cartItems'));
    }

    public function store(Request $request, \App\Models\WasteListing $wasteListing)
    {
        $cart = session()->get('cart', []);
        $quantity = max(1, (int) $request->input('quantity', 1));
        
        if (isset($cart[$wasteListing->id])) {
            $cart[$wasteListing->id]['quantity'] += $quantity;
        } else {
            $cart[$wasteListing->id] = ['quantity' => $quantity];
        }
        
        session()->put('cart', $cart);
        
        return redirect()->back()->with('success', 'Barang berhasil dimasukkan ke keranjang.');
    }
    
    public function destroy(\App\Models\WasteListing $wasteListing)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$wasteListing->id])) {
            unset($cart[$wasteListing->id]);
            session()->put('cart', $cart);
        }
        
        return redirect()->back()->with('success', 'Barang berhasil dihapus dari keranjang.');
    }
}
