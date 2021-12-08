<?php


namespace Cart\Factory;

use Cart\Cart;
use Cart\Interfaces\CartFactoryInterface;
use Cart\Interfaces\CartInterface;

class CartFactory implements CartFactoryInterface
{

    public function createCartFactory() : CartInterface
    {
        return new Cart();
    }
}
