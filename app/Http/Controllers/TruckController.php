<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreTruckRequest;
use App\Http\Requests\UpdateTruckRequest;
use App\Repositories\Truck\ITruckRepo;
use App\Transformers\TruckTransformer;
use Tymon\JWTAuth\Facades\JWTAuth;
use Dinkara\DinkoApi\Http\Controllers\ResourceController;
use ApiResponse;


/**
 * @resource Truck
 */
class TruckController extends ResourceController
{

    
    
    public function __construct(ITruckRepo $repo, TruckTransformer $transformer) {
        parent::__construct($repo, $transformer);
	
    
    
    
    }
    
    /**
     * Create item
     * 
     * Store a newly created item in storage.
     *
     * @param  App\Http\Requests\StoreTruckRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTruckRequest $request)
    {       
        $data = $request->only($this->repo->getModel()->getFillable());
	
        return $this->storeItem($data);
    }

    /**
     * Update item 
     * 
     * Update the specified item in storage.
     *
     * @param  App\Http\Requests\UpdateTruckRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTruckRequest $request, $id)
    {
        $data = $request->only($this->repo->getModel()->getFillable());
	
        return $this->updateItem($data, $id);
    }




}