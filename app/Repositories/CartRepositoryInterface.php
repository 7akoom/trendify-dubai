<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Support\Collection;

interface CartRepositoryInterface
{
    public function get(): Collection;
    public function add(Product $product, $qty = 1);
    public function update($id, $qty);
    public function delete($id);
    public function empty();
    public function total(): float;
    public function totals(): array;
    public function count(): int;
}
