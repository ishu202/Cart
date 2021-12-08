<?php

namespace Cart\Builder;

use Cart\Abstracts\CartAbstracts;
use Cart\Exceptions\InvalidItemException;
use Cart\Exceptions\InvalidRentalException;
use stdClass;

class CartBuilder extends CartAbstracts
{
    public function reset()
    {
        $this->data = new stdClass();
        $this->data->id = "cart_".$this->get_hash();
        $this->data->object = "cart";
    }


    public function setCustomer(?array $params): CartBuilder
    {
        $customer = $this->data->customer = new CustomerBuilder();
        $customer->set($params);
        $this->data->customer = $customer->get();
        return $this;
    }

    /**
     * @throws InvalidItemException
     * @throws InvalidRentalException
     */
    public function setItems(?array $params): CartBuilder
    {
        if (!empty($this->data->cart)){
            $this->data->cart = [];
        }
        foreach($params as $item){
            if ($this->isValidItem($item) && $this->isValidRental($item)){
                $this->data->cart[] = $item;
            }
        }
        return $this;
    }

    public function setInCart(?bool $in_cart): CartBuilder
    {
        $this->data->in_cart = $in_cart;
        return $this;
    }

    /**
     * @param int|float $percentage
     * @return $this
     */
    public function setTaxPercentage($percentage): CartBuilder
    {
        $this->data->tax_percentage = $percentage;
        return $this;
    }

    public function setFees(array $fees): CartBuilder
    {
        $this->data->fees = $fees;
        return $this;
        //add the pre defined fees like damage waiver and delivery charge
        //it will be an array of fees.
    }

    public function get(): stdClass
    {
        return $this->data;
    }

    /**
     * @throws InvalidRentalException
     * @throws InvalidItemException
     */
    public function set(array $param)
    {
        $this->reset();
        if (array_key_exists('customer' , $param)){
            $this->setCustomer($param['customer']);
        }
        $this->setItems($param['cart'])
            ->setFees($param['fees'])
            ->setTaxPercentage($param['tax_percent']);

        if (array_key_exists('in_cart' , $param)){
            $this->setInCart($param['in_cart']);
        }else{
            $this->setInCart(true);
        }
        $this->syncCart();
    }
}