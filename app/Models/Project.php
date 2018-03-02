<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Dinkara\RepoBuilder\Traits\ApiModel;

class Project extends Model
{
    use ApiModel;
    
    
    
    protected $table = "projects";
       
    /**
     * The attributes by you can search data.
     *
     * @var array
     */
    protected $searchableColumns = ['name', 'location', 'description', 'status'];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'location', 'description', 'status'];
    
    /**
     * The attributes that are will be shown in transformer
     *
     * @var array
     */
    protected $displayable = ['name', 'location', 'description', 'status'];
    
    public $timestamps = true;
    
    public function orders($q = null, $orderBy = null)
    {
        $relation = $this->hasMany('App\Models\Order', 'project_id');
        if($q == null && $orderBy == null){
            return $relation;
        }
        return $this->searchRelation($relation, $q, $orderBy);
    }
    public function users($q = null, $orderBy = null)
    {
        $relation = $this->belongsToMany('App\Models\User', 'users_projects', 'project_id', 'user_id')->withTimestamps();
        if($q == null && $orderBy == null){
            return $relation;
        }
        return $this->searchRelation($relation, $q, $orderBy);
    }

}
