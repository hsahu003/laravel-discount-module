<?php

namespace App\DummyResources;

use stdClass;

class DummyOrderResource
{
    public $id;
    public $serviceBookedIds;
    public $clientId;

    function getOrdersByClient($clientId)
    {
        switch ($clientId) {
            case 1: //Aakash
                $orderId1 = new DummyOrderResource();
                $orderId1->id = 1;
                $orderId1->serviceBookedIds = [1,3]; //hair-cutting, facial
                $orderId1->clientId = 1;
                return $orderId1;
            case 2: //shweta
                $orderId2 = new DummyOrderResource();
                $orderId2->id = 2;
                $orderId2->serviceBookedIds = [1,2]; //hair-cutting, tattooing
                $orderId2->clientId = 2;
                return $orderId2;
            case 3:
                $orderId3 = new DummyOrderResource();
                $orderId3->id = 3;
                $orderId3->serviceBookedIds = [3];
                $orderId3->clientId = 3;
                return $orderId3;
        }
        return null;
    }
}
