<?php


namespace Cart;


use Cart\Abstracts\CartAbstracts;
use Cart\Interfaces\CartInterface;
use Exception;
use Generator;

class Cart extends CartAbstracts implements CartInterface
{
    public function load(array $items)
    {
        try {
            $this->builder->set([
                'cart' => $items
            ]);
            $this->sync_cart_session();
        }catch (Exception $exception){
            echo $exception->getMessage();
        }
        return true;
    }

	public function add(array $item): bool
	{
        $items = [];
        $items[] = $item;
        return $this->load($items);
	}


    public function update(string $id, array $updated_item): bool
	{
        $cart = $this->cart_session['cart'];
		$ids = array_column($cart , 'id');

        if (in_array($id , $ids)){
            $index = array_search($id , $ids);
            $cart[$index] = array_replace($cart[$index] , $updated_item);
            try {
                $this->builder->setItems($cart);
                $this->sync_cart_session();
                return true;
            }catch (Exception $exception){
                echo $exception->getMessage();
            }
        }
        return false;
	}

	public function remove(string $id): bool
	{
        $cart = $this->cart_session['cart'];
        $ids = array_column($cart , 'id');

        if (in_array($id , $ids)){
            $index = array_search($id , $ids);
            unset($cart[$index]);
            try {
                $this->builder->setItems($cart);
                $this->sync_cart_session();
                return true;
            }catch (Exception $exception){
                echo $exception->getMessage();
            }
        }
        return false;
	}

	public function get(?string $id = null): array
	{
		return $this->cart_session;
	}

	public function content(): Generator
	{
        $cart = $this->cart_session['cart'];
        foreach ($cart as $item){
            yield $item;
        }
	}
}
