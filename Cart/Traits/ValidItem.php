<?php

namespace Cart\Traits;

use Cart\Exceptions\InvalidItemException;
use Cart\Exceptions\InvalidRentalException;

trait ValidItem
{
    /**
     * @throws InvalidItemException
     */
    protected function isValidItem(array $item): bool
    {
        foreach ($item as $value){
            if (is_iterable($value)){
                throw new InvalidItemException();
            }
        }
        return true;
    }

    /**
     * @throws InvalidRentalException
     */
    protected function isValidRental(array $item): bool
    {
        $exceptionKeys = [
            'id' , 't_name' , 'overview' , 'price' ,
            'from' , 'to' , 'pick' , 'drop' , 'duration' ,
            'delivery_method'
        ];
        $keys = array_keys($item);
        foreach ($exceptionKeys as $key){
            if (array_search($key , $keys) == -1){
                var_dump($keys);
                throw new InvalidRentalException();
            }
        }
        return true;
    }

    public function isValidCart(array $items)
    {
        $item_ids = array_column($items , 'id');
        if (count($item_ids) != array_unique($item_ids)){
            throw new \Exception("dublicate items found in the cart. unable to add the item");
        }
        return count($item_ids) == array_unique($item_ids);
    }
}