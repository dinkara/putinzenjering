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

    /**
     * CollectionWriter constructor.
     *
     * @param Collection $routeGroups
     */
    public function __construct(Collection $routeGroups)
    {
        $this->routeGroups = $routeGroups;
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
            'item' => $this->routeGroups->map(function ($routes, $groupName) {
                return [
                    'name' => $groupName,
                    'description' => '',
                    'item' => $routes->map(function ($route) {
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
                                            $param = "ndzakovic@yahoo.com";
                                        }else if($key === "password"){
                                            $param = "prasence123";
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
                    })->toArray(),
                ];
            })->values()->toArray(),
        ];

        return json_encode($collection);
    }
}
