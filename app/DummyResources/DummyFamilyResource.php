<?php
namespace App\DummyResources;

use stdClass;

class DummyFamilyResource
{
    public $id;
    public $name;
    public $memberIds;
    public function getFamilyByClient($clientId){
        switch($clientId){
            case 1:
            case 2:
                $familyId1 = new DummyFamilyResource();
                $familyId1->id = 1;
                $familyId1->name = 'Soni Family';
                $familyId1->memberIds = [1,2];
                return $familyId1;
            case 3:
                $familyId2 = new DummyFamilyResource();
                $familyId2->id = 2;
                $familyId2->name = 'Sahu Family';
                $familyId2->memberIds = [3];
                return $familyId2;
        }
        return null;
    }
}
