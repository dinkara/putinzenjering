<?php

namespace App\Transformers;

use App\Models\Review;
use Dinkara\DinkoApi\Transformers\ApiTransformer;
/**
 * Description of ReviewTransformer
 *
 * @author Dinkic
 */
class ReviewTransformer extends ApiTransformer{
    
    protected $defaultIncludes = [];
    protected $availableIncludes = ['images', 'user', 'order', 'loading', 'questions'];
    protected $pivotAttributes = ['status'];
    
    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(Review $item)
    {
        $data = $this->transformFromModel($item, $this->pivotAttributes); 
        $data["status"] = $item->status();
        return $data;
    }
    
    public function includeLoading(Review $item)
    { 
       return $this->item($item->loadings, new LoadingTransformer());
    }
    public function includeImages(Review $item)
    {
       return $this->collection($item->images, new ImageTransformer());
    }
    public function includeUser(Review $item)
    { 
       return $this->item($item->user, new UserTransformer());
    }
    public function includeOrder(Review $item)
    { 
       return $this->item($item->order, new OrderTransformer());
    }
    public function includeQuestions(Review $item)
    {
       return $this->collection($item->questions, new QuestionTransformer());
    }


    
}
