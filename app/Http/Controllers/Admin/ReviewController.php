<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Review;
use App\Models\Product;
use App\Traits\WebResponse;
use App\Services\ReviewService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Review\StoreReviewRequest;
use App\Http\Requests\Review\UpdateReviewRequest;

class ReviewController extends Controller
{
    // use WebResponse;

    // public function __construct(private ReviewService $service) {}

    // public function index()
    // {
    //     $reviews = $this->service->all();
    //     return view('reviews.index', compact('reviews'));
    // }

    // public function create()
    // {
    //     $users = User::select('id', 'name')->get();
    //     $products = Product::select('id', 'name')->get();
    //     return view('reviews.create', compact('users', 'products'));
    // }

    // public function store(StoreReviewRequest $request)
    // {
    //     $this->service->create($request->validated());
    //     return $this->redirectWithMessage('reviews.index', 'Review created successfully.');
    // }

    // public function show(Review $review)
    // {
    //     return view('reviews.show', compact('review'));
    // }

    // public function edit(Review $review)
    // {
    //     return view('reviews.edit', compact('review'));
    // }

    // public function update(UpdateReviewRequest $request, Review $review)
    // {
    //     $this->service->update($review, $request->validated());
    //     return $this->redirectWithMessage('reviews.index', 'Review updated.');
    // }

    // public function destroy(Review $review)
    // {
    //     $this->service->delete($review);
    //     return $this->redirectWithMessage('reviews.index', 'Review deleted.');
    // }
}
