<?php


namespace Cart;


use Cart\Factory\CartFactory;

class CartProvider
{
    public function provideCartFactory(CartFactory $factory): Interfaces\CartInterface
    {
        return $factory->createCartFactory();
    }
}
