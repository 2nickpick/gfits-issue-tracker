SELECT 
u.UserID, u.FirstName, u.LastName, u.EmailAddress,
l.Passwd, l.LastPasswordChange,	tp.TypeID, tp.TypeName, tp.Description as TypeDescription,
tk.TicketID, tk.DateOpened, c.Description as CategoryDescription, 
ta.AttachmentURL as TicketAttachmentURL
FROM
tUser u
JOIN tLogin l on u.UserID=l.UserID
JOIN tType tp on l.TypeID=tp.TypeID
JOIN tTicket tk on u.UserID=tk.OpenedBy
JOIN tCategory c on tk.CategoryID=c.CategoryID
JOIN tTicketAttachment ta on tk.TicketID=ta.TicketID and u.UserID=ta.UserID;

SELECT u.UserID, u.FirstName, u.LastName, u.EmailAddress, u.PhoneNumber, 
CONCAT(u.PhoneNumber,'@',IFNULL(c.CellPhoneCarrierEmailDom,'')) AS TextAddress, 
tn.TicketID, s.StatusID, s.Description AS StatusDescription, tn.TicketNoteID, tn.NoteDate, tn.NoteText
FROM tUser u
LEFT JOIN tCellPhoneCarrier c ON u.CellPhoneCarrierID = c.CellPhoneCarrierID
JOIN tTicketNote tn ON u.UserID = tn.UserID
JOIN tStatus s ON tn.StatusID = s.StatusID
ORDER BY tn.TicketNoteID;