<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Dinkara\RepoBuilder\Traits\ApiModel;

class Review extends Model
{
    use ApiModel;
    
    
    
    protected $table = "reviews";
       
    /**
     * The attributes by you can search data.
     *
     * @var array
     */
    protected $searchableColumns = ['description', 'position', 'order.description', 'order.project.name'];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'order_id', 'description'];
    
    /**
     * The attributes that are will be shown in transformer
     *
     * @var array
     */
    protected $displayable = ['created_at', 'updated_at', 'description', 'position'];
    
    public $timestamps = true;
    
    public function status(){
        $questions = $this->questions;
        if(count($questions) == 0){
            return false;
        }
        
        $status = true;
        
        foreach($questions as $question){
            if($question->pivot->status != 1){
                return false;
            }
        }
        
        return $status;
    }
    
    public function questions($q = null, $orderBy = null)
    {
        $relation = $this->belongsToMany('App\Models\Question', 'reviews_questions', 'review_id', 'question_id')->withTimestamps()->withPivot('status');
        if($q == null && $orderBy == null){
            return $relation;
        }
        return $this->searchRelation($relation, $q, $orderBy);
    }
    public function images($q = null, $orderBy = null)
    {
        $relation = $this->hasMany('App\Models\Image', 'review_id');
        if($q == null && $orderBy == null){
            return $relation;
        }
        return $this->searchRelation($relation, $q, $orderBy);
    }
    public function loadings()
    {
        return $this->hasOne('App\Models\Loading', 'review_id');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id');
    }

}
