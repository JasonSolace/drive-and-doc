<?php

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST, PUT, DELETE, GET');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Origin,Content-Type, Access-Control-Allow-Methods,Authorization, X-Requested-With');


    $request_method = $_SERVER['REQUEST_METHOD'];
    $data = json_decode(file_get_contents('php://input'));

    switch ($request_method){
        case 'GET':
            if (isset($_GET['ID'])) {
                require 'read_single.php';
            }
            else if (isset($_GET['driverUserId'])) {
                require 'read_driver_trips.php';
            }
            else if (isset($_GET['userId'])) {
                require 'read_admin_trips.php';
            }
            else{
                require 'read.php';
            }
            break;
        case 'POST':
            require 'create.php';
            break;
        case 'PUT':
            require 'update.php';
            break;
        case 'DELETE':
            require 'delete.php';
            break;
    }