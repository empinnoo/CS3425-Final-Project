/******* Admin Functions *******/
/* Insert an instructor */
delimiter //
create procedure insertInstructor(i_name char(64), i_password char(64))
    begin
    insert into instructor values(i_name, sha2(i_password, 256), 0);
    end //
delimiter ;

/* Insert a student */
delimiter //
create procedure insertStudent(s_name char(64), s_password char(64))
    begin
    insert into student values(s_name, sha2(s_password, 256), 0);
    end //
delimiter ;
 
/* Insert a course */
delimiter //
create procedure insertCourse(c_id char(64), c_title char(64), c_credit numeric(2, 1))
    begin
    insert into course values(c_id, c_title, c_credit);
    end //
delimiter ;
 
 /* Assign instructor to a course */
delimiter //
create procedure assignInstructor(i_name char(64), c_id char(64))
    begin
    insert into teaches values(i_name, c_id);
    end //
delimiter ;
 
 /* Create questions */
delimiter //
create procedure createQuestion(q_id int unsigned, q_txt char(255), q_type char(32))
    begin
    insert into survey values(q_id, q_txt, q_type);
    end //
delimiter ;

/* Create multiple choice choices */
delimiter //
create procedure createMultChoice(q_id int unsigned, choice char(64))
    begin
    insert into mult_choice values(q_id, choice);
    end //
delimiter ;

