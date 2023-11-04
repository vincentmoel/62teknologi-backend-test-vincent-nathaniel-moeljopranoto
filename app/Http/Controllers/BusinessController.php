<?php

namespace App\Http\Controllers;

use App\Helpers\AliasBuilder;
use App\Helpers\Response;
use App\Http\Requests\StoreBusinessRequest;
use App\Http\Requests\UpdateBusinessRequest;
use App\Http\Resources\BusinessResource;
use App\Models\Business;
use App\Models\BusinessCategory;

class BusinessController extends Controller
{
    public function index()
    {
        $businesses = Business::filterQuery()->get();
        return Response::build(
            200,
            [
                "businesses"   => BusinessResource::collection($businesses)
            ],
            $businesses->count()
        );
    }

    public function show(Business $business)
    {
        return Response::build(
            200,
            [
                "businesses"   => BusinessResource::make($business)
            ]
        );
    }

    public function store(StoreBusinessRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['transaction'] = json_encode($request->validated('transaction'));
        $validatedData['alias'] = AliasBuilder::create(Business::class, 'alias', $validatedData['name'] . " " . $validatedData['city']);
        $business = Business::create($validatedData);

        $validatedData['display_address'] = json_encode($request->validated('display_address'));
        $business->location()->create($validatedData);
        
        $this->storeBusinessCategory($request->validated('business_category'), $business->id);

        return Response::build(
            200,
            [
                "business"   => BusinessResource::make($business)
            ]
        );
    }

    public function update(UpdateBusinessRequest $request, Business $business)
    {
        $validatedData = $request->validated();
        $validatedData['transaction'] = json_encode($request->validated('transaction'));
        $validatedData['alias'] = AliasBuilder::create(Business::class, 'alias', $validatedData['name'] . " " . $validatedData['city']);
        
        $business->update($validatedData);
        
        $business->location()->update([
            'address1'          => $request->validated('address1'),
            'address2'          => $request->validated('address2'),
            'address3'          => $request->validated('address3'),
            'city'              => $request->validated('city'),
            'zip_code'          => $request->validated('zip_code'),
            'country'           => $request->validated('country'),
            'state'             => $request->validated('state'),
            'display_address'   => json_encode($request->validated('display_address')),
        ]);

        BusinessCategory::where('business_id', $business->id)->delete();
        $this->storeBusinessCategory($request->validated('business_category'), $business->id);

        $business->refresh();
        return Response::build(
            200,
            [
                "business"   => BusinessResource::make($business)
            ]
        );
    }


    public function destroy(Business $business)
    {
        $business->delete();

        return Response::noData(
            200,
            "Success Destroy Business"
        );
    }

    public function restore($businessId)
    {
        $business = Business::withTrashed()->findOrFail($businessId);
        $business->restore();

        return Response::build(
            200,
            [
                "business"   => BusinessResource::make($business)
            ]
        );
    }


    public function storeBusinessCategory($categories, $businessId)
    {
        $categoriesData = [];

        foreach($categories as $category)
        {
            $businessCategory['business_id'] = $businessId;
            $businessCategory['alias'] = AliasBuilder::create(BusinessCategory::class, 'alias', $category);
            $businessCategory['title'] = $category;
            array_push($categoriesData, $businessCategory);

        }

        BusinessCategory::insert($categoriesData);
    }

}
