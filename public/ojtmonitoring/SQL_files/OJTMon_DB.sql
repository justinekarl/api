CREATE TABLE transaction_log(id int not null auto_increment,
							 action text,
							 student_id int,
							 teacher_id int,
							 company_id int,
							 supervisor_id int,
							 saved_by_id int,
							 log_date_created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
							 primary key(id)
							);

ALTER TABLE transaction_log ADD COLUMN is_read BOOLEAN DEFAULT FALSE;
ALTER TABLE transaction_log ADD COLUMN user_id int;
ALTER TABLE transaction_log ADD COLUMN admin_id int;