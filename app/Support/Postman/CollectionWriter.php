<?php

namespace App\Support\Postman;

use Ramsey\Uuid\Uuid;
use Illuminate\Support\Collection;

class CollectionWriter
{
    /**
     * @var Collection
     */
    private $routeGroups;
    private $adminRoutes;
    /**
     * CollectionWriter constructor.
     *
     * @param Collection $routeGroups
     */
    public function __construct(Collection $routeGroups)
    {
        $this->routeGroups = $routeGroups;
        $this->adminRoutes = ['name' => 'Admin', 'item' => []];
    }

    public function getCollection()
    {
        //dd($this->routeGroups[0]);

        $collection = [
            'variables' => [],
            'info' => [
                'name' => '',
                '_postman_id' => Uuid::uuid4()->toString(),
                'description' => '',
                'schema' => 'https://schema.getpostman.com/json/collection/v2.0.0/collection.json',
            ],
            'item' => $this->items(),
        ];
        $collection['item'] = $this->array_non_empty_items($collection['item']);
        array_push($collection['item'], $this->adminRoutes);
        return json_encode($collection);
    }
    
    private function items() {
        return $this->routeGroups->map(function ($routes, $groupName) {
            if (strpos($groupName, 'Admin\\') !== false){
                $names = explode("\\", $groupName);
                $item = [
                    'name' => $names[1],
                    'description' => '',
                    'item' => $this->item($routes),
                    "_postman_isSubFolder" => true
                ];
                array_push($this->adminRoutes['item'], $item);
                return;
            }
            else{
                return [
                    'name' => $groupName,
                    'description' => '',
                    'item' => $this->item($routes),
                ];
            }

            })->values()->toArray();
    }
    
    private function item($routes) {
        return $routes->map(function ($route) {
                        $event = [];
                        $header = [];
                        if($route['title'] === "Login" || $route['title'] === "Refresh token"){
                            $event = [[
                                "listen" => "test",
                                "script" => [
                                    "type" => "text/javascript",
                                    "exec" => [ 
                                                "tests[\"Body matches string\"] = responseBody.has(\"token\");",
                                                "tests[\"Status code is 200\"] = responseCode.code === 200;",
                                                "",
                                                "var jsonData = JSON.parse(responseBody);",
                                                "var token = jsonData.data.token;",
                                                "",
                                                "tests[\"Has token inside it\"] = typeof token === 'string';",
                                                "",
                                                "postman.setGlobalVariable(\"AUTH_TOKEN\", token);"
                                            ]
                                    ]
                            ]]; 
                            $header = [[
                                    'key' => 'Authorization',
                                    'value' => 'Bearer {{AUTH_TOKEN}}'
                                ]];
                        }
                        if(in_array('dinkoapi.auth', $route['middlewares'])){
                                $header = [[
                                    'key' => 'Authorization',
                                    'value' => 'Bearer {{AUTH_TOKEN}}'
                                ]];
                        }
                        $mode = 'formdata';
                        if($route['methods'][0] === "PUT"){
                            $putData = [
                                "key" => "Content-Type",
                                "value" => "application/x-www-form-urlencoded",
                                "description" => ""
                            ];
                            array_push($header, $putData);
                            $mode = 'urlencoded';
                        }
	
                        return [
                            'name' => $route['title'] != '' ? $route['title'] : url($route['uri']),
                            'event' => $event, 
                            'request' => [
                                'url' => url($route['uri']),
                                'method' => $route['methods'][0],
                                'header' => $header,
                                'body' => [
                                    'mode' => $mode,
                                    $mode => collect($route['parameters'])->map(function ($parameter, $key) {
                                        $param = "";
                                        if($key === "email"){
                                            $param = "putin@yahoo.com";
                                        }else if($key === "password"){
                                            $param = "putin123";
                                        }else if(isset($parameter['value'])){
                                            $param = $parameter['value'];
                                        }
                                        return [
                                            'key' => $key,
                                            'value' => $param,
                                            'type' => 'text',
                                            'enabled' => true,
                                        ];
                                    })->values()->toArray(),
                                ],
                                'description' => $route['description'],
                                'response' => [],
                            ],
                        ];
                    })->toArray();
    }
    
    private function array_non_empty_items($input) {      
        $result = [];  
        foreach ($input as $value) {
          if($value) {
              array_push($result, $value);
          }
        }
        return $result;
    }
}
