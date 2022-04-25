/******* Table creation *******/
create table student (
    stu_name char(64) primary key,
    stu_password char(64) not null,
    first_login boolean not null
);
 
create table instructor (
    inst_name char(64) primary key,
    inst_password char(64) not null,
    first_login boolean not null
);
 
create table course (
    course_id char(64) primary key,
    title char(64) not null,
    credit numeric(2, 1) not null
);
 
create table survey (
    question_id int unsigned not null auto_increment,
    q_text char(255) not null,
    q_type char(32) not null,
    primary key (question_id)
);
 
create table mult_choice (
	question_id int unsigned not null auto_increment,
	choice char(64) not null,
	foreign key (question_id) references survey(question_id)
);
 
create table takes (
    stu_name char(64) not null,
    course_id char(64) not null,
	complete boolean not null,
    primary key (stu_name, course_id),
    FOREIGN KEY (stu_name) REFERENCES student(stu_name),
    FOREIGN KEY (course_id) REFERENCES course(course_id)
);
 
create table results (
    question_id int unsigned not null auto_increment,
    stu_name char(64) not null,
    course_id char(64) not null,
    date date,
    time time,
    a_text char(255) not null,
    primary key (question_id, stu_name, course_id),
    FOREIGN KEY (question_id) REFERENCES survey(question_id),
	FOREIGN KEY (stu_name) REFERENCES student(stu_name),
    FOREIGN KEY (course_id) REFERENCES course(course_id)
);
 
create table teaches (
    inst_name char(64) not null,
    course_id char(64) not null,
    primary key (inst_name, course_id),
    FOREIGN KEY (inst_name) REFERENCES instructor(inst_name),
    FOREIGN KEY (course_id) REFERENCES course(course_id)
);
