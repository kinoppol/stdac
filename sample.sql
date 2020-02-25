SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `ac_activity` (
  `id` int(11) NOT NULL,
  `name` varchar(1000) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `semester` char(1) NOT NULL,
  `year` char(4) NOT NULL,
  `group_id` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `ac_entry_record` (
  `act_id` int(11) NOT NULL,
  `student_id` varchar(20) NOT NULL,
  `time_entry` datetime NOT NULL,
  `time_record` datetime NOT NULL,
  `time_update` datetime NOT NULL,
  `checker_id` int(11) NOT NULL,
  `entry_type` enum('check','unCheck','notYet','late') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `ac_group` (
  `group_id` varchar(10) NOT NULL,
  `group_short_name` varchar(100) NOT NULL,
  `major_name` varchar(100) NOT NULL,
  `minor_name` varchar(100) NOT NULL,
  `level_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `ac_site_config` (
  `config_name` varchar(32) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `detail` text NOT NULL,
  `lastUpdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


INSERT INTO `ac_site_config` (`config_name`, `detail`, `lastUpdate`) VALUES
('current_semester', '', '2020-02-25 09:29:41'),
('pass_score', '60', '2020-02-25 09:29:44'),
('rms_url', 'RMS_URL', '2020-02-25 09:29:37'),
('siteName', 'Student Activity', '2019-11-11 09:01:54'),
('siteURL', 'SITE_URL', '2020-02-25 09:29:56'),
('subName', 'SA', '2019-11-11 09:02:23'),
('theme', 'adminbsb', '2019-11-01 16:18:36');


CREATE TABLE `ac_std` (
  `student_id` varchar(100) NOT NULL,
  `prefix_id` char(1) DEFAULT NULL,
  `gender_id` int(11) DEFAULT NULL,
  `stu_fname` varchar(1000) NOT NULL,
  `stu_lname` varchar(1000) NOT NULL,
  `group_id` varchar(10) NOT NULL,
  `uid` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `ac_userdata` (
  `id` int(11) NOT NULL COMMENT 'รหัสผู้ใช้',
  `people_id` varchar(13) DEFAULT NULL,
  `username` varchar(50) NOT NULL COMMENT 'ชื่อผู้ใช้',
  `password` varchar(32) NOT NULL COMMENT 'รหัสผ่าน',
  `image_uri` varchar(160) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `personal_id` int(11) DEFAULT NULL COMMENT 'รหัสบุคลากร',
  `active` enum('Y','N','B') NOT NULL DEFAULT 'Y' COMMENT 'เปิดใช้งาน',
  `user_type` enum('admin','advisor','staff','user','guest') NOT NULL DEFAULT 'user' COMMENT 'ประเภทผู้ใช้',
  `last_login` datetime DEFAULT NULL COMMENT 'ลงชื่อเข้าใช้ครั้งสุดท้าย'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



ALTER TABLE `ac_activity`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `ac_entry_record`
  ADD UNIQUE KEY `act_id` (`act_id`,`student_id`,`time_entry`);

ALTER TABLE `ac_group`
  ADD PRIMARY KEY (`group_id`);


ALTER TABLE `ac_site_config`
  ADD PRIMARY KEY (`config_name`),
  ADD UNIQUE KEY `config_name` (`config_name`);

ALTER TABLE `ac_std`
  ADD PRIMARY KEY (`student_id`);

ALTER TABLE `ac_userdata`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `people_id` (`people_id`);

ALTER TABLE `ac_activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `ac_userdata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'รหัสผู้ใช้';

  
INSERT INTO `ac_userdata` (`username`, `password`, `user_type` , `active`) VALUES
('admin', MD5('admin'), 'admin','Y');

COMMIT;

