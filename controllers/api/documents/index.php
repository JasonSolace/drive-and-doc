<?php

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST, PUT, DELETE, GET');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Origin,Content-Type, Access-Control-Allow-Methods,Authorization, X-Requested-With');


    $request_method = $_SERVER['REQUEST_METHOD'];
    //$data = json_decode(file_get_contents('php://input'));
    print_r($request_method);
    switch ($request_method){
        case 'GET':

            break;
        case 'POST':
            print_r('test index');
            require 'upload.php';
            break;
        case 'PUT':
            break;
        case 'DELETE':
            break;
    }






?>