<?php

namespace App\Http\Requests;

//use App\Models\{{model}};
use Dinkara\DinkoApi\Http\Requests\ApiRequest;

class StoreReviewRequest extends ApiRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
	    'order_id' => 'required',
	    'description' => 'required',

        ];
    }
}
