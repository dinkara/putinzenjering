<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Dinkara\RepoBuilder\Traits\ApiModel;

class Role extends Model
{
    use ApiModel;
    
    
    
    protected $table = "roles";
       
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
    protected $fillable = [];
    
    /**
     * The attributes that are will be shown in transformer
     *
     * @var array
     */
    protected $displayable = ['name'];
    
    public $timestamps = true;
    
    public function users($q = null, $orderBy = null)
    {
        $relation = $this->belongsToMany('App\Models\User', 'users_roles', 'role_id', 'user_id')->withTimestamps();
        if($q == null && $orderBy == null){
            return $relation;
        }
        return $this->searchRelation($relation, $q, $orderBy);
    }

}
