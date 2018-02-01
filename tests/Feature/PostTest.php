<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    protected $resource;
    
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testPost()
    {        
	$this->storePost();
			
	$this->getPost();
    } 
    
    private function headers(){
	return $this->withHeaders(
	[
            'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsImlzcyI6Imh0dHA6Ly96aXBwZ28uZGV2L2FwaS9sb2dpbiIsImlhdCI6MTUxMTIyMDYyMywiZXhwIjoxNTExMjI0MjIzLCJuYmYiOjE1MTEyMjA2MjMsImp0aSI6InFYTHFvVzcwUG9lYTlCUkYifQ.1jeS-g0-UezPapf_mxJU5NDVbbOtHqnA7gqmIxgtw2k',
        ]);
    }
    
    private function storePost(){
	$response = $this->headers()->json('POST', '/api/posts', ['text' => 'Sally']);		
		
        $response->assertSuccessful();
	$response->assertStatus(201);
        $response->assertExactJson([
	    'success' => true,
	    'message' => "Post succesfully created",
	    'data' => [
		"id" => 38,
		"text" => "Sally"
	    ],
	]);
	
	$this->resource = $response->getData()->data;
    }
    
    private function getPost(){
	$id = $this->resource->id;
	
	$response = $this->headers()->json('GET', '/api/posts/'.$id);

        $response->assertSuccessful();
	$response->assertStatus(200);
        $response->assertExactJson([
	    'success' => true,
	    'message' => "Ok",
	    'data' => $this->resource,
	]);	
    }
}
