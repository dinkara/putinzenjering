<?php

namespace App\Transformers;

use App\Models\Role;
use Dinkara\DinkoApi\Transformers\ApiTransformer;
/**
 * Description of RoleTransformer
 *
 * @author Dinkic
 */
class RoleTransformer extends ApiTransformer{
    
    protected $defaultIncludes = [];
    protected $availableIncludes = ['users'];
    protected $pivotAttributes = [];
    
    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(Role $item)
    {
        return $this->transformFromModel($item, $this->pivotAttributes);
    }
    
    public function includeUsers(Role $item)
    {
       return $this->collection($item->users, new UserTransformer());
    }


    
}
