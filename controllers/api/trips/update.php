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
    
        if (!isset($_GET['ID'])){
            echo json_encode(array('message' => 'Must pass ID parameter for trip to be updated.'));
            die();
        }

       //passed json body
       $trip->id = is_int($_GET['ID']) ? $_GET['ID'] : intval($_GET['ID']);
       //add a check here for no data other than trip id being passed

       //check to make sure that the passed trip id exists
       if ($trip->tripCheck()){
            //now perform the necessary update
            $trip->tripStatus = $_GET['tripStatus'] ?? NULL;
            $trip->startDateTime = isset($_GET['startDatetime']) ? str_replace(['%', 'T'], ' ', $_GET['startDatetime']) : NULL;
            $trip->endDateTime = isset($_GET['endDatetime']) ? str_replace(['%', 'T'], ' ', $_GET['endDatetime']) : NULL;
            $trip->startCity = $_GET['startCity'] ?? NULL;
            $trip->startStateCode = $_GET['startStateCode'] ?? NULL;
            $trip->endCity = $_GET['endCity'] ?? NULL;
            $trip->endStateCode = $_GET['endStateCode'] ?? NULL;
            $trip->loadContents = $_GET['loadContents'] ?? NULL;
            $trip->loadWeight = $_GET['loadWeight'] ?? NULL;
            $trip->companyId = $_GET['companyId'] ?? NULL;

            //don't pass a new user value unless it's set and valid
            if (isset($_GET['driverUserId'])){
                //set the user id for user id check
                $trip->userId = is_int($_GET['driverUserId']) ? $_GET['driverUserId'] : intval($_GET['driverUserId']);
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
                        'endStateCode' => $trip->endStateCode,
                        'driverUserId' => $trip->userId,
                        'driverFirstName' => $trip->userFirstName,
                        'driverLastName' => $trip->userFirstName,
                        'loadContents' => $trip->loadContents,
                        'loadWeight' => $trip->loadWeight,
                        'companyId' => $trip->companyId
                        
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