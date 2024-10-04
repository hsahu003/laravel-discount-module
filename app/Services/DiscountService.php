<?php

namespace App\Services;

use App\DummyResources\DummyClientResource;
use App\DummyResources\DummyFamilyResource;
use App\DummyResources\DummyOrderResource;
use App\DummyResources\DummyServiceResourse;
use App\Models\Discount;
use App\Services\DiscountRuleService;
use Illuminate\Http\Request;


class DiscountService{
    protected DummyOrderResource $order;
    protected DummyServiceResourse $service;
    protected DummyClientResource $client;
    protected DummyFamilyResource $family;
    protected DiscountRuleService $discountRule;

    public function __construct(DummyOrderResource $order, DummyServiceResourse $service, DummyClientResource $client, DummyFamilyResource $family, DiscountRuleService $discountRule){
        $this->order = $order;
        $this->service = $service;
        $this->client = $client;
        $this->family = $family;
        $this->discountRule = $discountRule;
    }

    public function getDiscounts(Request $request){
        $ordersResource = $this->order->getOrdersByClient($request->input('client_id'));
        $clientResource = $this->client->getClient($request->input('client_id'));
        $servicesInCart = $request->input('services_in_cart');
        $clubbedDiscounts = [];
        foreach ($servicesInCart as $service){
            $serviceResource = $this->service->getService($service['service_id']);
            $serviceResource->sessions = $service['sessions'];

            //code discount
            $codeDiscountResource = Discount::where('code', $request->input('discount_code_applied'))->first();
            $codeDiscount = $this->discountRule->getAppliedCodeDiscount($serviceResource, $codeDiscountResource);
            $codeDiscountAmount = $codeDiscount == null ? 0 : $codeDiscount->amount;

            //recur client discount
            $recurClientDiscountResource = Discount::where('code', env("RECUR_CLIENT_DISCOUNT_CODE"))->first();
            $recurDiscount = $this->discountRule->getRecurringClientDiscount($serviceResource, $clientResource, $recurClientDiscountResource, $ordersResource);
            $recurDiscountAmount = $recurDiscount == null ? 0 : $recurDiscount->amount;

            //family member discount
            $familyDiscountResource = Discount::where('code', env("FAMILY_MEMBER_DISCOUNT_CODE"))->first();
            $familyDiscount = $this->discountRule->getFamilyMemberDiscount($serviceResource, $clientResource, $familyDiscountResource, $ordersResource);
            $familyDiscountAmount = $familyDiscount == null ? 0 : $familyDiscount->amount;

            //choose best/max discount available
            $bestDiscount = $codeDiscount;
            if($recurDiscountAmount > $codeDiscountAmount) $bestDiscount = $recurDiscount;
            if($familyDiscountAmount > $recurDiscountAmount) $bestDiscount = $familyDiscount;

            //add relevant details
            $bestDiscount->serviceId = $service['service_id'];
            $clubbedDiscounts[] = $bestDiscount;
        }
        return $clubbedDiscounts;
    }
}
