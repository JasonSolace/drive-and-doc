USE drive_and_doc;

CREATE TABLE USER_TYPE (
	ID int NOT NULL,
	UserTypeName varchar(50),
	PRIMARY KEY (ID)
);
    

CREATE TABLE USER (
	ID mediumint NOT NULL AUTO_INCREMENT,
	Username varchar(50) NOT NULL,
    Password VARCHAR(255) NOT NULL,
    UserTypeId int NOT NULL,
    FirstName varchar(144),
    LastName varchar(144),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    CompanyId mediumint,
    PRIMARY KEY (ID),
    FOREIGN KEY (UserTypeId) REFERENCES USER_TYPE(ID),
    FOREIGN KEY (CompanyId) REFERENCES COMPANY(ID)
    );
    
    
    CREATE TABLE TRIP (
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
        CompanyId mediumint,
        PRIMARY KEY (ID),
        FOREIGN KEY (UserId) REFERENCES USER(ID),
        FOREIGN KEY (CompanyId) REFERENCES COMPANY(ID)
		);
        
        


    
    CREATE TABLE DOCUMENT_TYPE (
		ID mediumint NOT NULL AUTO_INCREMENT,
        DocumentTypeName VARCHAR(255),
        PRIMARY KEY (ID)
    );
    
    CREATE TABLE DOCUMENT (
		ID mediumint NOT NULL AUTO_INCREMENT,
        DocFilePath VARCHAR(255) NOT NULL,
        DocTypeId mediumint,
        TripId mediumint,
        PRIMARY KEY (ID),
        FOREIGN KEY (TripId) REFERENCES TRIP(ID),
        FOREIGN KEY (DocTypeId) REFERENCES DOCUMENT_TYPE(ID)
    );
    
    CREATE TABLE COMPANY (
		ID mediumint NOT NULL AUTO_INCREMENT,
        CompanyName VARCHAR(255) NOT NULL,
        PRIMARY KEY (ID)
    );
    
        CREATE TABLE COMPANY_USER (
		ID mediumint NOT NULL AUTO_INCREMENT,
        UserId mediumint,
        CompanyId mediumint,
        StartDate datetime,
        EndDate datetime,
        PRIMARY KEY (ID),
        FOREIGN KEY (UserId) REFERENCES USER(ID),
        FOREIGN KEY (CompanyId) REFERENCES COMPANY(ID)
    );
    
    
    INSERT INTO `user_type` (`ID`, `UserTypeName`) 
    VALUES (0, 'Company User'), (1, 'Driver');
