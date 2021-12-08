<?php


namespace Cart\Abstracts;


use Cart\Interfaces\CartAbstractInterface;

abstract class CartAbstracts extends BuilderAbstracts implements CartAbstractInterface
{
    const TAXABLE = 3;
    const PENDING_STATUS = 0;

    protected function syncCart()
    {
        $cart = $this->data->cart;
        $fees = $this->data->fees;
        $cart_price = $this->get_price($cart , 'price');
        $fees_price = $this->get_fees($fees);
        $cart_price = $this->merge_price($fees_price , $cart_price);
        $this->data->total = $this->format_amount(($cart_price['total'] * 100) , true);
        $this->data->tax = $this->format_amount(($cart_price['tax'] * 100) , true);
        $this->data->sub_total = $this->format_amount(($cart_price['sub_total'] * 100) , true);
    }

    public function get_price(array $cart , string $key , $taxable = true): array
    {
        $tax_percentage = $this->data->tax_percentage;
        $prices = array_column($cart , $key);
        $total = array_sum($prices);
        $tax = (($tax_percentage * $total) / 100);
        $sub_total = $taxable ? ($total + $tax) : $total;
        return [
            'total' => $total,
            'tax' => $tax,
            'sub_total' => $sub_total
        ];
    }

    public function get_fees(array $fees)
    {
        $res = [];
        $item_id = array_column($this->data->cart , 'id');
        foreach($fees as $fee){
            if ($fee['active'] && ($fee['charge_at'] == self::PENDING_STATUS) && !$fee['optional']){
                if (in_array(self::TAXABLE , $fee['fee_type_id'])){
                    if (count(array_intersect($fee['applied_items'] , $item_id))){
                        $res[] = $this->get_price([ $fee ] , 'amount');
                    }
                }else{
                    $res[] = $this->get_price([ $fee ] , 'amount' , false);
                }
            }
        }
        return $res;
    }

    public function merge_price($arr1 , $arr2): array
    {
        $arr1[] = $arr2;
        return [
            'total' => array_sum(array_column($arr1 , 'total')) ,
            'tax' => array_sum(array_column($arr1 , 'tax')) ,
            'sub_total' => array_sum(array_column($arr1 , 'sub_total'))
        ];
    }





    public function format_amount($param , $string = false)
    {
        if (is_array($param)){
            return (int) round(number_format(array_sum($param) , '2' , '.' , ''), 2 , PHP_ROUND_HALF_DOWN);
        }
        if ($string){
            return number_format(($param / 100) , '2' , '.' , '');
        }
        return (int) round(number_format( $param , '2' , '.' , ''), 2 , PHP_ROUND_HALF_DOWN);
    }
}
