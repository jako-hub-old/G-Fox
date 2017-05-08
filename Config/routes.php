<?php

use \GF\Components\Route;
Route::get("/", function(){
    echo "<h1>You are in home!</h1>";
});

Route::get("users/id:/hello", function($request, $id){
    echo "Hello {$id}";
});

Route::get("users/age:/sayHello/name:", function($request, $age, $name){
    echo "Hello my name is {$name} and I am {$age} years old<br>";
});

