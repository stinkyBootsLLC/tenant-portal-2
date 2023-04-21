-- 12/27/2018
-- Eduardo Estrada
-- Tenant Portal Application
-- NEW 12/28/2021 -> SQLite Version

CREATE TABLE Apartments ( 
    Apartment_ID INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    Apt_street NVARCHAR(25),
    Apt_number NVARCHAR(4),
    Apt_City NVARCHAR(30),
    Apt_State NVARCHAR(2),
    Apt_Zip INTEGER(5),
    Apt_Mnth_Rent INTEGER(5,2)
); 
CREATE TABLE Tenants (
    Tenant_ID INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    TenantEmail NVARCHAR(30) NOT NULL,
    TenantPassword NVARCHAR(55) NOT NULL,
    TenantFirstName NVARCHAR(30) NOT NULL,
    TenantLastName  NVARCHAR(30) NOT NULL,
    TenantHomeNumber NVARCHAR(12),
    TenantMobileNumber NVARCHAR(12),
    TenantWorkNumber NVARCHAR(12),
    TenantAddress_FK INTEGER(3),
    TenantCity_FK INTEGER(3),
    TenantState_FK INTEGER(3),
    TenantZip_FK INTEGER(3),
    TenantAptNum_FK INTEGER(3),
    FOREIGN KEY (TenantAddress_FK) REFERENCES Apartments(Apartment_ID),
	FOREIGN KEY (TenantCity_FK) REFERENCES Apartments(Apartment_ID),
	FOREIGN KEY (TenantState_FK) REFERENCES Apartments(Apartment_ID),
    FOREIGN KEY (TenantZip_FK) REFERENCES Apartments(Apartment_ID),
	FOREIGN KEY (TenantAptNum_FK) REFERENCES Apartments(Apartment_ID)
);
CREATE TABLE TenantSecQuestions (
	secQues_ID INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	secquest NVARCHAR(100) NOT NULL
);
CREATE TABLE TenantMaintIssues (
    TenantMaintIssue_ID INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    IssueReportDate NVARCHAR(50) NOT NULL,
    IssuePriority NVARCHAR(10),
    IssueStatus NVARCHAR (10),
    IssueDescription NVARCHAR (100) NOT NULL,
    IssueSolution NVARCHAR(100),
    IssueRepairDate NVARCHAR(50),
    ScheduledDate NVARCHAR(50),
    IssueRepairPrice INTEGER(5,2),
    Tenant_FK INTEGER(3),
    Tenant_Apt_FK INTEGER(3),
    FOREIGN KEY (Tenant_FK) REFERENCES Tenants(Tenant_ID),
	FOREIGN KEY (Tenant_Apt_FK) REFERENCES Tenants(Tenant_ID)
);
CREATE TABLE TenantProfiles(
    TenantProfile_ID INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    Tenant_FK INTEGER(3) NOT NULL,
    TenantSecQues1_FK INTEGER(3) NOT NULL,
    TenantSecAns1 NVARCHAR(55) NOT NULL,
    TenantSecQues2_FK INTEGER(3) NOT NULL,
    TenantSecAns2 NVARCHAR(55) NOT NULL,
    TenantSecQues3_FK INTEGER(3) NOT NULL,
    TenantSecAns3 NVARCHAR(55) NOT NULL,
    FOREIGN KEY (Tenant_FK) REFERENCES Tenants(Tenant_ID),
	FOREIGN KEY (TenantSecQues1_FK) REFERENCES TenantSecQuestions(secQues_ID ),
	FOREIGN KEY (TenantSecQues2_FK) REFERENCES TenantSecQuestions(secQues_ID ),
    FOREIGN KEY (TenantSecQues3_FK) REFERENCES TenantSecQuestions(secQues_ID )
);
CREATE TABLE Maintainers (
    Maintainer_ID INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    MaintainerEmail NVARCHAR(30) NOT NULL,
    MaintainertPassword NVARCHAR(55) NOT NULL,
    MaintainerFirstName NVARCHAR(30) NOT NULL,
    MaintainerLastName  NVARCHAR(30) NOT NULL,
    MaintainerNumber NVARCHAR(12)
);
CREATE TABLE MaintainerProfiles(
    MaintainerProfile_ID INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
    Maintainer_FK INTEGER(3) NOT NULL,
    MaintainerSecQues1_FK INTEGER(3) NOT NULL,
    MaintainerSecAns1 NVARCHAR(55) NOT NULL,
    MaintainerSecQues2_FK INTEGER(3) NOT NULL,
    MaintainerSecAns2 NVARCHAR(55) NOT NULL,
    MaintainerSecQues3_FK INTEGER(3) NOT NULL,
    MaintainerSecAns3 NVARCHAR(55) NOT NULL,
    FOREIGN KEY (Maintainer_FK) REFERENCES Maintainers(Maintainer_ID),
	FOREIGN KEY (MaintainerSecQues1_FK) REFERENCES TenantSecQuestions(secQues_ID ),
	FOREIGN KEY (MaintainerSecQues2_FK) REFERENCES TenantSecQuestions(secQues_ID ),
    FOREIGN KEY (MaintainerSecQues3_FK) REFERENCES TenantSecQuestions(secQues_ID )
);

