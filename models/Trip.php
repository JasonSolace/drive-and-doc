<?php
class Trip {
    //DB connection
    private $conn;
    private $table = 'trip';

    //trip properties
    public $id; //primary key
    public $tripStatus;
    public $startDateTime;
    public $endDateTime;
    public $startCity;
    public $startStateCode;
    public $endCity;
    public $endStateCode;
    public $userId;
    public $loadContents;
    public $loadWeight;

    //user properties
    public $userFirstName;
    public $userLastName;

    //query strings
    public $queryStringId;
    public $queryStringStatus;
    public $queryStringStartCity;
    public $queryStringStartStateCode;
    public $queryStringEndCity;
    public $queryStringEndStateCode;
    public $queryStringUserFirstName;
    public $queryStringUserLastName;
    public $queryStringLoadContents;


    // constructor
    public function __construct($db) {
        $this->conn = $db;
    }

    //-------------GET TRIPS-------------------
    
    //by id
    public function searchTrip(){
        //given a trip id
        //returns that trip from the database
        
        //create query
        $query = "SELECT 
                    t.`ID`,
                    t.`TripStatus`,
                    t.`StartDateTime`,
                    t.`EndDateTime`,
                    t.`StartCity`,
                    t.`StartStateCode`,
                    t.`EndCity`,
                    t.`EndStateCode`,
                    t.`UserId`,
                    u.`FirstName`,
                    u.`LastName`,
                    t.`LoadContents`,
                    t.`LoadWeight`
                  FROM `trip` t
                    INNER JOIN `user` u
                        ON u.`ID` = t.`userId`
                  WHERE 
                        t.`ID` LIKE :queryStrId
                        OR t.`TripStatus` LIKE :queryStrStatus
                        OR t.`StartCity` LIKE :queryStrStartCity
                        OR t.`StartStateCode` LIKE :queryStrStartStateCode
                        OR t.`EndCity` LIKE :queryStrEndCity
                        OR t.`EndStateCode` LIKE :queryStrEndStateCode
                        OR u.`FirstName` LIKE :queryStrFirstName
                        OR u.`LastName` LIKE :queryStrLastName
                        OR t.`LoadContents` LIKE :queryStrLoadContents";
        //prepare statement
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':queryStrId', $this->queryStringId);
        $stmt->bindParam(':queryStrStatus', $this->queryStringStatus);
        $stmt->bindParam(':queryStrStartCity', $this->queryStringStartCity);
        $stmt->bindParam(':queryStrStartStateCode', $this->queryStringStartStateCode);
        $stmt->bindParam(':queryStrEndCity', $this->queryStringEndCity);
        $stmt->bindParam(':queryStrEndStateCode', $this->queryStringEndStateCode);
        $stmt->bindParam(':queryStrFirstName', $this->queryStringUserFirstName);
        $stmt->bindParam(':queryStrLastName', $this->queryStringUserLastName);
        $stmt->bindParam(':queryStrLoadContents', $this->queryStringLoadContents);
         
