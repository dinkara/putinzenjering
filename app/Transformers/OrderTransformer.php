<?php

namespace App\Transformers;

use App\Models\Order;
use Dinkara\DinkoApi\Transformers\ApiTransformer;
/**
 * Description of OrderTransformer
 *
 * @author Dinkic
 */
class OrderTransformer extends ApiTransformer{
    
    protected $defaultIncludes = [];
    protected $availableIncludes = ['reviews', 'loadings', 'category', 'project'];
    protected $pivotAttributes = [];
    
    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(Order $item)
    {
        return $this->transformFromModel($item, $this->pivotAttributes);
    }
    
    public function includeReviews(Order $item)
    {
       return $this->collection($item->reviews, new ReviewTransformer());
    }
    public function includeLoadings(Order $item)
    {
       return $this->collection($item->loadings, new LoadingTransformer());
    }
    public function includeCategory(Order $item)
    { 
       return $this->item($item->category, new CategoryTransformer());
    }
    public function includeProject(Order $item)
    { 
       return $this->item($item->project, new ProjectTransformer());
    }


    
}
