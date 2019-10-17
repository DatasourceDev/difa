<?php

Yii::import('application.models._base.BasePermission');

class Permission extends BasePermission {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getGroupName($code = null) {
        $ret = array(
            'exam' => 'เมนูข้อมูลการสอบ/จัดสอบ',
            'process' => 'เมนูประมวลผลสอบ/จัดเก็บ',
            'income' => 'เมนูระบบบันทึกรายรับ',
            'expenditure' => 'เมนูระบบบันทึกรายจ่าย',
            'report' => 'เมนูรายงาน',
            'web' => 'เมนูจัดการเว็บไซต์',
            'admin' => 'เมนูสำหรับผู้ดูแลระบบ',
        );
        return isset($code) ? $ret[$code] : $ret;
    }

    public static function getPermissionItems() {
        return array(
            'exam' => array(
                'manageSchedule.index' => 'ข้อมูลการจัดสอบ',
                'manageSchedule.calendar' => 'ปฏิทินการสอบ',
                'manageScheduleApplication' => 'ข้อมูลการสมัครสอบ',
                'manageSchedulePayment' => 'ข้อมูลการชำระเงิน',
                'manageExamSet' => 'จัดการชุดข้อสอบ',
                'manageExam' => 'จัดการข้อมูลการสอบ',
                'manageSchedulePlace' => 'จัดการข้อมูลสถานที่จัดสอบ',
                'manageScheduleHoliday' => 'จัดการวันหยุดนักขัตฤกษ์ / วันหยุดประจำปี',
                'manageExamObjective' => 'จัดการวัตถุประสงค์ในการสอบ',
                'manageExamQuestionMethod' => 'จัดการชนิดของข้อสอบ',
                'codeExamApprover' => 'ข้อมูลอาจารย์ผู้ตรวจข้อสอบ',
                'examSpeaking' => 'ข้อมูลชุดสอบสำหรับทักษะการพูด',
            ),
            'process' => array(
                'examProcess' => 'ประมวลผลการสอบ',
                'examProcessExamSet' => 'รายการตรวจข้อสอบ',
                'examProcessBorderLine' => 'รายชื่อผู้ที่มีเกณฑ์คะแนนเท่ากับ Border Line',
                'omrStorage.import' => 'นำเข้าข้อมูลกระดาษคำตอบ',
                'omrStorage.index' => 'ค้นหากระดาษคำตอบ',
                'legacy' => 'ข้อมูลจากระบบเดิม',
            ),
            'income' => array(
                'incomeOverview' => 'ภาพรวมการบันทึกรายรับ',
                'income' => 'บันทึกรายรับ',
                'incomeType' => 'จัดการประเภทรายรับ',
            ),
            'expenditure' => array(
                'expenditureOverview' => 'ภาพรวมการบันทึกรายจ่าย',
                'expenditure' => 'บันทึกรายจ่าย',
                'expenditureType' => 'จัดการประเภทรายจ่าย',
            ),
            'report' => array(
                'reportExamCard' => 'บัตรประจำตัวสอบ',
                'reportPaymentSlip' => 'ใบชำระเงิน',
                'reportNameList' => 'รายชื่อสำหรับติดห้องสอบ',
                'reportNameListByObjective' => 'รายชื่อผู้เข้าสอบแยกตามวัตถุประสงค์ในการสอบ',
                'reportNameSignature' => 'ใบเซ็นต์ชื่อ',
                'reportPaymentStatus' => 'สถานะการชำระเงิน',
                'reportApplication' => 'สถิติการสอบ',
                'reportPayment' => 'รายงานการชำระเงิน',
                'reportReceipt' => 'ใบเสร็จรับเงิน',
                'reportIncome' => 'รายงานรายได้',
                'reportExpenditure' => 'รายงานรายจ่าย',
                'reportTestResult' => 'ใบรับรองผลสอบภาษาอังกฤษ',
                'reportTestResultReply' => 'หนังสือแจ้งผลการทดสอบภาษาอังกฤษ',
                'reportTestResultEnvelope' => 'ซองสำหรับส่งผลสอบ',
                'reportTestResultCover' => 'ใบปะหน้าซองสำหรับส่งผลสอบให้หน่วยงาน',
                'reportMemberProfile' => 'ประวัติการสอบรายบุคคล',
                'reportExamSet' => 'ประวัติการสอบสำหรับจัดชุดข้อสอบ',
                'reportBorderLine' => 'รายงานบุคคลที่ได้คะแนนเท่ากับ Border Line',
                'reportExamApprove' => 'รายงานการตรวจข้อสอบ',
                'reportExamRawData' => 'ข้อมูลการทำข้อสอบ',
                'reportBarcode' => 'บาร์โค๊ดสำหรับติดบนกระดาษคำตอบ',
                'reportExportCertificateFromXls' => 'พิมพ์ใบรับรองจากไฟล์ Excel',
                'reportTestRequestByOffice' => 'รายงานผลการทดสอบวัดระดับความสามารถทางภาษาอังกฤษ',
            ),
            'web' => array(
                'webConfiguration' => 'ตั้งค่าเว็บไซต์',
                'webMenu' => 'จัดการเมนูเว็บไซต์',
                'webTemplate' => 'จัดการรูปแบบเว็บไซต์',
                'webDownload' => 'เอกสารดาวน์โหลด',
                'webContent' => 'จัดการเนื้อหาข่าวสาร',
                'webContentMail' => 'ส่งข่าวสารทางอีเมล์',
                'webContentSms' => 'ส่งข่าวสารทาง SMS',
                'webNewsTicker' => 'จัดการรูปภาพหรือวีดีโอ',
                'webSlider' => 'จัดการรูปภาพหรือวีดีโอที่หน้าจอหลัก',
                'webFAQ' => 'จัดการคำถามที่พบบ่อย',
                'WebContactUs' => 'จัดการที่อยู่ติดต่อ',
            ),
            'admin' => array(
                'manageUser' => 'จัดการข้อมูลผู้ใช้งาน',
                'manageUserGroup' => 'จัดการกลุ่มผู้ใช้งาน',
                'manageMemberGeneralThai' => 'สมาชิกสัญชาติไทย',
                'manageMemberGeneralForeigner' => 'สมาชิกชาวต่างชาติ',
                'manageMemberDiplomatThai' => 'นักการทูตไทย และ นักวิเทศสหการ',
                'manageMemberDiplomatForeigner' => 'นักการทูตต่างชาติ',
                'manageOfficeUser' => 'ตัวแทนหน่วยงาน',
                'configuration' => 'ตั้งค่าระบบ',
                'configurationMail' => 'ตั้งค่าการแจ้งข้อความผ่าน email',
                'configurationSms' => 'ตั้งค่าการแจ้งข้อความผ่าน SMS',
                'backup' => 'ระบบสำรองข้อมูล',
                'codeDepartment' => 'ข้อมูลหน่วยงาน/กระทรวง',
                'codeCountry' => 'ข้อมูลประเทศ/สัญชาติ',
                'logSms' => 'ข้อมูลการส่ง SMS',
                'logMail' => 'ข้อมูลการส่งจดหมาย',
            ),
        );
    }

    public static function getGroups() {
        $groups = array();
        $permissionGroups = Permission::model()->sortBy('order_no, name')->findAll(array(
            'group' => 'group_name',
            'order' => 'group_name',
        ));
        foreach ($permissionGroups as $group) {
            $items = Permission::model()->sortBy('order_no, name')->findAllByAttributes(array(
                'group_name' => $group->group_name,
            ));
            $groups[$group->group_name] = $items;
        }
        return $groups;
    }

    public function generatePermissionTable() {
        Yii::app()->db->createCommand('SET foreign_key_checks = 0')->execute();
        Yii::app()->db->createCommand('TRUNCATE TABLE permission')->execute();
        foreach (self::getPermissionItems() as $key => $item) {
            if (is_array($item)) {
                foreach ($item as $name => $description) {
                    $insert = Yii::app()->db->createCommand('INSERT INTO permission (id, name, description, group_name) VALUES(:id, :name, :description, :group_name)');
                    $insert->bindValues(array(
                        ':id' => $key . '.' . $name,
                        ':name' => $description,
                        ':description' => $description,
                        ':group_name' => $key,
                    ));
                    $insert->execute();
                }
            }
        }
        Yii::app()->db->createCommand('SET foreign_key_checks = 1')->execute();
    }

}
