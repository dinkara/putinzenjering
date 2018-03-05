<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ReviewService
 *
 * @author Dinkic
 */
use PDF;
use App\Repositories\Review\IReviewRepo;

class ReviewService {
    protected $reviewRepo;
    
    public function __construct(IReviewRepo $reviewRepo) {
        $this->reviewRepo = $reviewRepo;
    }
}
