/*drop table tCellPhoneCarrier;
drop table tUser;
drop table tCategory;
drop table tTicket;
drop table tStatus;
drop table tTicketNote;
drop table tTicketAttachment;
drop table tType;
drop table tLogin;
*/

CREATE TABLE tCellPhoneCarrier(
CellPhoneCarrierID INT AUTO_INCREMENT,
CellPhoneCarrierName VARCHAR(25) NOT NULL,
CellPhoneCarrierEmailDom VARCHAR(25) NOT NULL,
PRIMARY KEY (CellPhoneCarrierID)
);

CREATE TABLE tUser(
UserID INT AUTO_INCREMENT,
FirstName VARCHAR(25) NOT NULL,
LastName VARCHAR(25) NOT NULL,
EmailAddress VARCHAR(50) NOT NULL,
PhoneNumber VARCHAR(10),
CellPhoneCarrierID INTEGER,
PRIMARY KEY (UserID),
FOREIGN KEY (CellPhoneCarrierID) REFERENCES tCellPhoneCarrier(CellPhoneCarrierID)
);

CREATE TABLE tCategory(
CategoryID INT AUTO_INCREMENT,
`Description` VARCHAR(10),
PRIMARY KEY (CategoryID)
);

CREATE TABLE tTicket (
TicketID INT AUTO_INCREMENT,
CategoryID INT NOT NULL,
OpenedBy INT NOT NULL,
DateOpened TIMESTAMP NOT NULL,
IssueTitle VARCHAR(50) NOT NULL,
Description TEXT,
PRIMARY KEY (TicketID),
FOREIGN KEY (CategoryID) REFERENCES tCategory(CategoryID),
FOREIGN KEY (OpenedBy) REFERENCES tUser(UserID)
);

CREATE TABLE tStatus(
StatusID INT AUTO_INCREMENT,
`Description` VARCHAR(50) NOT NULL,
PRIMARY KEY (StatusID)
);

CREATE TABLE tTicketNote(
TicketNoteID INT AUTO_INCREMENT,
TicketID INT NOT NULL,
UserID INT NOT NULL,
StatusID INT NOT NULL,
NoteDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
NoteText TEXT,
PRIMARY KEY (TicketNoteID),
FOREIGN KEY (TicketID) REFERENCES tTicket(TicketID),
FOREIGN KEY (StatusID) REFERENCES tStatus(StatusID)
);

CREATE TABLE tTicketAttachment(
TicketAttachmentID INT AUTO_INCREMENT,
TicketID INT NOT NULL,
UserID INT NOT NULL,
AttachmentURL VARCHAR(500),
PRIMARY KEY (TicketAttachmentID),
FOREIGN KEY (TicketID) REFERENCES tTicket(TicketID),
FOREIGN KEY (UserID) REFERENCES tUser(UserID)
);

CREATE TABLE tType(
TypeID INT AUTO_INCREMENT,
TypeName VARCHAR(10) NOT NULL,
`Description` VARCHAR(50),
PRIMARY KEY (TypeID)
);

CREATE TABLE tLogin(
UserID INT,
TypeID INT,
Passwd VARCHAR(10) NOT NULL,
LastPasswordChange TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (UserID, TypeID),
FOREIGN KEY (UserID) REFERENCES tUser(UserID),
FOREIGN KEY (TypeID) REFERENCES tType(TypeID)
)