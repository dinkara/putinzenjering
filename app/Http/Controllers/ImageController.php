<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreImageRequest;
use App\Http\Requests\UpdateImageRequest;
use App\Repositories\Image\IImageRepo;
use App\Transformers\ImageTransformer;
use Tymon\JWTAuth\Facades\JWTAuth;
use Dinkara\DinkoApi\Http\Controllers\ResourceController;
use ApiResponse;


/**
 * @resource Image
 */
class ImageController extends ResourceController
{

    
    
    public function __construct(IImageRepo $repo, ImageTransformer $transformer) {
        parent::__construct($repo, $transformer);
	
        $this->middleware('exists.review:review_id,true', ['only' => ['store']]);

        $this->middleware('exists.loading:loading_id,true', ['only' => ['store']]);

    
    
    
    }
    
    /**
     * Create item
     * 
     * Store a newly created item in storage.
     *
     * @param  App\Http\Requests\StoreImageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreImageRequest $request)
    {       
        $data = $request->only($this->repo->getModel()->getFillable());
	
        return $this->storeItem($data);
    }

    /**
     * Update item 
     * 
     * Update the specified item in storage.
     *
     * @param  App\Http\Requests\UpdateImageRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateImageRequest $request, $id)
    {
        $data = $request->only($this->repo->getModel()->getFillable());
	
        return $this->updateItem($data, $id);
    }




}