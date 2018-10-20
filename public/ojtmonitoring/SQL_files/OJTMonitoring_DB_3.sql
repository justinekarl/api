DELETE FROM chat_messages;
ALTER TABLE chat_messages AUTO_INCREMENT = 1;
DELETE FROM company_course_to_accept;
ALTER TABLE company_course_to_accept AUTO_INCREMENT = 1;
DELETE FROM company_ojt;
ALTER TABLE company_ojt AUTO_INCREMENT = 1;
DELETE FROM company_profile;
ALTER TABLE company_profile AUTO_INCREMENT = 1;
DELETE FROM company_student_rating;
ALTER TABLE company_student_rating AUTO_INCREMENT = 1;
DELETE FROM educational_background ;
ALTER TABLE educational_background AUTO_INCREMENT = 1;
DELETE FROM messages;
ALTER TABLE messages AUTO_INCREMENT = 1;
DELETE FROM resume_details;
ALTER TABLE resume_details AUTO_INCREMENT = 1;
DELETE FROM resume_references;
ALTER TABLE resume_references AUTO_INCREMENT = 1;
DELETE FROM section;
ALTER TABLE section AUTO_INCREMENT = 1;
DELETE FROM student_company_rating;
ALTER TABLE student_company_rating AUTO_INCREMENT = 1;
DELETE FROM student_company_selected;
ALTER TABLE student_company_selected AUTO_INCREMENT = 1;
DELETE FROM student_notif;
ALTER TABLE student_notif AUTO_INCREMENT = 1;
DELETE FROM student_ojt_attendance_log;
ALTER TABLE student_ojt_attendance_log AUTO_INCREMENT = 1;
DELETE FROM student_weekly_practicum;
ALTER TABLE student_weekly_practicum AUTO_INCREMENT = 1;
DELETE FROM student_weekly_practicum_task;
ALTER TABLE student_weekly_practicum_task AUTO_INCREMENT = 1;
DELETE FROM user WHERE accounttype != 0;
ALTER TABLE user AUTO_INCREMENT = 1;
DELETE FROM work_experience;
ALTER TABLE work_experience AUTO_INCREMENT = 1;

UPDATE user SET id = 1 WHERE accounttype = 0;
ALTER TABLE user AUTO_INCREMENT = 1;

CREATE TABLE resumes (resume_id int not null auto_increment,
									  student_id int,
									  path text,
									  primary key(resume_id)
									 );

