<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreImageRequest;
use App\Http\Requests\UpdateImageRequest;
use App\Repositories\Image\IImageRepo;
use App\Transformers\ImageTransformer;
use Tymon\JWTAuth\Facades\JWTAuth;
use Dinkara\DinkoApi\Http\Controllers\ResourceController;
use Storage;
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

        if($request->file("url")){
            $data["url"] = $request->file("url")->store(config("storage.images.url"));   
        }
	
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
        $item = $this->repo->find($id);
                
        if($request->file("url")){
            Storage::delete($item->getModel()->url);
    
            $data["url"] = $request->file("url")->store(config("storage.images.url"));   
        }
	
        return $this->updateItem($data, $id);
    }

        /**
     * Remove item
     * 
     * Remove the specified item from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            if($item = $this->repo->find($id)){
                Storage::delete($item->getModel()->url);
                $item->delete($id);
                return ApiResponse::ItemDeleted($this->repo->getModel());
            }
        } catch (QueryException $e) {
            return ApiResponse::InternalError($e->getMessage());
        } 
        
        return ApiResponse::ItemNotFound($this->repo->getModel());       
    }
    



}