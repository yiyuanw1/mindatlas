CREATE TABLE IF NOT EXISTS `Users` (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    firstname varchar(255),
    lastname varchar(255)
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

INSERT INTO Users (firstname, lastname) VALUES
('John', 'Doe'),
('Jane', 'Smith'),
('Michael', 'Johnson'),
('Emily', 'Brown'),
('David', 'Williams'),
('Sarah', 'Jones'),
('Christopher', 'Davis'),
('Amanda', 'Martinez'),
('Matthew', 'Garcia'),
('Jessica', 'Rodriguez'),
('James', 'Miller'),
('Ashley', 'Wilson'),
('Robert', 'Taylor'),
('Jennifer', 'Anderson'),
('Daniel', 'Thomas'),
('Linda', 'Moore'),
('William', 'Jackson'),
('Michelle', 'White'),
('Charles', 'Harris'),
('Karen', 'Clark');

INSERT INTO Courses (title, description) VALUES
('Introduction to Programming', 'This course covers the fundamentals of programming, including variables, loops, and functions.'),
('Web Development Basics', 'Learn the basics of web development, including HTML, CSS, and JavaScript.'),
('Data Science Essentials', 'Explore essential concepts and techniques in data science, such as data cleaning, analysis, and visualization.'),
('Machine Learning Fundamentals', 'This course provides an introduction to machine learning algorithms and techniques.'),
('Artificial Intelligence Applications', 'Discover practical applications of artificial intelligence in various domains, including healthcare, finance, and robotics.'),
('Cybersecurity Fundamentals', 'Learn about cybersecurity principles, threats, and defense mechanisms.'),
('Digital Marketing Strategies', 'Explore effective digital marketing strategies for reaching and engaging target audiences online.'),
('Project Management Essentials', 'This course covers essential project management concepts and techniques for successfully managing projects.'),
('Business Analytics Fundamentals', 'Explore key concepts and techniques in business analytics, such as data mining, forecasting, and optimization.'),
('Finance for Non-Financial Managers', 'Gain an understanding of finance essentials for non-financial managers, including budgeting, financial statements, and investment decisions.'),
('Leadership Skills Development', 'Develop essential leadership skills for effectively leading teams and driving organizational success.'),
('Communication Strategies', 'Learn effective communication strategies for enhancing interpersonal and professional relationships.'),
('Creative Problem Solving', 'Explore creative problem-solving techniques for generating innovative solutions to complex challenges.'),
('Time Management Techniques', 'Discover time management strategies and techniques for improving productivity and achieving goals.'),
('Emotional Intelligence in the Workplace', 'This course focuses on developing emotional intelligence skills for better interpersonal relationships and workplace success.'),
('Stress Management Strategies', 'Learn practical strategies for managing stress and promoting well-being in both personal and professional life.'),
('Mindfulness Meditation Practices', 'Explore mindfulness meditation practices for cultivating focus, awareness, and resilience.'),
('Healthy Lifestyle Habits', 'Discover tips and strategies for adopting and maintaining a healthy lifestyle, including nutrition, exercise, and stress management.'),
('Effective Presentation Skills', 'Develop effective presentation skills for delivering engaging and persuasive presentations in various settings.'),
('Career Development Strategies', 'This course provides practical strategies and resources for advancing your career and achieving professional goals.');


WITH RECURSIVE Numbers AS (
    SELECT 1 AS Number
    UNION ALL
    SELECT Number + 1 FROM Numbers WHERE Number < 100
)
INSERT INTO Enrolments (userID, courseID, status)
SELECT 
    (FLOOR(RAND() * (SELECT MAX(ID) FROM Users) + 1)) AS userID,
    (FLOOR(RAND() * (SELECT MAX(ID) FROM Courses) + 1)) AS courseID,
    CASE FLOOR(RAND() * 3)
        WHEN 0 THEN 'not started'
        WHEN 1 THEN 'in progress'
        ELSE 'completed'
    END AS status
FROM 
    Numbers;
