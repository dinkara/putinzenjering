<?php

namespace App\Transformers;

use App\Models\Project;
use Dinkara\DinkoApi\Transformers\ApiTransformer;
/**
 * Description of ProjectTransformer
 *
 * @author Dinkic
 */
class ProjectTransformer extends ApiTransformer{
    
    protected $defaultIncludes = [];
    protected $availableIncludes = ['orders', 'users'];
    protected $pivotAttributes = [];
    
    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(Project $item)
    {
        return $this->transformFromModel($item, $this->pivotAttributes);
    }
    
    public function includeOrders(Project $item)
    {
       return $this->collection($item->orders, new OrderTransformer());
    }
    public function includeUsers(Project $item)
    {
       return $this->collection($item->users, new UserTransformer());
    }


    
}
