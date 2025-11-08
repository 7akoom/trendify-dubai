<?php

namespace App\Services\Backend;

use App\Models\Review;
use Illuminate\Support\Collection;

class ReviewService
{
    public function all(): Collection
    {
        return Review::with(['user:id,name', 'product:id,name'])->get();
    }

    public function create(array $data): Review
    {
        return Review::create($data);
    }

    public function update(Review $review, array $data): Review
    {
        $review->update($data);
        return $review;
    }

    public function delete(Review $review): void
    {
        $review->delete();
    }
}
