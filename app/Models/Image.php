<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Dinkara\RepoBuilder\Traits\ApiModel;

class Image extends Model
{
    use ApiModel;
    
    
    
    protected $table = "images";
       
    /**
     * The attributes by you can search data.
     *
     * @var array
     */
    protected $searchableColumns = ['url'];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['review_id', 'loading_id', 'url'];
    
    /**
     * The attributes that are will be shown in transformer
     *
     * @var array
     */
    protected $displayable = ['url'];
    
    public $timestamps = true;
    
    public function review()
    {
        return $this->belongsTo('App\Models\Review', 'review_id');
    }
    public function loading()
    {
        return $this->belongsTo('App\Models\Loading', 'loading_id');
    }

}