-- populate apartments tables
INSERT INTO Apartments (Apt_number,Apt_City,Apt_State,Apt_Zip,Apt_Mnth_Rent)
VALUES ('T123', 'Emmaus', 'PA',18099, 123.12);
INSERT INTO Apartments (Apt_number,Apt_City,Apt_State,Apt_Zip,Apt_Mnth_Rent)
VALUES ('T124', 'Lilitz', 'PA',18099, 555.12);
INSERT INTO Apartments (Apt_number,Apt_City,Apt_State,Apt_Zip,Apt_Mnth_Rent)
VALUES ('T125', 'Allentown', 'PA',18099, 666.12);
INSERT INTO Apartments (Apt_number,Apt_City,Apt_State,Apt_Zip,Apt_Mnth_Rent)
VALUES ('T126', 'Tobyhanna', 'PA',18099, 777.12);
INSERT INTO Apartments (Apt_number,Apt_City,Apt_State,Apt_Zip,Apt_Mnth_Rent)
VALUES ('T127', 'QuakerTown', 'PA',18099, 888.12);
INSERT INTO Apartments (Apt_number,Apt_City,Apt_State,Apt_Zip,Apt_Mnth_Rent)
VALUES ('T128', 'Pillow', 'PA',18099, 999.12);

-- populate tenants table
-- password = 1234
INSERT INTO Tenants (TenantEmail, TenantPassword, TenantFirstName,TenantLastName,TenantHomeNumber,TenantMobileNumber,TenantWorkNumber,
                                TenantAddress_FK,TenantCity_FK,TenantState_FK,TenantZip_FK,TenantAptNum_FK)
VALUES ('tenant@mail.com','03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4','ed','smith','123-456-7891','123-456-7891','123-456-7891',1,1,1,1,1);

INSERT INTO Tenants (TenantEmail, TenantPassword, TenantFirstName,TenantLastName,TenantHomeNumber,TenantMobileNumber,TenantWorkNumber,
                                TenantAddress_FK,TenantCity_FK,TenantState_FK,TenantZip_FK,TenantAptNum_FK)
VALUES ('tenant2@mail.com','03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4','Fran','smith','123-456-7891','123-456-7891','123-456-7891',1,1,1,1,1);

INSERT INTO Tenants (TenantEmail, TenantPassword, TenantFirstName,TenantLastName,TenantHomeNumber,TenantMobileNumber,TenantWorkNumber,
                                TenantAddress_FK,TenantCity_FK,TenantState_FK,TenantZip_FK,TenantAptNum_FK)
VALUES ('john@mail.com','03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4','john','doe','123-456-7891','123-456-7891','123-456-7891',2,2,2,2,2);

-- populate TenantSecQuestions table
INSERT INTO TenantSecQuestions (secquest)VALUES ('In what city were you born');
INSERT INTO TenantSecQuestions (secquest)VALUES ('What high school did you attend');
INSERT INTO TenantSecQuestions (secquest)VALUES ('What is the name of your first school');
INSERT INTO TenantSecQuestions (secquest)VALUES ('What is your favorite movie');
INSERT INTO TenantSecQuestions (secquest)VALUES ('What is your mothers maiden name');
INSERT INTO TenantSecQuestions (secquest)VALUES ('What street did you grow up on');
INSERT INTO TenantSecQuestions (secquest)VALUES ('What was the make of your first car');
INSERT INTO TenantSecQuestions (secquest)VALUES ('When is your anniversary');
INSERT INTO TenantSecQuestions (secquest)VALUES ('What is your favorite color');
INSERT INTO TenantSecQuestions (secquest)VALUES ('What is your fathers middle name');

-- populate TenantMaintIssues table
INSERT INTO TenantMaintIssues(IssueReportDate ,IssuePriority ,IssueStatus ,IssueDescription ,
    IssueSolution ,IssueRepairDate,ScheduledDate ,IssueRepairPrice,Tenant_FK ,Tenant_Apt_FK)
VALUES ('20181205','low','pending','Burnt LightBulb', 'Replaced Bulb','20181210','20181210',002.55,1,1);
INSERT INTO TenantMaintIssues(IssueReportDate ,IssuePriority ,IssueStatus ,IssueDescription ,
    IssueSolution ,IssueRepairDate,ScheduledDate,Tenant_FK ,Tenant_Apt_FK)
VALUES ('20181205','low','pending','clogged toilet', '20181225',' ','20181231',2,2);
INSERT INTO TenantMaintIssues(IssueReportDate ,IssuePriority ,IssueStatus ,IssueDescription ,
    IssueSolution ,IssueRepairDate,ScheduledDate,Tenant_FK ,Tenant_Apt_FK)
