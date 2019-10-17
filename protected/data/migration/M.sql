/*
*   News Ticker    
*/
INSERT INTO `permission` VALUES ('web.webNewsTicker','จัดการตัววิ่งประชาสัมพันธ์','จัดการตัววิ่งประชาสัมพันธ์','web',NULL);
INSERT INTO `role_permission` VALUES (21,'web.webNewsTicker');
INSERT INTO `configuration` VALUES ('web_news_ticker',0,NULL,NULL,NULL);
INSERT INTO `configuration` VALUES ('custom_content1','',NULL,NULL,NULL);
INSERT INTO `configuration` VALUES ('custom_content2','',NULL,NULL,NULL);
INSERT INTO `configuration` VALUES ('custom_content3','',NULL,NULL,NULL);
/*
*   Image/VDO Slider
*/
INSERT INTO `permission` VALUES ('web.webSlider','จัดการรูปภาพหรือวีดีโอ','จัดการรูปภาพหรือวีดีโอ','web',NULL);
INSERT INTO `role_permission` VALUES (21,'web.webSlider');
INSERT INTO `configuration` VALUES ('web_slider1',NULL,NULL,NULL,NULL);
INSERT INTO `configuration` VALUES ('web_slider2',NULL,NULL,NULL,NULL);
INSERT INTO `configuration` VALUES ('web_slider3',NULL,NULL,NULL,NULL);
INSERT INTO `configuration` VALUES ('web_slider4',NULL,NULL,NULL,NULL);
INSERT INTO `configuration` VALUES ('web_slider5',NULL,NULL,NULL,NULL);

/*
*   FAQ
*/
CREATE TABLE `web_faq` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `question` VARCHAR(255) NULL,
  `content` TEXT NULL,
  `order_no` INT NULL,
  PRIMARY KEY (`id`));
INSERT INTO `permission` VALUES ('web.webFAQ','จัดการคำถามที่พบบ่อย','จัดการคำถามที่พบบ่อย','web',NULL);
INSERT INTO `role_permission` VALUES (21,'web.webFAQ');
/*
*   Contact
*/
INSERT INTO `permission` VALUES ('web.WebContactUs','จัดการที่อยู่ติดต่อ','จัดการที่อยู่ติดต่อ','web',NULL);
INSERT INTO `role_permission` VALUES (21,'web.WebContactUs');
INSERT INTO `configuration` VALUES ('web_contact_us',NULL,NULL,NULL,NULL);

/*
*   Request to Print Result
*/
ALTER TABLE `exam_application` 
ADD COLUMN `is_request` INT(11) NOT NULL DEFAULT '0' COMMENT 'สถานะยืนยันการขอใบรับรองใหม่\\\\n0 = ไม่\\\\n1 = ยืนยันแล้ว' AFTER `present_date`;

/*
*   VDO
*/
ALTER TABLE `web_content` 
ADD COLUMN `vdo` TEXT NULL AFTER `brief_color`;


/*
*   News Ticker   2
*/
INSERT INTO `configuration` VALUES ('web_news_ticker1','0',NULL,NULL,NULL);
INSERT INTO `configuration` VALUES ('web_news_ticker2','0',NULL,NULL,NULL);
INSERT INTO `configuration` VALUES ('web_news_ticker3','0',NULL,NULL,NULL);
INSERT INTO `configuration` VALUES ('custom_new1','0',NULL,NULL,NULL);
INSERT INTO `configuration` VALUES ('custom_new2','0',NULL,NULL,NULL);
INSERT INTO `configuration` VALUES ('custom_new3','0',NULL,NULL,NULL);
INSERT INTO `configuration` VALUES ('custom_date_from1',NULL,NULL,NULL,NULL);
INSERT INTO `configuration` VALUES ('custom_date_from2',NULL,NULL,NULL,NULL);
INSERT INTO `configuration` VALUES ('custom_date_from3',NULL,NULL,NULL,NULL);
INSERT INTO `configuration` VALUES ('custom_date_to1',NULL,NULL,NULL,NULL);
INSERT INTO `configuration` VALUES ('custom_date_to2',NULL,NULL,NULL,NULL);
INSERT INTO `configuration` VALUES ('custom_date_to3',NULL,NULL,NULL,NULL);

INSERT INTO `configuration` VALUES ('email_template_cer_en','<h3>Certification Request</h3><p>Hello, {{fullname}}</p><p>{{message}}</p>',NULL,NULL,NULL);
INSERT INTO `configuration` VALUES ('email_template_cer_th','<h3>การขอใบรับรองใหม่</h3><p>เรียน {{fullname}}</p><p>{{message}}',NULL,NULL,NULL);




