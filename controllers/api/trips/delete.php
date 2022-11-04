<?php
       //headers
       header('Access-Control-Allow-Origin: *');
       header('Content-Type: application/json');
       header('Access-Control-Allow-Methods: POST');
       header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Origin,Authorization,X-Requested-With');
       
       include_once '../../../config/Database.php';
       include_once '../../../models/Trip.php';

       $database = new Database();
       $db = $database->connect();

       $trip = new Trip($db);

       //passed json body
       $data = json_decode(file_get_contents('php://input'));

       //DELETE trip requiers a Trip ID
       if (isset($_GET['ID'])){
                $trip->id = $_GET['ID'];
                $trip->delete();
            }
        else {
            print_r(json_encode(array('message' => 'No Trip ID Passed')));
            die(); //exit
        }









?>