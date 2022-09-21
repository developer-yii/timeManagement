ALTER TABLE `students` CHANGE `grade_level` `grade_level` VARCHAR(30) NULL DEFAULT NULL;
ALTER TABLE `student_time_log` CHANGE `log_time` `log_time` VARCHAR(11) NOT NULL;
#21-09-2022
ALTER TABLE `students` CHANGE `last_name` `last_name` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL;
ALTER TABLE `users` CHANGE `user_type` `user_type` TINYINT(4) NOT NULL DEFAULT '2' COMMENT '1=admin,2=parent,3=teacher,4=affiliate';