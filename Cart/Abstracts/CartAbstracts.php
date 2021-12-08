<?php

namespace Cart\Abstracts;

use Cart\Builder\CartBuilder;
use Cart\Interfaces\CartAbstractInterface;

abstract class CartAbstracts implements CartAbstractInterface
{
    protected array $cart_session = [];
    protected CartBuilder $builder;

    public function __construct()
    {
        $this->builder = new CartBuilder();
    }

    public function attachFees($fees)
    {
        $this->builder->setFees($fees);
        $this->sync_cart_session();
    }

    public function attachCustomer($customer)
    {
        $this->builder->setCustomer($customer);
        $this->sync_cart_session();
    }

    protected function sync_cart_session()
    {
        $this->cart_session = $this->builder->get();
    }

    public function attachTax($tax)
    {
        $this->builder->setTaxPercentage($tax);
        $this->sync_cart_session();
    }
}