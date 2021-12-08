<?php


namespace Cart\Interfaces;


use Generator;

interface CartInterface
{
	public function add(array $item) : bool;

	public function update(string $id , array $updated_item) : bool;

	public function remove(string $id) : bool;

	public function get(?string $id) : array;

	public function content() : Generator;

    public function attachCustomer($customer);

    public function attachTax($fees);

    public function attachFees($tax);
}
