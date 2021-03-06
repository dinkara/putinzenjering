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
        $result = $this->transformFromModel($item, $this->pivotAttributes);
        $result['url'] = config("app.url")."/storage/". $result['url'];
        return $result;
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
