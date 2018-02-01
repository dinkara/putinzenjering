<?php

namespace App\Transformers;

use App\Models\Image;
use Dinkara\DinkoApi\Transformers\ApiTransformer;
/**
 * Description of ImageTransformer
 *
 * @author Dinkic
 */
class ImageTransformer extends ApiTransformer{
    
    protected $defaultIncludes = [];
    protected $availableIncludes = ['review', 'loading'];
    protected $pivotAttributes = [];
    
    /**
     * Turn this item object into a generic array
     *
     * @return array
     */
    public function transform(Image $item)
    {
        return $this->transformFromModel($item, $this->pivotAttributes);
    }
    
    public function includeReview(Image $item)
    { 
       return $this->item($item->review, new ReviewTransformer());
    }
    public function includeLoading(Image $item)
    { 
       return $this->item($item->loading, new LoadingTransformer());
    }


    
}
