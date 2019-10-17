<?php

Yii::import('application.models._base.BaseExamSet');

class ExamSet extends BaseExamSet {

    public $exam_schedule_id;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getIsGradeSetOptions($code = null) {
        $ret = array(
            self::NO => 'วัดคะแนนตามเกณฑ์',
            self::YES => 'กำหนดระดับโดยตรง',
        );
        return isset($code) ? $ret[$code] : $ret;
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), array(
            'exam_type_id' => 'ประเภทการสอบ',
            'exam_subject_id' => 'ทักษะในการสอบ',
            'exam_topic_code' => 'หัวข้อในการสอบ',
            'exam_year' => 'ปีของชุดสอบ',
            'exam_num' => 'เลขที่ชุดสอบ',
            'is_grade_set' => 'ลักษณะการกำหนดระดับ',
        ));
    }

    public function relations() {
        return array_merge(parent::relations(), array(
            'examSubjectTopic' => array(self::HAS_ONE, 'ExamSubjectTopic', array(
                    'exam_subject_id' => 'exam_subject_id',
                    'exam_topic_code' => 'exam_topic_code',
                )),
            'countExamSetTask' => array(self::STAT, 'ExamSetTask', 'exam_set_id'),
            'countExamSetTaskItem' => array(self::STAT, 'ExamSetTask', 'exam_set_id', 'select' => 'SUM(task_num)'),
            'examSetGrades' => array(self::HAS_MANY, 'ExamSetGrade', 'exam_set_id', 'order' => 'order_no'),
            'examSchedule' => array(self::BELONGS_TO, 'ExamSchedule', 'exam_schedule_id'),
            'examScheduleItems' => array(self::HAS_MANY, 'ExamScheduleItem', 'exam_set_id'),
            'examApplicationExamSets' => array(self::HAS_MANY, 'ExamApplicationExamSet', 'exam_set_id'),
            'examApplicationExamSetAudits' => array(self::HAS_MANY, 'ExamApplicationExamSetAudit', 'exam_set_id'),
        ));
    }

    public function rules() {
        return array_merge(parent::rules(), array(
            array('exam_topic_code, exam_year, exam_num, is_grade_set', 'required'),
            array('exam_schedule_id', 'safe'),
        ));
    }

    public function beforeValidate() {
        if (parent::beforeValidate()) {
            if (!isset($this->id)) {
                $this->id = $this->getPreviewId();
            }
            return true;
        }
    }

    public function beforeSave() {
        if (parent::beforeSave()) {
            if (isset($this->exam_subject_id) && !isset($this->exam_subject_code)) {
                $this->exam_subject_code = CHtml::value($this, 'examSubject.code');
            }
            return true;
        }
    }

    public function beforeDelete() {
        if (parent::beforeDelete()) {

            ExamSetGrade::model()->deleteAllByAttributes(array(
                'exam_set_id' => $this->id,
            ));
            ExamSetTaskItem::model()->deleteAllByAttributes(array(
                'exam_set_id' => $this->id,
            ));
            ExamSetTask::model()->deleteAllByAttributes(array(
                'exam_set_id' => $this->id,
            ));

            return true;
        }
    }

    public function getPreviewId() {
        return CHtml::value($this, 'examType.code', '##') . CHtml::value($this, 'examSubject.code', '#') . CHtml::value($this, 'exam_topic_code', '##') . CHtml::value($this, 'exam_num', '##') . '_' . substr(CHtml::value($this, 'exam_year', '##'), -2);
    }

    public function getAvailableExamNumItems() {
        $ret = array();

        if (!isset($this->exam_type_id, $this->exam_subject_id, $this->exam_topic_code, $this->exam_year)) {
            return $ret;
        }
        for ($i = 1; $i <= 99; $i++) {
            $ret[str_pad($i, 2, '0', STR_PAD_LEFT)] = str_pad($i, 2, '0', STR_PAD_LEFT);
        }
        $examSets = CHtml::listData(ExamSet::model()->findAllByAttributes(array(
                            'exam_type_id' => $this->exam_type_id,
                            'exam_subject_id' => $this->exam_subject_id,
                            'exam_topic_code' => $this->exam_topic_code,
                            'exam_year' => $this->exam_year,
                        )), 'exam_num', 'exam_num');
        $ret = array_diff($ret, $examSets);
        if (!$this->isNewRecord) {
            $ret[$this->exam_num] = $this->exam_num;
            ksort($ret);
        }
        return $ret;
    }

    /**
     * ตรวจสอบว่า ชุดข้อสอบนี้ มีเฉลยครบเรียบร้อย
     * @return boolean 
     */
    public function getIsTaskReady() {
        $criteria = new CDbCriteria();
        $criteria->compare('exam_set_id', $this->id);
        $criteria->addCondition('answer IS NULL');
        $found = ExamSetTaskItem::model()->find($criteria);
        return !isset($found);
    }

    /**
     * ตรวจสอบว่า ชุดข้อสอบนี้ ตั้งค่าระดับเรียบร้อย
     * @return boolean 
     */
    public function getIsGradeReady() {
        if ($this->isGradeSet) {
            return true;
        }
        $criteria = new CDbCriteria();
        $criteria->compare('exam_set_id', $this->id);
        $criteria->addCondition('min_score IS NULL');
        $found = ExamSetGrade::model()->find($criteria);
        return !isset($found);
    }

    /**
     * ตรวจสอบว่า ชุดข้อสอบนี้ พร้อมที่จะใช้งานแล้วหรือไม่
     * @return boolean 
     */
    public function getIsReady() {
        if ($this->getIsTaskReady() && $this->getIsGradeReady()) {
            return true;
        }
    }

    public function create() {
        if ($this->save()) {
            // initial default grades.
            $grades = ExamDefaultGrade::model()->findAllByAttributes(array(
                'exam_type_id' => $this->exam_type_id,
                'exam_subject_id' => $this->exam_subject_id,
            ));
            foreach ($grades as $grade) {
                /* @var $grade ExamDefaultGrade */
                $setGrade = new ExamSetGrade();
                $setGrade->exam_set_id = $this->id;
                $setGrade->grade = $grade->grade;
                $setGrade->description = $grade->description;
                $setGrade->order_no = $grade->order_no;
                $setGrade->save();
            }
            return true;
        }
    }

    /**
     * บันทึกข้อมูลเฉลยข้อสอบ
     * @param mixed $answers
     * @return boolean
     */
    public function saveTaskAnswer($answers = array()) {
        foreach ($answers as $task_no => $tasks) {
            foreach ($tasks as $order_no => $answer) {
                ExamSetTaskItem::model()->updateByPk(array(
                    'exam_set_id' => $this->id,
                    'task_no' => $task_no,
                    'order_no' => $order_no,
                        ), array(
                    'answer' => empty($answer) ? null : strtoupper($answer),
                ));
            }
        }
        return true;
    }

    public function getIsGradeSet() {
        return $this->is_grade_set === self::YES;
    }

    public function findAllBySubject($code) {
        $criteria = new CDbCriteria();
        $criteria->with = array(
            'examSubject' => array(
                'together' => true,
            ),
        );
        $criteria->compare('examSubject.code', $code);
        $criteria->compare('t.exam_type_id', $this->exam_type_id);
        return $this->findAll($criteria);
    }

    public function findAllByScheduleSubject($code) {
        $criteria = new CDbCriteria();
        $criteria->with = array(
            'examScheduleItems' => array(
                'select' => false,
                'together' => true,
            ),
            'examSubject' => array(
                'together' => true,
            ),
        );
        $criteria->compare('examSubject.code', $code);
        $criteria->compare('t.exam_type_id', $this->exam_type_id);
        $criteria->compare('examScheduleItems.exam_schedule_id', $this->exam_schedule_id);
        return $this->findAll($criteria);
    }

}
