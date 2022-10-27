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
       $trip->id = is_int($data->ID) ? $data->ID : intval($data->ID);

       //add a check here for no data other than trip id being passed

       //check to make sure that the passed trip id exists
       if (!$trip->tripCheck()){
            //now perform the necessary update
            $trip->tripStatus = $data->tripStatus;
            $trip->startDateTime = $data->startDatetime;
            $trip->endDateTime = $data->endDatetime;
            $trip->startCity = $data->startCity;
            $trip->startStateCode = $data->startStateCode;
            $trip->endCity = $data->endCity;
            $trip->endStateCode = $data->endStateCode;
            $trip->loadContents = $data->loadContents;
            $trip->loadWeight = $data->loadWeight;

            //don't pass a new user value unless it's set and valid
            if (isset($data->driverUserId)){
                //set the user id for user id check
                $trip->userId = is_int($data->driverUserId) ? $data->driverUserId : intval($data->driverUserId);
                if ($trip->userCheck()==false){
                    //a user id was passed, but not valid, return an error
                    echo json_encode(array('message' => 'driverUserId Not Found'));
                    die();
                }
            }
            //trip properties are set, try to update a trip
            if ($trip->update()){
                //if trip creation is successful, return the Trip
                echo json_encode(
                    array(
                        'ID' => $trip->id,
                        'tripStatus' => $trip->tripStatus,
                        'startDateTime' => $trip->startDateTime,
                        'endDateTime' => $trip->endDateTime,
                        'startCity' => $trip->startCity,
                        'startStateCode' => $trip->startStateCode,
                        'endCity' => $trip->endCity,
                        'endStatecode' => $trip->endStateCode,
                        'driverUserId' => $trip->userId,
                        'driverFirstName' => $trip->firstName,
                        'driverLastName' => $trip->lastName,
                        'loadContents' => $trip->loadContents,
                        'loadWeight' => $trip->loadWeight
                    )
                );
            }
            else { //update failed
                echo json_encode(
                    array('message' => 'Trip not updated')
                );
            }


       }
       else {
            //trip not in the database
            echo json_encode(array('message' => 'A Trip with this ID Was Not Found'));
            die();
        }











?>