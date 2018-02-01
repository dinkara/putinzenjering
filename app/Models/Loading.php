<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Dinkara\RepoBuilder\Traits\ApiModel;

class Loading extends Model
{
    use ApiModel;
    
    
    
    protected $table = "loadings";
       
    /**
     * The attributes by you can search data.
     *
     * @var array
     */
    protected $searchableColumns = [];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'review_id', 'truck_id', 'order_id'];
    
    /**
     * The attributes that are will be shown in transformer
     *
     * @var array
     */
    protected $displayable = [];
    
    public $timestamps = true;
    
    public function images($q = null, $orderBy = null)
    {
        $relation = $this->hasMany('App\Models\Image', 'loading_id');
        if($q == null && $orderBy == null){
            return $relation;
        }
        return $this->searchRelation($relation, $q, $orderBy);
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
    public function review()
    {
        return $this->belongsTo('App\Models\Review', 'review_id');
    }
    public function truck()
    {
        return $this->belongsTo('App\Models\Truck', 'truck_id');
    }
    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id');
    }

}
