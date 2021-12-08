<?php

namespace Cart\Interfaces;

interface CartExceptionInterface
{
    public function isValidItem();

    public function isValidRental();

    public function isValidCart();
}