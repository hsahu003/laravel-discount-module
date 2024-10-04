<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Services\DiscountService;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    protected DiscountService $discountService;

    public function __construct(DiscountService $discountService){
        $this->discountService = $discountService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Discount::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required',
            'type' => 'required',
            'value' => 'required',
        ]);

        if(Discount::where('code', $request->input('code'))->exists()) return "Discount already exist";
        return Discount::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function apply(Request $request)
    {
        $discounts =$this->discountService->getDiscounts($request);
        $clubbedDiscountAmount = 0;
        foreach ($discounts as $discount) {$clubbedDiscountAmount += $discount->amount;}


        if($clubbedDiscountAmount == 0) return \response()->json([], 404);

        return \response()->json([
            "clubbedDiscountAmount" => $clubbedDiscountAmount,
            "individualDiscountDetails" => $discounts
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $discount = Discount::find($id);
        $discount->update($request->all());
        return $discount;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Update usage
     */
    public function use(Request $request)
    {

        $discounts = [];
        foreach ($request->input('discountIds') as $id) {
            $discount = Discount::find($id);
            $currentUsage = $discount->current_usage;
            $discount->update(['current_usage' => ++$currentUsage]);
            $discounts[] = $discount;
        }
        return $discounts;
    }
}
