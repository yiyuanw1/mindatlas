CREATE TABLE `User` (
    ID int AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR(255)
);

CREATE TABLE `UserFieldName` (
    ID int AUTO_INCREMENT PRIMARY KEY,
    Field VARCHAR(255)
);

CREATE TABLE `UserData` (
    ID int AUTO_INCREMENT PRIMARY KEY,
    FieldID int,
    Data text,
    UserID int,
    FOREIGN KEY (FieldID) REFERENCES `UserFieldName`(ID),
    FOREIGN KEY (UserID) REFERENCES `User`(ID)
);

INSERT INTO `User` (Username) VALUES 
('User1'), 
('User2'),
('User3');

INSERT INTO `UserFieldName` (Field) VALUES
('Phone'),
('Email'),
('Position');

INSERT INTO `UserData` (FieldID, Data, UserID) VALUES 
(1, '1111111', 1),
(2, 'User1@gmail.com', 1),
(1, '2222222', 2),
(2, 'User2@gmail.com', 2),
(1, '3333333', 3),
(2, 'User3@gmail.com', 3),
(3, 'Tester', 3);