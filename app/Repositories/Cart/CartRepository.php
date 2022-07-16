<?php

namespace App\Repositories\Cart;

interface CartRepository
{
    public function all();

    public function add($item);

    public function clear();
}
