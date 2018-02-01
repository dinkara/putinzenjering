<?php

namespace App\Repositories\Review;

use Dinkara\RepoBuilder\Repositories\IRepo;
use App\Models\Question;

/**
 * Interface ReviewRepository
 * @package App\Repositories\Review
 */
interface IReviewRepo extends IRepo {
   
    function attachQuestion(Question $model, array $data = []);


    function detachQuestion(Question $model);


}