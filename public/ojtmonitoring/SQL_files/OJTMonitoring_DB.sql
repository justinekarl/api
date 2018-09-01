
DROP DATABASE IF EXISTS ojtmonitoring;
CREATE DATABASE IF NOT EXISTS ojtmonitoring;

USE ojtmonitoring;




CREATE TABLE user(id int not null auto_increment,
				  name text,
				  address text,
				  phonenumber text,
				  studentnumber text,
				  teachernumber text,
				  email text,
				  department text,
				  college text,
				  username text,
				  password text,
				  accounttype int,
				  log_date_created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
				  primary key(id)
				 );

ALTER TABLE user ADD COLUMN approved boolean default false;
ALTER TABLE user ADD COLUMN approved_by_teacher_id int,
                 ADD COLUMN approved_date date;

CREATE TABLE company_profile(id int not null auto_increment,
							 user_id int,
							 description text,
							 moa_certified boolean default false,
							 does_provide_allowance boolean default false,
							 allowance double precision,
							 ojt_number int,
							 college text,
							 log_date_created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
							 primary key(id)
							);


CREATE TABLE resume_details(id int not null auto_increment,
			   user_id int,
			   accomplishments text,
			   interests text,
			   approved boolean default false,
			   ojt_hours_needed double precision,	   
			   updated_by_teacher_id int,
			   teacher_notes text,
			   company_accepted boolean default false,
			   log_date_created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
			   primary key(id)
);




CREATE TABLE work_experience(id int not null auto_increment,
			     resume_details_id int,
			     company_name text,
			     address text,
			     job_description text,
			     duties_responsibilities text,
			     log_date_created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
			    primary key(id) 
			   );


CREATE TABLE educational_background(id int not null auto_increment,
				    resume_details_id int,
				    type int, 
				    name text,
				    address text,
				    from_date date,
				    to_date date,
				    log_date_created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
				   primary key(id)
				   );

CREATE TABLE resume_references(id int not null auto_increment,
		     resume_details_id int,
		     name text,
		     address text,
		     phone_number text,
		     occupation text,
		     log_date_created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
		     primary key(id)
		     );



CREATE TABLE student_company_selected(id int not null auto_increment,
									  user_id int,
									  company_id int,
									  log_date_created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
									  primary key(id)
									 );

CREATE TABLE company_ojt(id int not null auto_increment,
						user_id int,
						company_id int,
						approved_by_teacher_id int,
						log_date_created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
						primary key(id)
						);

ALTER TABLE company_ojt ADD COLUMN accepted boolean default false,
						ADD COLUMN accepted_by_company_id int;

ALTER TABLE company_ojt ADD COLUMN accepted_date date;

CREATE TABLE student_notif(id int not null auto_increment,
						   user_id int,
						   message text,
						   deleted boolean default false,
						   deleted_date date,
						   log_date_created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
						   primary key(id)
);


CREATE TABLE student_ojt_attendance_log(id int not null auto_increment,
										student_id int,
										company_id int,
										login_date text,
										logout_date text,
										scan_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
										login boolean default false,
										primary key(id)
										);


CREATE TABLE section(id int not null auto_increment,
		     company_id int,
		     no_of_students int,
		     section_name text,
		     created_by_teacher_id int, 
		     log_date_created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
		     primary key(id)
	            );

ALTER TABLE user ADD COLUMN section_id int;
ALTER TABLE user ADD COLUMN section text;

ALTER TABLE user ADD COLUMN company_name text;
ALTER TABLE user ADD COLUMN company_id int;

ALTER TABLE student_ojt_attendance_log ADD COLUMN agent_id int;
ALTER TABLE student_ojt_attendance_log ADD COLUMN finger_print_scanner BOOLEAN DEFAULT FALSE;


ALTER TABLE user ADD COLUMN rating int default 1;

CREATE TABLE student_company_rating(id int not null auto_increment,
                                    company_id int,
                                    student_id int,
                                    log_date_created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                    rating int,
                                    primary key(id)
                                   );


ALTER TABLE user ADD COLUMN gender text;
ALTER TABLE user ADD COLUMN ojt_hours int;

CREATE TABLE course_look_up(id int not null auto_increment,
                            name text,
                            primary key(id)
                            );


CREATE TABLE company_course_to_accept(id int not null auto_increment,
                                      course_id int,
                                      name text,
                                      company_id int,
                                      primary key(id)
                                     );


INSERT INTO course_look_up(name)
SELECT 'Education'
UNION
SELECT 'ECE'
UNION
SELECT 'Com Eng'
UNION
SELECT 'Computer Science'
UNION
SELECT 'Business Ad'
UNION
SELECT 'Public Ad'
;

ALTER TABLE user ADD COLUMN course text;
ALTER TABLE user ADD COLUMN ojt_done boolean default false;


ALTER TABLE course_look_up ADD COLUMN college text;


DELETE FROM course_look_up;

INSERT INTO course_look_up(college,name)
SELECT 'College of Computing and information Sciences','Master in information technology(MIT)'
UNION
SELECT 'College of Computing and information Sciences','Bachelor of Science in Computer Science(BSCS)'
UNION
SELECT 'College of Computing and information Sciences','Bachelor of Science In Information Technology(BSIT)'


UNION
SELECT 'College of Arts And Social Sciences','Bachelor of Arts In Communication'
UNION
SELECT 'College of Arts And Social Sciences','Bachelor of Artis in Political Science'
UNION
SELECT 'College of Arts And Social Sciences','Bachelor of Science in Social Work'

UNION
SELECT 'College of Hospitality Management','BS in Hotel and Restaurant Management'
UNION
SELECT 'College of Hospitality Management','Bs in tourism'


UNION
SELECT 'College of Criminology','Bs in Criminology'

UNION

SELECT 'College Of Education','Bachelor of Elementary Education'
UNION
SELECT 'College Of Education','Bachelor of Secondary Education'

UNION

SELECT 'College of Nursing','Bs of Science in Nursing'

UNION
SELECT 'College Of Engineering','Bs in Computer Engineering'
UNION
SELECT 'College Of Engineering','Bs in Electronics Engineering'


UNION
SELECT 'College of Business','Bachelor of Science in Accountancy (BSA)'
UNION
SELECT 'College of Business','Bachelor of Science in Accounting Technology (BSAT)'
UNION
SELECT 'College of Business','Bachelor of Science in Business Administration (BSBA)'
UNION
SELECT 'College of Business','Bachelor of Science in Customs Administration (BSCA)'
UNION
SELECT 'College of Business','Bachelor of Science in Real Estate Management (BSREM)'


;


ALTER TABLE student_company_rating ADD COLUMN remarks TEXT;

CREATE TABLE company_student_rating(id int not null auto_increment,
                                    company_id int,
                                    student_id int,
                                    log_date_created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                    rating int,
                                    remarks TEXT,
                                    primary key(id));


--**********************2017-07-31*******************************************

ALTER TABLE user ADD COLUMN section_approved BOOLEAN DEFAULT false;
ALTER TABLE user ADD COLUMN section_approved_date date;


--**********************************

CREATE TABLE messages(id int not null auto_increment,
					 sender_id int,
					 recipient_id int,
					 message_timestamp TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
					 message text,
					 sender_type int,
					 primary key(id)
					);


ALTER TABLE chat_messages ADD COLUMN read BOOLEAN DEFAULT FALSE;
