<?php


namespace Cart;


use Cart\Abstracts\CartAbstracts;
use Cart\Interfaces\CartInterface;
use Generator;

class Cart extends CartAbstracts implements CartInterface
{

	public static function add(string $id, string $name, int $qty, float $amount, array $options): bool
	{

		// TODO: Implement add() method.
	}

	public static function update(string $id, array $updated_item): bool
	{
		// TODO: Implement update() method.
	}

	public static function remove(string $id): bool
	{
		// TODO: Implement remove() method.
	}

	public static function get(?string $id): array
	{
		// TODO: Implement get() method.
	}

	public static function content(): Generator
	{
		// TODO: Implement content() method.
	}
}
