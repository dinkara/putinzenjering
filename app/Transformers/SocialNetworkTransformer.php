<?php

namespace App\Transformers;

use App\Models\SocialNetwork;
use Dinkara\DinkoApi\Transformers\ApiTransformer;
/**
 * Description of SocialNetworkTransformer
 *
 * @author Dinkic
 */
class SocialNetworkTransformer extends ApiTransformer{
    
    protected $defaultIncludes = [];
    protected $availableIncludes = ['users'];
    protected $pivotAttributes = ['access_token', 'provider_id'];
    
    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(SocialNetwork $item)
    {
        return $this->transformFromModel($item, $this->pivotAttributes);
    }
    
    public function includeUsers(SocialNetwork $item)
    {
       return $this->collection($item->users, new UserTransformer());
    }


    
}
