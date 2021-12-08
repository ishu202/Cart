<?php


namespace Cart\Interfaces;


use Generator;

interface CartInterface
{
	public static function add(string $id , string $name , int $qty , float $amount , array $options ) : bool;

	public static function update(string $id , array $updated_item) : bool;

	public static function remove(string $id) : bool;

	public static function get(?string $id) : array;

	public static function content() : Generator;

}
