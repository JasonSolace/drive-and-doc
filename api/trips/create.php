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
            && isset($data->startDatetime) 
            && DateTime::createFromFormat('Y-m-d H:i:s', $data->startDatetime != false)) {
                //if required params are passed, create a trip

                $trip->queryStringUserId = is_int($data->driverUserId) ? $data->driverUserId : intval($data->driverUserId);
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
                            'ID' => $ID,
                            'tripStatus' => $TripStatus,
                            'startDateTime' => $StartDateTime,
                            'endDateTime' => $EndDateTime,
                            'startCity' => $StartCity,
                            'startStateCode' => $StartStateCode,
                            'endCity' => $EndCity,
                            'endStatecode' => $EndStateCode,
                            'driverUserId' => $UserId,
                            'driverFirstName' => $FirstName,
                            'driverLastName' => $LastName,
                            'loadContents' => $LoadContents,
                            'loadWeight' => $LoadWeight
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