/*
*   Request to Print Result 2
*/
ALTER TABLE `exam_application` 
ADD COLUMN `is_request` INT(11) NOT NULL DEFAULT '0' COMMENT 'สถานะยืนยันการขอใบรับรองใหม่\\\\n0 = ไม่\\\\n1 = ยืนยันแล้ว' AFTER `present_date`;



CREATE TABLE  `exam_application_result`  (
    id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
   `exam_application_id` int(10) unsigned DEFAULT NULL COMMENT 'รหัสการสมัครสอบ',
 `name` varchar(500) DEFAULT NULL COMMENT 'ชื่อ – นามสกุลผู้ขอ',
 `id_card` varchar(13) DEFAULT NULL COMMENT 'เลขบัตรประจำตัวประชาชน 13 หลัก',
 `tel` varchar(20) DEFAULT NULL COMMENT 'เบอร์โทรศัพท์ผู้ขอ',
    `is_request` INT(10) NOT NULL DEFAULT '0' COMMENT 'สถานะยืนยันการขอใบรับรองใหม่\\\\n0 = ไม่\\\\n1 = ยืนยันแล้ว',
    `request_number` INT(10) NOT NULL DEFAULT '1' COMMENT 'จำนวนใบรับรองที่ต้องการขอใหม่' ,
   `request_delivery_type` INT(10) NOT NULL DEFAULT '0' COMMENT 'ประเภทการส่งใบรับรอง',
 `address` varchar(500) DEFAULT NULL COMMENT 'ที่อยู่จัดส่ง',
 `request_date` datetime DEFAULT NULL COMMENT 'วันที่ขอ',
  KEY `fk_exam_application_result_exam_application1_idx` (`exam_application_id`),
  CONSTRAINT `fk_exam_application_result_exam_application1` FOREIGN KEY (`exam_application_id`) REFERENCES `exam_application` (`id`)
);

/*
*   Request to Print Result 30 01 2019
*/
alter table `exam_application_result` 
add  COLUMN `member_id` int(10) unsigned DEFAULT NULL;

/*
*   Start Phase 2 --08/06/2019
*/

ALTER TABLE `web_content` 
ADD COLUMN `custom_link` TEXT NULL;


alter table `exam_application_result` 
add  COLUMN `exam_schedule_id` int(10) unsigned DEFAULT NULL COMMENT 'รอบสอบ';
alter table `exam_application_result` 
add CONSTRAINT `fk_exam_application_result_exam_application2` FOREIGN KEY (`exam_schedule_id`) REFERENCES `exam_schedule` (`id`);



update `code_country` set nationality = 'Burmese' where id = 104;
update `code_country` set nationality = 'Lao' where id = 418;

INSERT INTO `configuration` VALUES ('web_slider_url1',NULL,NULL,NULL,NULL);
INSERT INTO `configuration` VALUES ('web_slider_url2',NULL,NULL,NULL,NULL);
INSERT INTO `configuration` VALUES ('web_slider_url3',NULL,NULL,NULL,NULL);
INSERT INTO `configuration` VALUES ('web_slider_url4',NULL,NULL,NULL,NULL);
INSERT INTO `configuration` VALUES ('web_slider_url5',NULL,NULL,NULL,NULL);
INSERT INTO `configuration` VALUES ('web_slider_is_visible1',NULL,NULL,NULL,NULL);
INSERT INTO `configuration` VALUES ('web_slider_is_visible2',NULL,NULL,NULL,NULL);
INSERT INTO `configuration` VALUES ('web_slider_is_visible3',NULL,NULL,NULL,NULL);
INSERT INTO `configuration` VALUES ('web_slider_is_visible4',NULL,NULL,NULL,NULL);
INSERT INTO `configuration` VALUES ('web_slider_is_visible5',NULL,NULL,NULL,NULL);

ALTER TABLE `exam_application` 
ADD COLUMN `temp_order_index` int NULL;


CREATE TABLE  `exam_result_level_order`  (
    id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
   `subject_count` int(10) unsigned DEFAULT NULL COMMENT 'จำนวนวิชาที่สอบ',
   `grade1` varchar(10) DEFAULT NULL COMMENT 'ผลสอบที่ 1',
   `grade2` varchar(10) DEFAULT NULL COMMENT 'ผลสอบที่ 2',
   `grade3` varchar(10) DEFAULT NULL COMMENT 'ผลสอบที่ 3',
   `grade4` varchar(10) DEFAULT NULL COMMENT 'ผลสอบที่ 4',
   `order_index` INT(10) NOT NULL DEFAULT '0' COMMENT 'ลำดับการเรียงข้อมูล' ,
  KEY `fk_exam_result_level_order_idx` (`id`)
);