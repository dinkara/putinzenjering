<?php

namespace App\Transformers;

use App\Models\Profile;
use Dinkara\DinkoApi\Transformers\ApiTransformer;
/**
 * Description of ProfileTransformer
 *
 * @author Dinkic
 */
class ProfileTransformer extends ApiTransformer{
    
    protected $defaultIncludes = [];
    protected $availableIncludes = ['user'];
    protected $pivotAttributes = [];
    
    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(Profile $item)
    {
        return $this->transformFromModel($item, $this->pivotAttributes);
    }
    
    public function includeUser(Profile $item)
    { 
       return $this->item($item->user, new UserTransformer());
    }


    
}
