<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Dinkara\RepoBuilder\Traits\ApiModel;

class Question extends Model
{
    use ApiModel;
    
    
    
    protected $table = "questions";
       
    /**
     * The attributes by you can search data.
     *
     * @var array
     */
    protected $searchableColumns = ['text'];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['text'];
    
    /**
     * The attributes that are will be shown in transformer
     *
     * @var array
     */
    protected $displayable = ['text'];
    
    public $timestamps = true;
    
    public function reviews($q = null, $orderBy = null)
    {
        $relation = $this->belongsToMany('App\Models\Review', 'reviews_questions', 'question_id', 'review_id')->withTimestamps()->withPivot('status');
        if($q == null && $orderBy == null){
            return $relation;
        }
        return $this->searchRelation($relation, $q, $orderBy);
    }

}
