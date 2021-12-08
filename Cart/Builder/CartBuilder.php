<?php

namespace Cart\Builder;

use Cart\Abstracts\CartAbstracts;
use Cart\Abstracts\CartBuilderAbstracts;
use Cart\Exceptions\InvalidItemException;
use Cart\Exceptions\InvalidRentalException;
use stdClass;

class CartBuilder extends CartBuilderAbstracts
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
            if ($this->isValidItem($item) && $this->isValidRental($item) && $this->isValidCart($item)){
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

    public function get(): array
    {
        $this->syncCart();
        $res = json_decode(json_encode($this->data), true);
        ksort($res);
        return $res;
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
            $has[] = 'customer';
        }
        $this->setItems($param['cart']);
        if (array_key_exists('fees' , $param)){
            $this->setFees($param['fees']);
        }

        $this->setTaxPercentage(@$param['tax_percent'] ?: 0);

        if (array_key_exists('in_cart' , $param)){
            $this->setInCart($param['in_cart']);
        }else{
            $this->setInCart(true);
        }
        $this->syncCart();
    }
}