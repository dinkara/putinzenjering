<?php

namespace App\Http\Requests;

//use App\Models\{{model}};
use Dinkara\DinkoApi\Http\Requests\ApiRequest;
use App\Support\Enum\OrderStatuses;

class StoreOrderRequest extends ApiRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
	    'category_id' => 'required',
	    'project_id' => 'required',
	    'quantity' => 'required',
	    'description' => 'required',

        ];
    }
}
