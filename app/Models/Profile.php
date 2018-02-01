<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Dinkara\RepoBuilder\Traits\ApiModel;

class Profile extends Model
{
    use ApiModel;
    
    
    
    protected $table = "profiles";
       
    /**
     * The attributes by you can search data.
     *
     * @var array
     */
    protected $searchableColumns = ['name'];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'user_id'];
    
    /**
     * The attributes that are will be shown in transformer
     *
     * @var array
     */
    protected $displayable = ['name'];
    
    public $timestamps = true;
    
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

}
