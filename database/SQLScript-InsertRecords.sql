INSERT INTO tCellPhoneCarrier (CellPhoneCarrierName, CellPhoneCarrierEmailDom)
VALUES
('AT&T', 'txt.att.net'),
('BOOST','myboostmobile.com'),
('METROPCS','mymetropcs.com'),
('NEXTEL','messaging.nextel.com'),
('SPRINT','messaging.sprintpcs.com'),
('TMOBILE','tmomail.net'),
('VIRGIN','vmobl.com'),
('VERIZON','vzwpix.com'); -- vtext limits text to 140 characters; vzwpix.com does not have this limitation.


INSERT INTO tUser (FirstName, LastName, EmailAddress, PhoneNumber,CellPhoneCarrierID)
VALUES 
('Cici','Carter','cici.carter@gmail.com','4048223909',6),
('Nick','Pickering','2NickPick@gmail.com',null,null),
('Ima','User','test@test.com',null,null);


INSERT INTO tCategory (Description)
VALUES
('Web'), ('Desktop');


INSERT INTO tStatus (Description)
VALUES
('OPEN'),('IN PROGRESS'),('RESOLVED'),('RE-OPENED'),('CLOSED');


INSERT INTO tType(TypeName, Description)
VALUES
('SUBSCRIBER','Regular user with minimal privileges'),
('STAFF','User with elevated privileges'),
('ADMIN','User with highest level of privileges');


INSERT INTO tLogin (UserID, TypeID, Passwd)
VALUES
(1, 3, 'MyTest1234'),
(2, 3, 'MyTest1234'),
(3, 1, 'MyTest1234');


INSERT INTO tTicket (CategoryID, OpenedBy, IssueTitle, Description)
VALUES
(1, 3, 'Unable to get into web application', 'When I try to log on to the web app, I get the error <quote>Error occurred while processing your request.</quote>. Please see attachments.');


INSERT INTO tTicketAttachment (TicketID, UserID, AttachmentURL)
VALUES
(1, 3, 'https://acomdpsstorage.blob.core.windows.net/dpsmedia-prod/azure.microsoft.com/en-us/documentation/articles/web-sites-dotnet-troubleshoot-visual-studio/20150928044904/genericerror1.png');


INSERT INTO tTicketNote (TicketID, UserID, StatusID, NoteText)
VALUES
(1, 3, 1, 'New ticket created.'),
(1, 3, 2, 'New attachment added.'),
(1, 1, 2, 'This appears to be the only user affected. Troubleshooting further.'),
(1, 2, 2, 'User called the help desk asking for a status on this ticket. Checking with previous technician.'),
(1, 1, 3, 'Modified host file, which fixed this problem.'),
(1, 3, 5, 'Resolution confirmed by user. Ticket closed.');