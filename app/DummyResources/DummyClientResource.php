<?php

namespace App\DummyResources;

use stdClass;

class DummyClientResource
{
    public $clientId;
    public $clientName;

    public $familyId;

    public function getClient($clientId){

        switch ($clientId) {
            case 1:
                $clientId1 = new DummyClientResource();
                $clientId1->clientId = 1;
                $clientId1->familyId = 1;
                $clientId1->clientName = "Aakash Soni";
                return $clientId1;
            case 2:
                $clientId2 = new DummyClientResource();
                $clientId2->clientId = 2;
                $clientId2->familyId = 1;
                $clientId2->clientName = "Shweta Soni";
                return $clientId2;
            case 3:
                $clientId3 = new DummyClientResource();
                $clientId3->clientId = 3;
                $clientId3->familyId = 2;
                $clientId3->clientName = "Kaushi Sahu";
                return $clientId3;
        }
        return null;
    }
}
