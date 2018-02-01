<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Dinkara\RepoBuilder\Traits\ApiModel;

class PasswordReset extends Model
{
    use ApiModel;
    
    
    
    protected $table = "password_resets";
       
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
    protected $fillable = ['token', 'user_id'];
    
    /**
     * The attributes that are will be shown in transformer
     *
     * @var array
     */
    protected $displayable = [];
    
    public $timestamps = true;
    
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

}