VALUES ('20181205','High','pending','clogged toilet', '20181225',' ','20181231',1,1);
INSERT INTO TenantMaintIssues(IssueReportDate ,IssuePriority ,IssueStatus ,IssueDescription ,
    IssueSolution ,IssueRepairDate,ScheduledDate ,IssueRepairPrice,Tenant_FK ,Tenant_Apt_FK)
VALUES ('20181205','low','closed','Burnt LightBulb', 'Replaced Bulb','20181210','20181210',002.55,3,3);
INSERT INTO TenantMaintIssues(IssueReportDate ,IssuePriority ,IssueStatus ,IssueDescription ,
    IssueSolution ,IssueRepairDate,ScheduledDate ,IssueRepairPrice,Tenant_FK ,Tenant_Apt_FK)
VALUES ('20181205','low','closed','clogged toilet', 'unclogged toilet','20181210','20181210',055.55,3,3);
INSERT INTO TenantMaintIssues(IssueReportDate ,IssuePriority ,IssueStatus ,IssueDescription ,
    IssueSolution ,IssueRepairDate,ScheduledDate ,IssueRepairPrice,Tenant_FK ,Tenant_Apt_FK)
VALUES ('20181205','High','closed','no pwr in kitched', 'reset cb','20181210','20181210',000.00,3,3);
INSERT INTO TenantMaintIssues(IssueReportDate ,IssuePriority ,IssueStatus ,IssueDescription ,
    IssueSolution ,IssueRepairDate,ScheduledDate ,IssueRepairPrice,Tenant_FK ,Tenant_Apt_FK)
VALUES ('20181206','low','closed','Burnt LightBulb', 'Replaced Bulb','20181211','20181211',002.55,3,3);
-- this will be what the tenant can enter
INSERT INTO TenantMaintIssues(IssueReportDate ,IssueStatus ,IssueDescription,Tenant_FK ,Tenant_Apt_FK)
VALUES ('20181225','open','Burnt LightBulb',2,2);
INSERT INTO TenantMaintIssues(IssueReportDate ,IssueStatus ,IssueDescription,Tenant_FK ,Tenant_Apt_FK)
VALUES ('20181225','open','Burnt LightBulb',3,3);

-- populate TenantProfiles table
-- secret answers are 'answer'
INSERT INTO TenantProfiles(Tenant_FK,TenantSecQues1_FK,TenantSecAns1,TenantSecQues2_FK,TenantSecAns2,
    TenantSecQues3_FK,TenantSecAns3)
VALUES(1,4,'0db52f4076c082518412afd3dd3576e2cb0c63703fd7fed5e23ade60efef31d9',2,'0db52f4076c082518412afd3dd3576e2cb0c63703fd7fed5e23ade60efef31d9',1,'0db52f4076c082518412afd3dd3576e2cb0c63703fd7fed5e23ade60efef31d9');
INSERT INTO TenantProfiles(Tenant_FK,TenantSecQues1_FK,TenantSecAns1,TenantSecQues2_FK,TenantSecAns2,
    TenantSecQues3_FK,TenantSecAns3)
VALUES(2,1,'0db52f4076c082518412afd3dd3576e2cb0c63703fd7fed5e23ade60efef31d9',2,'0db52f4076c082518412afd3dd3576e2cb0c63703fd7fed5e23ade60efef31d9',3,'0db52f4076c082518412afd3dd3576e2cb0c63703fd7fed5e23ade60efef31d9');
INSERT INTO TenantProfiles(Tenant_FK,TenantSecQues1_FK,TenantSecAns1,TenantSecQues2_FK,TenantSecAns2,
    TenantSecQues3_FK,TenantSecAns3)
VALUES(3,6,'0db52f4076c082518412afd3dd3576e2cb0c63703fd7fed5e23ade60efef31d9',7,'0db52f4076c082518412afd3dd3576e2cb0c63703fd7fed5e23ade60efef31d9',8,'0db52f4076c082518412afd3dd3576e2cb0c63703fd7fed5e23ade60efef31d9');



-- populate Maintainers table
-- password = 1234
INSERT INTO Maintainers (MaintainerEmail,MaintainertPassword,MaintainerFirstName,MaintainerLastName,MaintainerNumber)
VALUES ('maint@mail.com','03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4','ed','jones','123-456-7891');

-- populate MaintainerProfiles table
-- secret answers are 'answer'
INSERT INTO MaintainerProfiles (Maintainer_FK,MaintainerSecQues1_FK,MaintainerSecAns1,MaintainerSecQues2_FK,
MaintainerSecAns2,MaintainerSecQues3_FK,MaintainerSecAns3)
VALUES(1,2,'0db52f4076c082518412afd3dd3576e2cb0c63703fd7fed5e23ade60efef31d9',2,'0db52f4076c082518412afd3dd3576e2cb0c63703fd7fed5e23ade60efef31d9',2,'0db52f4076c082518412afd3dd3576e2cb0c63703fd7fed5e23ade60efef31d9');



-- // how to run from command line
-- // navigate to working directory
-- // from sql file make sqlite database 
-- // use command line below
-- cat createTenants.sql | sqlite3 Tenants.sqlite