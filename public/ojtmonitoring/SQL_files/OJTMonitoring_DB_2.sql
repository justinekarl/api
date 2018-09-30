ALTER TABLE user ADD COLUMN admin_account BOOLEAN DEFAULT FALSE;
ALTER TABLE user ADD COLUMN updated_by_admin BOOLEAN DEFAULT FALSE;
ALTER TABLE user ADD COLUMN updated_by_admin_date date;



INSERT INTO user(name,address,phonenumber,email,username,password,approved,admin_account,accounttype)
SELECT 'Administrator Account','Admin Address','111111111','admin@email.com','admin','54321',true,true,0;

ALTER TABLE student_ojt_attendance_log ADD COLUMN is_read BOOLEAN DEFAULT FALSE;