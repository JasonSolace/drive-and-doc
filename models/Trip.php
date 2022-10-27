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
        #print_r($stmt);
        #$stmt->bindParam(':queryString', $this->queryString, PDO::PARAM_STR);
        #$testQueryString = 'Topeka';
        #$stmt->bindParam(1, $testQueryString, PDO::PARAM_STR);
        
        //execute
        $stmt->execute();
        return $stmt;
    }

    
    public function userCheck(){
        //checks to see if the user id exists in the users table
        //returns boolean

        $usrSql = 'SELECT COUNT(*) "userIdCount" FROM USER WHERE ID = :queryStringUserId';
        $stmt = $this->conn->prepare($usrSql);
        $stmt->bindParam(':queryUserStringId', $this->queryStringUserId);

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

    public function create(){
        //creates a new trip in the database
        $createSql = 'INSERT INTO TRIP



    }



}