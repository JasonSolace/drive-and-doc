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

    //query string
    public $queryString;

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
                        t.`StartCity` = :queryStr
                        OR t.`ID` LIKE :queryStr
                        OR t.`TripStatus` LIKE :queryStr
                        OR t.`StartDateTime` LIKE :queryStr
                        OR t.`EndDateTime` LIKE :queryStr
                        OR t.`StartStateCode LIKE :queryStr
                        OR t.`EndCity` LIKE :queryStr
                        OR t.`EndStateCode` LIKE :queryStr
                        OR u.`FirstName` LIKE :queryStr
                        OR u.`LastName` LIKE :queryStr
                        OR u.`UserId` LIKE :queryStr
                        OR t.`LoadContents` LIKE :queryStr";
        //prepare statement
        $queryStrX = 0;
        $query = preg_replace_callback("/\:queryStr/", function ($matches) use (&$queryStrX) { $queryStrX++; return $matches[0] . ($queryStrX - 1);}, $query);
        $stmt = $this->conn->prepare($query);
        for ($i = 0; $i < $queryStrX; $i++){
            $stmt->bindValue(":term$i", "%$this->queryString%", PDO::PARAM_STR);
        }
        #print_r($query);
        
        #$stmt->bindParam(1, $this->queryString);
        
        #$stmt->bindParam(':queryString', $this->queryString, PDO::PARAM_STR);
        #$testQueryString = 'Topeka';
        #$stmt->bindParam(1, $testQueryString, PDO::PARAM_STR);
        
        //execute
        $stmt->execute();
        return $stmt;
    }




}