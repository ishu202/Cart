<?php

namespace Cart\Builder;

use Cart\Abstracts\BuilderAbstracts;
use stdClass;

class DeliveryBuilder extends BuilderAbstracts
{

    protected function reset()
    {
        $this->data = new stdClass();
        $this->data->id = "dli_".$this->get_hash();
        $this->data->object = "delivery";
    }

    protected function setAdd1(string $add1): DeliveryBuilder
    {
        $this->data->add1 = $add1;
        return $this;
    }

    protected function setAdd2(?string $add2): DeliveryBuilder
    {
        $this->data->add2 = $add2;
        return $this;
    }

    protected function setCity(string $city): DeliveryBuilder
    {
        $this->data->city = $city;
        return $this;
    }

    protected function setState(string $state): DeliveryBuilder
    {
        $this->data->state = $state;
        return $this;
    }

    protected function setCountry(string $country): DeliveryBuilder
    {
        $this->data->country = $country;
        return $this;
    }

    protected function setZip($zip): DeliveryBuilder
    {
        $this->data->zip = $zip;
        return $this;
    }

    protected function setDeliveryNotes(string $instructions): DeliveryBuilder
    {
        $this->data->delivery_notes = $instructions;
        return $this;
    }

    protected function setStoreDistance(int $distance): DeliveryBuilder
    {
        $this->data->store_distance = $distance;
        return $this;
    }

    protected function setDeliveryCharge(int $delivery_charge): DeliveryBuilder
    {
        $this->data->delivery_charge = $delivery_charge;
        return $this;
    }

    public function get()
    {
        return $this->data;
    }

    public function set(array $params)
    {
        $this->reset();
        $this->setAdd1($params['add1'])
            ->setAdd2($params['add2'])
            ->setCity($params['city'])
            ->setState($params['state'])
            ->setCountry($params['country'])
            ->setZip($params['zip'])
            ->setDeliveryNotes($params['delivery_notes'])
            ->setStoreDistance($params['store_distance'])
            ->setDeliveryCharge($params['delivery_charge']);
    }
}