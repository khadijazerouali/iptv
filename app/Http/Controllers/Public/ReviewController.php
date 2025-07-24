<?php

namespace App\Http\Controllers\Public;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'review' => 'nullable|string',
            'rating' => 'nullable|numeric|min:1|max:5',
        ]);

        $review = new Review();
        $review->product_uuid = $product->uuid;
        $review->name = $request->name;
        $review->email = $request->email;
        $review->review = $request->review ?? '';
        $review->rating = $request->rating ?? 5;
        $review->save();

        return redirect()->back()->with('success', 'Commentaire envoyé avec succès');
    }
}
