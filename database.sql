CREATE DATABASE pakistan_quiz_db;
USE pakistan_quiz_db;


CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
);


INSERT INTO admins (username, password) VALUES ('admin', 'admin123');


CREATE TABLE questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question TEXT NOT NULL,
    option_a VARCHAR(255) NOT NULL,
    option_b VARCHAR(255) NOT NULL,
    option_c VARCHAR(255) NOT NULL,
    option_d VARCHAR(255) NOT NULL,
    correct_option CHAR(1) NOT NULL
);


INSERT INTO questions (question, option_a, option_b, option_c, option_d, correct_option) VALUES
('Who is the current Prime Minister of Pakistan as of 2026?', 'Shehbaz Sharif', 'Imran Khan', 'Bilawal Bhutto', 'Nawaz Sharif', 'a'),
('Who is the current President of Pakistan?', 'Asif Ali Zardari', 'Arif Alvi', 'Mian Nawaz Sharif', 'Yousaf Raza Gillani', 'a'),
('Which country shares the longest border with Pakistan?', 'India', 'China', 'Afghanistan', 'Iran', 'c'),
('What is the total number of districts in the province of Sindh?', '29', '30', '33', '36', 'c'),
('Who is the current Chief Minister of Punjab?', 'Maryam Nawaz', 'Hamza Shehbaz', 'Pervez Elahi', 'Pervaiz Rasheed', 'a'),
('Which is the national flower of Pakistan?', 'Rose', 'Jasmine', 'Sunflower', 'Tulip', 'b'),
('Pakistan successfully tested its nuclear weapons on which date in May 1998?', 'May 25', 'May 28', 'May 30', 'May 11', 'b'),
('Which of the following is the highest civilian award in Pakistan?', 'Sitara-e-Pakistan', 'Hilal-e-Pakistan', 'Nishan-e-Pakistan', 'Tamgha-e-Shujaat', 'c'),
('The Gwadar Port is located in which province of Pakistan?', 'Sindh', 'Balochistan', 'Punjab', 'Khyber Pakhtunkhwa', 'b'),
('Who wrote the national anthem of Pakistan?', 'Allama Iqbal', 'Hafeez Jalandhari', 'Ahmed G. Chagla', 'Josh Malihabadi', 'b'),
('What is the length of the Line of Control (LoC) roughly?', '740 km', '850 km', '900 km', '650 km', 'a'),
('When did Pakistan win its first Cricket World Cup?', '1987', '1992', '1999', '2009', 'b'),
('Which mountain peak is known as the "Killer Mountain" and located in Pakistan?', 'K2', 'Nanga Parbat', 'Tirich Mir', 'Rakaposhi', 'b'),
('Which river is known as the lifeline of Pakistan?', 'Sutlej River', 'Chenab River', 'Indus River', 'Ravi River', 'c'),
('Who was the first Governor-General of Pakistan?', 'Liaquat Ali Khan', 'Allama Iqbal', 'Quaid-e-Azam Muhammad Ali Jinnah', 'Chaudhry Khaliquzzaman', 'c');


CREATE TABLE results (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_name VARCHAR(100) NOT NULL,
    student_id VARCHAR(50) unique key,
    score INT NOT NULL,
    total_questions INT NOT NULL,
    exam_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
drop table admins ;
drop table results ;
