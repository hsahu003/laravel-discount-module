<?php
namespace App\DummyResources;

use AllowDynamicProperties;
use stdClass;

#[AllowDynamicProperties] class DummyServiceResourse
{
    public $serviceId;
    public $serviceName;
    public $price;
    public function getService($serviceId){

        switch ($serviceId) {
            case 1:
                $serviceId1 = new DummyServiceResourse();
                $serviceId1->serviceId = 1;
                $serviceId1->serviceName = 'Hair-cutting';
                $serviceId1->price = 1000;
                return $serviceId1;
            case 2:
                $serviceId2 = new DummyServiceResourse();
                $serviceId2->serviceId = 2;
                $serviceId2->serviceName = 'Tattooing';
                $serviceId2->price = 2000;
                return $serviceId2;
            case 3:
                $serviceId3 = new DummyServiceResourse();
                $serviceId3->serviceId = 3;
                $serviceId3->serviceName = 'Facial';
                $serviceId3->price = 3000;
                return $serviceId3;
            case 4:
                $serviceId4 = new DummyServiceResourse();
                $serviceId4->serviceId = 4;
                $serviceId4->serviceName = 'Head-massage';
                $serviceId4->price = 4000   ;
                return $serviceId4;
        }

        return null;
    }
}