        //execute
        $stmt->execute();
        return $stmt;
    }

    
    public function userCheck(){
        //checks to see if the user id exists in the users table
        //returns boolean

        $usrSql = 'SELECT COUNT(*) "userIdCount" FROM USER WHERE ID = :queryStringUserId';
        $stmt = $this->conn->prepare($usrSql);
        $stmt->bindParam(':queryStringUserId', $this->userId, PDO::PARAM_INT);
        if ($stmt->execute()){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            extract($row);
            if ($userIdCount > 0){
                return true;
            }
            else {
                return false;
            }
        }
        else {
            printf('ERROR: %s.\n', $stmt->error);
            return false;
        }

    }

    public function tripCheck(){
        //checks to see if the user trip exists in the trip table
        //returns boolean

        $query = 'SELECT COUNT(*) "tripIdCount" FROM TRIP WHERE ID = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        if ($stmt->execute()){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            extract($row);
            if ($tripIdCount > 0){
                return true;
            }
            else {
                return false;
            }
        }
        else {
            printf('ERROR: %s.\n', $stmt->error);
            return false;
        }

}


    public function create(){
        //creates a new trip in the database
        $query = 'INSERT INTO TRIP (
                TripStatus,
                StartDateTime,
                EndDateTime,
                StartCity,
                StartStateCode,
                EndCity,
                EndStateCode,
                UserId,
                LoadContents,
                LoadWeight
                )
                VALUES (
                :tripStatus,
                :startDateTime,
                :endDateTime,
                :startCity,
                :startStateCode,
                :endCity,
                :endStateCode,
                :userId,
                :loadContents,
                :loadWeight
                );
                ';

        //create a sql statement
        $stmt = $this->conn->prepare($query);
        
        //clean to prevent sql injection
        $this->tripStatus = htmlspecialchars(strip_tags($this->tripStatus));
        $this->startDateTime = htmlspecialchars(strip_tags($this->startDateTime));
        $this->endDateTime = htmlspecialchars(strip_tags($this->endDateTime));
        $this->startCity = htmlspecialchars(strip_tags($this->startCity));
        $this->startStateCode = htmlspecialchars(strip_tags($this->startStateCode));
        $this->endCity = htmlspecialchars(strip_tags($this->endCity));
        $this->endStateCode = htmlspecialchars(strip_tags($this->endStateCode));
        $this->userId = htmlspecialchars(strip_tags($this->userId));
        $this->loadContents = htmlspecialchars(strip_tags($this->loadContents));
        $this->loadWeight = htmlspecialchars(strip_tags($this->loadWeight));
        
        //bind data
        //pass null if a field is not set, except user id and start datetime
        $stmt->bindParam(':tripStatus', $this->tripStatus); 
        $stmt->bindParam(':startDateTime', $this->startDateTime); 
        $stmt->bindParam(':endDateTime', $this->endDateTime); 
        $stmt->bindParam(':startCity', $this->startCity); 
        $stmt->bindParam(':startStateCode', $this->startStateCode); 
        $stmt->bindParam(':endCity', $this->endCity); 
        $stmt->bindParam(':endStateCode', $this->endStateCode); 
        $stmt->bindParam(':userId', $this->userId, PDO::PARAM_INT); 
        $stmt->bindParam(':loadContents', $this->loadContents); 
        $stmt->bindParam(':loadWeight', $this->loadWeight, PDO::PARAM_INT); 
        
        //execute the insert statement
        if ($stmt->execute()){
            //get the created record
            $newTripId = '
                SELECT 
                    t.ID,
                    t.TripStatus,
                    t.StartDateTime,
                    t.EndDateTime,
                    t.StartCity,
                    t.StartStateCode,
                    t.EndCity,
                    t.EndStateCode,
                    t.UserId,
                    u.FirstName,
                    u.LastName,
                    t.LoadContents,
                    t.LoadWeight
                FROM TRIP t
                    INNER JOIN USER u
                        ON u.ID = t.userId
                WHERE t.ID = (SELECT MAX(ID) FROM TRIP)';
            $stmtId = $this->conn->prepare($newTripId);
            if ($stmtId->execute()){
                $row = $stmtId->fetch(PDO::FETCH_ASSOC);
                extract($row);
                $this->id = $ID;
                $this->tripStatus = $TripStatus;
                $this->startDateTime = $StartDateTime;
                $this->endDateTime = $EndDateTime;
                $this->startCity = $StartCity;
                $this->startStateCode = $StartStateCode;
                $this->endCity = $EndCity;
                $this->endStateCode = $EndStateCode;
                $this->userId = $UserId;
                $this->userFirstName = $FirstName;
                $this->userLastName = $LastName;
                $this->loadContents = $LoadContents;
                $this->loadWeight = $LoadWeight;
                
            } else {
                printf('Error retrieving newly created Trip: %s.\n', $stmtId->error);
            }
            return true;

        }
        else {
            //print error
            printf('Error: %s.\n', $stmt->error);
            return false;
        }
    }



    public function delete(){
        //delete a trip
        $query = 'DELETE FROM TRIP WHERE ID = :ID;';
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':ID', $this->id, PDO::PARAM_INT);

        if ($stmt->execute()){
            $affectedRows = $stmt->rowCount();
            if ($affectedRows==0){
                echo json_encode(
                    array('id' => $this->id,
                          'message' => 'No Trip with passed ID found')
                    );
                }
            else {
                echo json_encode(
                    array('id' => $this->id,
                          'message' => 'Trip deleted')
                );
            }
        }
        else {
            printf('ERROR: %s.\n', $stmt->error);
        }
    }


    public function update(){
        //updates a trip record
        $query = 'UPDATE TRIP 
                  SET '
                  . (is_null($this->tripStatus) ? '' : ' TripStatus = :tripStatus,') 
                  . (is_null($this->startDateTime) ? '' : ' StartDateTime = :startDateTime,')
                  . (is_null($this->endDateTime) ? '' : ' EndDateTime  = :endDateTime,')
                  . (is_null($this->startCity) ? '' : ' StartCity  = :startCity,')
                  . (is_null($this->startStateCode) ? '' : ' StartStateCode  = :startStateCode,')
                  . (is_null($this->endCity) ? '' : ' EndCity = :endCity,')
                  . (is_null($this->endStateCode) ? '' : ' EndStateCode  = :endStateCode,')
                  . (is_null($this->userId) ? '' : ' UserId  = :userId,')
                  . (is_null($this->loadContents) ? '' : ' LoadContents  = :loadContents,')
                  . (is_null($this->loadWeight) ? '' : ' LoadWeight  = :loadWeight,');
        $query = rtrim($query, ',') . ' WHERE ID = :id '; //remove the final comma and add where clause
        print_r($query);
        //create a sql statement
        $stmt = $this->conn->prepare($query);

        
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        //bind data, but only if field is set so we don't overwrite with null
        if (!is_null($this->tripStatus)){
            $this->tripStatus = htmlspecialchars(strip_tags($this->tripStatus));
            $stmt->bindParam(':tripStatus', $this->tripStatus); 
        }
        if (!is_null($this->startDateTime)){
            $this->startDateTime = htmlspecialchars(strip_tags($this->startDateTime));
            $stmt->bindParam(':startDateTime', $this->startDateTime);
        }
        if (!is_null($this->endDateTime)){ 
            $this->endDateTime = htmlspecialchars(strip_tags($this->endDateTime));
            $stmt->bindParam(':endDateTime', $this->endDateTime); 
        }
        if (!is_null($this->startCity)){
            $this->startCity = htmlspecialchars(strip_tags($this->startCity));
            $stmt->bindParam(':startCity', $this->startCity); 
        }
        if (!is_null($this->startStateCode)){
            $this->startStateCode = htmlspecialchars(strip_tags($this->startStateCode));
            $stmt->bindParam(':startStateCode', $this->startStateCode); 
        }
        if (!is_null($this->endCity)){
            $this->endCity = htmlspecialchars(strip_tags($this->endCity));
            $stmt->bindParam(':endCity', $this->endCity); 
        }
        if (!is_null($this->endStateCode)){
            $this->endStateCode = htmlspecialchars(strip_tags($this->endStateCode));
            $stmt->bindParam(':endStateCode', $this->endStateCode); 
        }
        if (!is_null($this->userId)){
            $this->userId = htmlspecialchars(strip_tags($this->userId));
            $stmt->bindParam(':userId', $this->userId, PDO::PARAM_INT); 
        }
        if (!is_null($this->loadContents)){
            $this->loadContents = htmlspecialchars(strip_tags($this->loadContents));
            $stmt->bindParam(':loadContents', $this->loadContents); 
        }
        if (!is_null($this->loadWeight)){
            $this->loadWeight = htmlspecialchars(strip_tags($this->loadWeight));
            $stmt->bindParam(':loadWeight', $this->loadWeight, PDO::PARAM_INT); 
        }

        //update the record
        if ($stmt->execute()){
            //get the updated record
            $newTripId = '
                SELECT 
                    t.ID,
                    t.TripStatus,
                    t.StartDateTime,
                    t.EndDateTime,
                    t.StartCity,
                    t.StartStateCode,
                    t.EndCity,
                    t.EndStateCode,
                    t.UserId,
                    u.FirstName,
                    u.LastName,
                    t.LoadContents,
                    t.LoadWeight
                FROM TRIP t
                    INNER JOIN USER u
                        ON u.ID = t.userId
                WHERE t.ID = :id';
            $stmtId = $this->conn->prepare($newTripId);
            $stmtId->bindParam(':id', $this->id, PDO::PARAM_INT);
            if ($stmtId->execute()){
                $row = $stmtId->fetch(PDO::FETCH_ASSOC);
                extract($row);
                $this->id = $ID;
                $this->tripStatus = $TripStatus;
                $this->startDateTime = $StartDateTime;
                $this->endDateTime = $EndDateTime;
                $this->startCity = $StartCity;
                $this->startStateCode = $StartStateCode;
                $this->endCity = $EndCity;
                $this->endStateCode = $EndStateCode;
                $this->userId = $UserId;
                $this->userFirstName = $FirstName;
                $this->userLastName = $LastName;
                $this->loadContents = $LoadContents;
                $this->loadWeight = $LoadWeight;
                
            } else {
                printf('Error retrieving updated Trip: %s.\n', $stmtId->error);
            }
            return true;

        }
        else {
            //print error
            printf('Error: %s.\n', $stmt->error);
            return false;
        }



    }

}