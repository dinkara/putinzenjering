<?php

namespace App\Transformers;

use App\Models\Truck;
use Dinkara\DinkoApi\Transformers\ApiTransformer;
/**
 * Description of TruckTransformer
 *
 * @author Dinkic
 */
class TruckTransformer extends ApiTransformer{
    
    protected $defaultIncludes = ['loadings'];
    protected $availableIncludes = [];
    protected $pivotAttributes = [];
    
    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(Truck $item)
    {
        return $this->transformFromModel($item, $this->pivotAttributes);
    }
    
    public function includeLoading(Truck $item)
    { 
       return $this->item($item->loadings, new LoadingTransformer());
    }


    
}
