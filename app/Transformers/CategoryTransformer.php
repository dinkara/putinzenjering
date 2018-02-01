<?php

namespace App\Transformers;

use App\Models\Category;
use Dinkara\DinkoApi\Transformers\ApiTransformer;
/**
 * Description of CategoryTransformer
 *
 * @author Dinkic
 */
class CategoryTransformer extends ApiTransformer{
    
    protected $defaultIncludes = [];
    protected $availableIncludes = ['orders'];
    protected $pivotAttributes = [];
    
    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(Category $item)
    {
        return $this->transformFromModel($item, $this->pivotAttributes);
    }
    
    public function includeOrders(Category $item)
    {
       return $this->collection($item->orders, new OrderTransformer());
    }


    
}
