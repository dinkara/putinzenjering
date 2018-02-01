<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Dinkara\RepoBuilder\Traits\ApiModel;

class Truck extends Model
{
    use ApiModel;
    
    
    
    protected $table = "trucks";
       
    /**
     * The attributes by you can search data.
     *
     * @var array
     */
    protected $searchableColumns = ['plate'];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['plate'];
    
    /**
     * The attributes that are will be shown in transformer
     *
     * @var array
     */
    protected $displayable = ['plate'];
    
    public $timestamps = true;
    
    public function loadings()
    {
        return $this->hasOne('App\Models\Loading', 'truck_id');
    }

}
