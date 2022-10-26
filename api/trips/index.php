<?php

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST, PUT, DELETE, GET');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Origin,Content-Type, Access-Control-Allow-Methods,Authorization, X-Requested-With');


    $request_method = $_SERVER['REQUEST_METHOD'];

    switch ($request_method){
        case 'GET':
           
            require 'retrieve.php';
            break;

    }






?>