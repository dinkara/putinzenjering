<?php

namespace App\Transformers;

use App\Models\Loading;
use Dinkara\DinkoApi\Transformers\ApiTransformer;
/**
 * Description of LoadingTransformer
 *
 * @author Dinkic
 */
class LoadingTransformer extends ApiTransformer{
    
    protected $defaultIncludes = [];
    protected $availableIncludes = ['review', 'truck', 'images', 'user', 'order'];
    protected $pivotAttributes = [];
    
    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(Loading $item)
    {
        return $this->transformFromModel($item, $this->pivotAttributes);
    }
    
    public function includeReview(Loading $item)
    { 
       return $this->item($item->review, new ReviewTransformer());
    }
    public function includeTruck(Loading $item)
    { 
       return $this->item($item->truck, new TruckTransformer());
    }
    public function includeImages(Loading $item)
    {
       return $this->collection($item->images, new ImageTransformer());
    }
    public function includeUser(Loading $item)
    { 
       return $this->item($item->user, new UserTransformer());
    }
    public function includeOrder(Loading $item)
    { 
       return $this->item($item->order, new OrderTransformer());
    }


    
}
