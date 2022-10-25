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
                        t.`ID` LIKE '%?%' 
                        OR t.`TripStatus` LIKE '%?%'
                        OR t.`StartDateTime` LIKE '%?%'
                        OR t.`EndDateTime` LIKE '%?%'
                        OR t.`StartCity` LIKE '%?%'
                        OR t.`StartStateCode LIKE '%?%'
                        OR t.`EndCity` LIKE '%?%'
                        OR t.`EndStateCode` LIKE '%?%'
                        OR u.`FirstName` LIKE '%?%'
                        OR u.`LastName` LIKE '%?%'
                        OR u.`UserId` LIKE '%?%'
                        OR t.`LoadContents` LIKE '%?%'";
        //prepare statement
        $stmt = $this->conn->prepare($query);
        //bind param
        $stmt->bindParam(1, $this->id);
        //execute
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $stmt;
    }




}