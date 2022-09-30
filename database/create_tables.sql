USE drive_and_doc;

CREATE TABLE USERTYPES (
	ID int NOT NULL,
	UserTypeName varchar(50),
	PRIMARY KEY (ID)
);
    

CREATE TABLE USERS (
	ID mediumint NOT NULL AUTO_INCREMENT,
	Username varchar(50) NOT NULL,
    UserTypeId int NOT NULL,
    FirstName varchar(144),
    LastName varchar(144),
    PRIMARY KEY (ID),
    FOREIGN KEY (UserTypeId) REFERENCES USERTYPES(ID)
    );
    
    
    CREATE TABLE TRIPS (
		ID mediumint NOT NULL AUTO_INCREMENT,
        TripStatus varchar(50),
        StartDateTime datetime NOT NULL,
        EndDateTime datetime,
        StartCity varchar(144),
        StartStateCode char(2),
        EndCity varchar(144),
        EndStateCode char(2),
		UserId mediumint NOT NULL,
        LoadContents varchar(255),
        LoadWeight mediumint,
        PRIMARY KEY (ID),
        FOREIGN KEY (UserId) REFERENCES USERS(ID)
		);
        
        

    CREATE TABLE ADMINDRIVERS (
		ID mediumint NOT NULL AUTO_INCREMENT,
        AdminUserId mediumint,
        DriverUserId mediumint,
        StartDate datetime,
        EndDate datetime,
        PRIMARY KEY (ID),
        FOREIGN KEY (AdminUserID) REFERENCES USERS(ID),
        FOREIGN KEY (DriverUserID) REFERENCES USERS(ID)
    );
    
    CREATE TABLE DOCUMENTS (
		ID mediumint NOT NULL AUTO_INCREMENT,
        DocFilePath VARCHAR(255) NOT NULL,
        TripId mediumint,
        PRIMARY KEY (ID),
        FOREIGN KEY (TripId) REFERENCES TRIPS(ID)
    );
    
    
    