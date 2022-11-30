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

        //TRIP requires a startdatetime and driver user id
       if (isset($_GET['driverUserId']) 
            && $_GET['driverUserId'] != ''
            && isset($_GET['startDatetime']) 
            && DateTime::createFromFormat('Y-m-d H:i:s', str_replace(['%', 'T'], ' ', $_GET['startDatetime'])) != false) {
                //if required params are passed, create a trip

                $trip->userId = is_int($_GET['driverUserId']) ? $_GET['driverUserId'] : intval($_GET['driverUserId']);
                
                $trip->tripStatus = $_GET['tripStatus'];
                $trip->startDateTime = $_GET['startDatetime'];
                $trip->endDateTime = $_GET['endDatetime'];
                $trip->startCity = $_GET['startCity'];
                $trip->startStateCode = $_GET['startStateCode'];
                $trip->endCity = $_GET['endCity'];
                $trip->endStateCode = $_GET['endStateCode'];
                $trip->loadContents = $_GET['loadContents'];
                $trip->loadWeight = $_GET['loadWeight'];
                $trip->companyId = $_GET['companyId'];
                
                //test if passed user id is in the db
                if (!$trip->userCheck()){
                    //user not in the database
                    echo json_encode(array('message' => 'driverUserId Not Found'));
                    die();
                }
                //assume here passed user id is in the database, and passed date string is of valid format
                else if ($trip->create()){
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
                            'driverFirstName' => $trip->userFirstName,
                            'driverLastName' => $trip->userLastName,
                            'loadContents' => $trip->loadContents,
                            'loadWeight' => $trip->loadWeight,
                            'companyId' => $trip->companyId
                        )
                        );
                }
                else {
                    echo json_encode(
                        array('message' => 'Trip not created')
                    );
                }
        }
        else {
            print_r(json_encode(array('message' => 'Must pass driverUserId and startDatetime to create a trip!')));
            die(); //exit
        }


?>