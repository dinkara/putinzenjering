<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Dinkara\RepoBuilder\Traits\ApiModel;

class Order extends Model
{
    use ApiModel;
    
    
    
    protected $table = "orders";
       
    /**
     * The attributes by you can search data.
     *
     * @var array
     */
    protected $searchableColumns = ['status', 'quantity', 'description'];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['category_id', 'project_id', 'quantity', 'description'];
    
    /**
     * The attributes that are will be shown in transformer
     *
     * @var array
     */
    protected $displayable = ['status', 'quantity', 'description'];
    
    public $timestamps = true;
    
    public function reviews($q = null, $orderBy = null)
    {
        $relation = $this->hasMany('App\Models\Review', 'order_id');
        if($q == null && $orderBy == null){
            return $relation;
        }
        return $this->searchRelation($relation, $q, $orderBy);
    }
    public function loadings($q = null, $orderBy = null)
    {
        $relation = $this->hasMany('App\Models\Loading', 'order_id');
        if($q == null && $orderBy == null){
            return $relation;
        }
        return $this->searchRelation($relation, $q, $orderBy);
    }
    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }
    public function project()
    {
        return $this->belongsTo('App\Models\Project', 'project_id');
    }

}
