<?php

namespace Tests;

use Cart\Builder\CartBuilder;
use Cart\CartProvider;
use Cart\Factory\CartFactory;
use Faker\Factory;
use Generator;
use PHPUnit\Framework\TestCase;

class CartTest extends TestCase
{
    public function testAddCart()
    {
        $provider = new CartProvider();
        $factory = new CartFactory();
        $faker = Factory::create();
        $cart = $provider->provideCartFactory($factory);
        $cart->add([
            'id' => $faker->numberBetween(1 , 5),
            't_name' => $faker->name('male') ,
            'overview' => $faker->paragraph() ,
            'price' => $faker->randomDigit() ,
            'from' => $faker->date(),
            'to' => $faker->date(),
            'pick' => $faker->time(),
            'drop' => $faker->time(),
            'duration' => $faker->randomDigit(),
            'delivery_method' => $faker->randomDigit()
        ]);

        $cart->attachCustomer($this->getCustomer($faker));

        $cart->attachFees($this->addFees($faker));

        $cart->attachTax(7.95);

        $this->assertNotEmpty($cart->get(), 'cart_object');
        echo var_export($cart->get());
    }

    public function testUpdateCart()
    {

    }

    public function getCart(\Faker\Generator $faker , $count = 1): array
    {
        $res = [];
        for ($i = 0; $i < $count ; $i++){
            $res[] = [
                'id' => $faker->numberBetween(1 , 5),
                't_name' => $faker->name('male') ,
                'overview' => $faker->paragraph() ,
                'price' => $faker->randomDigit() ,
                'from' => $faker->date(),
                'to' => $faker->date(),
                'pick' => $faker->time(),
                'drop' => $faker->time(),
                'duration' => $faker->randomDigit(),
                'delivery_method' => $faker->randomDigit()
            ];
        }
        return $res;
    }

    public function getCustomer(\Faker\Generator $faker): array
    {
        return [
            'f_name' => $faker->firstNameMale(),
            'l_name' => $faker->lastName(),
            'email' => $faker->email(),
            'phone' => $faker->phoneNumber(),
            'add1' => $faker->streetAddress(),
            'add2' => $faker->address(),
            'city' => $faker->city(),
            'state' => "Minnesota",
            'country' => $faker->country(),
            'zip' => $faker->postcode(),
            'delivery' => [
                'add1' => $faker->streetAddress(),
                'add2' => $faker->address(),
                'city' => $faker->city(),
                'state' => "Minnesota",
                'country' => $faker->country(),
                'zip' => $faker->postcode(),
                'delivery_notes' => $faker->text('50'),
                'store_distance' => $faker->randomDigit(),
                'delivery_charge' => $faker->randomDigit()
            ]
        ];
    }

    public function addFees(\Faker\Generator $faker , $count = 1)
    {
        $fees = [];
        for ($i = 0; $i < $count ; $i++){
            $optional = Factory::create();
            $fees[] = [
                'id' => $faker->randomDigit(),
                'name' => $faker->name(),
                'amount' => $faker->randomDigit(),
                'fee_type_id' => $faker->randomElements([ 1 , 2 , 3 ] , 2),
                'charge_at' => $faker->numberBetween(0 , 1),
                'optional' => $optional->boolean(),
                'applied_items' => $faker->randomElements(range(1 , 10) , 3),
                'active' => $optional->boolean(100)
            ];
        }
        return $fees;
    }
}