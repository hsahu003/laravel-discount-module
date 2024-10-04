<?php

namespace App\Services;

use App\DummyResources\DummyClientResource;
use App\DummyResources\DummyFamilyResource;
use App\DummyResources\DummyOrderResource;
use App\DummyResources\DummyServiceResourse;
use App\Models\Discount;

class DiscountRuleService
{
    protected DummyFamilyResource $family;
    protected DummyOrderResource $order;

    public function __construct(DummyFamilyResource $family, DummyOrderResource $order){
        $this->family = $family;
        $this->order = $order;
    }
    public function getRecurringClientDiscount(DummyServiceResourse $service, DummyClientResource $client, ?Discount $discount, DummyOrderResource $orders){
        $previouslyBookedServices = $orders->serviceBookedIds;

        //check if service in cart has been ordered before by client
        $cartServiceBookedEarlier = false;
        if(in_array($service->serviceId, $previouslyBookedServices)) $cartServiceBookedEarlier  = true;

        //get the discount
        if($cartServiceBookedEarlier){
            return $this->calculateAndReturnDiscount($discount, $service);
        }
        return null;
    }
    public function getFamilyMemberDiscount(DummyServiceResourse $service, DummyClientResource $client, ?Discount $discount, DummyOrderResource $orders){
        //get clients family members
        $familyMembers = $this->family->getFamilyByClient($client->clientId)->memberIds;

        foreach ($familyMembers as $familyMember){
            $previouslyOrderedServicesByMember = $this->order->getOrdersByClient($familyMember)->serviceBookedIds;

            $cartServiceBookedEarlierByMember = false;
            if(in_array($service->serviceId, $previouslyOrderedServicesByMember)){
                $cartServiceBookedEarlierByMember = true;
            }
            if($cartServiceBookedEarlierByMember){
                return $this->calculateAndReturnDiscount($discount, $service);
            }
        }

        return null;
    }
    public function getAppliedCodeDiscount(DummyServiceResourse $service, ?Discount $discount){
        return $this->calculateAndReturnDiscount($discount, $service);
    }

    public function calculateAndReturnDiscount($discount, DummyServiceResourse $service){
        if($discount==null){return new Discount();}

        if($discount->type == 'percent'){
            $servicePrice = $service->price * $service->sessions;
            $discount->amount = round($servicePrice * $discount->value / 100);
        } else {
            $discount->amount = $discount->value;
        }

        //check for max discount
        if($discount->max_discount != null && $discount->amount > $discount->max_discount){
            $discount->amount = $discount->max_discount;
            $discount->message = "Max discount available is " . $discount->max_discount;
        }

        //check for discount usage
        if($discount->max_usgae != null && $discount->current_usage >= $discount->max_usage){
            $discount->amount = 0;
            $discount->message = "Discount has been exhausted";
        }

        //check for discount active
        if($discount->active == false){
            $discount->amount = 0;
            $discount->message = "Discount inactive";
        }

        return $discount;

    }

}
