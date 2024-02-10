
INSERT INTO Users (firstname, surname) VALUES
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

-- Create a temporary table to hold numbers from 1 to 100
CREATE TEMPORARY TABLE Numbers (Number INT);
INSERT INTO Numbers (Number)
SELECT Number
FROM (
    SELECT 1 AS Number
    UNION ALL
    SELECT Number + 1 FROM Numbers WHERE Number < 100
) AS t; -- Adding alias 't' here

-- Insert random enrolment data
INSERT INTO Enrolments (userID, courseID, status)
SELECT 
    FLOOR(RAND() * (max_user_id - min_user_id + 1)) + min_user_id AS userID,
    FLOOR(RAND() * (max_course_id - min_course_id + 1)) + min_course_id AS courseID,
    CASE (FLOOR(RAND() * 3))
        WHEN 0 THEN 'not started'
        WHEN 1 THEN 'in progress'
        ELSE 'completed'
    END AS status
FROM 
    (SELECT MIN(ID) AS min_user_id, MAX(ID) AS max_user_id FROM Users) AS u,
    (SELECT MIN(ID) AS min_course_id, MAX(ID) AS max_course_id FROM Courses) AS c,
    Numbers CROSS JOIN users CROSS JOIN courses;

-- Drop the temporary numbers table
DROP TEMPORARY TABLE Numbers;