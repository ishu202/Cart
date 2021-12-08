<?php


namespace Cart\Interfaces;


interface CartFactoryInterface
{
	public function createCartFactory() : CartInterface;
}
