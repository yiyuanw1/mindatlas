CREATE TABLE IF NOT EXISTS `Users` (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    firstname varchar(255),
    surname varchar(255)
);

CREATE TABLE IF NOT EXISTS `Courses` (
    ID int AUTO_INCREMENT PRIMARY KEY,
    title varchar(255),
    description text
);

CREATE TABLE IF NOT EXISTS `Enrolments` (
    ID int AUTO_INCREMENT PRIMARY KEY,
    userID int,
    courseID int,
    status varchar(15),
    FOREIGN KEY (userID) REFERENCES `Users`(ID),
    FOREIGN KEY (courseID) REFERENCES `Courses`(ID)
);
