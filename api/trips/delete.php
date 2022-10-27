<?php
       //headers
       header('Access-Control-Allow-Origin: *');
       header('Content-Type: application/json');
       header('Access-Control-Allow-Methods: POST');
       header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Origin,Authorization,X-Requested-With');
       
       include_once '../../config/Database.php';
       include_once '../../models/Trip.php';

       $database = new Database();
       $db = $database->connect();

       $trip = new Trip($db);

       //passed json body
       $data = json_decode(file_get_contents('php://input'));

       //TRIP requires a startdatetime and driver user id
       if (isset($data->driverUserId) 
            && $data->driverUserId != ''
            && isSeet($data->startDatetime) 
            && DateTime::createFromFormat('Y-m-d H:i:s', $data->startDatetime != false){

            }
        else {
            print_r(json_encode(array('message' => 'No Query String Passed')));
            die(); //exit
        }









?>