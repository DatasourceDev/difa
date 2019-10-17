<?php

Yii::import('application.models._base.BaseOmrStorageDataImport');

class OmrStorageDataImport extends BaseOmrStorageDataImport {

    public $omr_file;
    public $exam_code;
    private $_result = array();

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), array(
            'exam_set' => 'ชุดข้อสอบ',
            'dvifa_code' => 'รหัสประจำตัว',
            'exam_num' => 'เลขที่นั่งสอบ',
            'omr_file' => 'ไฟล์ข้อมูลกระดาษคำตอบ',
        ));
    }

    public function rules() {
        return array_merge(parent::rules(), array(
            array('omr_file', 'file', 'types' => array('zip'), 'allowEmpty' => false),
            array('omr_file', 'parseFile'),
            array('exam_code', 'safe'),
        ));
    }

    public function getResult() {
        return $this->_result;
    }

    public function parseFile() {
        /* รับเข้า File ที่ upload มา */
        Yii::log('======= START Exam Parser =======', CLogger::LEVEL_TRACE);
        $file = CUploadedFile::getInstance($this, 'omr_file');
        if ($file) {
            $this->exam_set = substr($file->getName(), 0, -4);
            Yii::log('Exam SET : ' . $this->exam_set, CLogger::LEVEL_TRACE);
            $zip = new ZipArchive();
            $res = $zip->open($file->tempName);
            if ($res === true) {
                Yii::log('Open zip file successful.' . $this->exam_set, CLogger::LEVEL_TRACE);
                $importData = new stdClass();
                $importData->imageFiles = array();
                $importData->imageIndexData = array();

                for ($i = 0; $i < $zip->numFiles; $i++) {
                    $basename = $zip->getNameIndex($i);
                    switch (pathinfo($basename, PATHINFO_EXTENSION)) {
                        case 'jpg':
                            $importData->imageFiles[] = $basename;
                            $filename = basename($basename);
                            $data = array(
                                'omr_serial' => substr($filename, 0, 6),
                                'page' => substr($filename, 6, 2),
                            );
                            $picName = uniqid(rand(0, 9999), true) . '-' . $data['omr_serial'] . $data['page'] . '.jpg';
                            file_put_contents(Yii::getPathOfAlias('application.uploads.omr') . DIRECTORY_SEPARATOR . $picName, $zip->getFromIndex($i));
                            $importData->imageIndexData[$data['omr_serial']][$data['page']] = Yii::app()->baseUrl . '/protected/uploads/omr/' . $picName;
                            break;
                        case 'ndx':
                            $importData->imageIndexFile = $basename;
                            $content = $zip->getFromIndex($i);
                            $lines = explode("\n", $content);
                            foreach ($lines as $countLine => $line) {
                                if (trim($line)) {
                                    $data = array(
                                        'page' => substr($line, 14, 2),
                                        'omr_serial' => substr($line, 17, 6),
                                        'omr_file' => substr($line, 24, 12),
                                    );
                                    //$importData->imageIndexData[$data['omr_serial']][$data['page']] = $data;
                                }
                            }
                            break;
                        case 'dat':
                            Yii::log('Parsing .dat file ...', CLogger::LEVEL_TRACE);
                            $filename = pathinfo($basename, PATHINFO_FILENAME);
                            $examSet = ExamSet::model()->findByPk($filename);
                            if (!isset($examSet)) {
                                Yii::log('*ERROR* ExamSet not found.', CLogger::LEVEL_TRACE);
                                //$this->addError('omr_file', 'ไม่พบชุดสอบ "' . $filename . '" ในระบบ กรุณาตรวจสอบอีกครั้ง');
                                //return false;
                            } else {
                                Yii::log('*OK* ExamSet found.', CLogger::LEVEL_TRACE);
                            }
                            $content = $zip->getFromIndex($i);
                            $lines = explode("\n", $content);
                            Yii::log('*OK* Found ' . count($lines) . ' lines to process.', CLogger::LEVEL_TRACE);
                            foreach ($lines as $countLine => $line) {
                                /* 41 */
                                $line = str_replace(array("\r", "\n"), '', $line);
                                /* สนใจตำแหน่งที่ 5 */
                                if ($line) {

                                    /* เก็บข้อมูล */
                                    $data = array(
                                        0 => $line,
                                        1 => substr($line, 40, 33),
                                        2 => substr($line, 75),
                                        3 => substr($line, 3, 6),
                                    );
                                    //preg_match('/(^[a-zA-Z0-9\-]{35})\s+(.*)/', $line, $data);
                                    $info = array(
                                        'raw' => CHtml::value($data, 0),
                                        'omr_serial' => CHtml::value($data, 3),
                                        'exam_set' => substr(CHtml::value($data, 1), 0, 7) . '_' . substr($filename, -2),
                                        'account' => substr(CHtml::value($data, 1), 7, 13),
                                        'desk_no' => substr(CHtml::value($data, 1), 20, 3),
                                        'exam_code' => substr(CHtml::value($data, 1), 23, 10),
                                        'teacher_code_1' => substr(str_replace(array("\n", "\r"), '', CHtml::value($data, 2)), 0, 2),
                                        'teacher_code_2' => substr(str_replace(array("\n", "\r"), '', CHtml::value($data, 2)), 2, 2),
                                        'answer' => substr(str_replace(array("\n", "\r"), '', CHtml::value($data, 2)), 4, -2),
                                        'density' => substr(str_replace(array("\n", "\r"), '', CHtml::value($data, 2)), -2),
                                    );
                                    /*
                                      echo '<pre>';
                                      var_dump($info,$data);
                                      exit; */

                                    if (!$this->exam_code) {
                                        $this->exam_code = CHtml::value($info, 'exam_code');
                                    }

                                    $schedule = ExamSchedule::model()->findByAttributes(array(
                                        'exam_code' => CHtml::value($info, 'exam_code'),
                                    ));

                                    $set = ExamSet::model()->findByAttributes(array(
                                        'id' => CHtml::value($info, 'exam_set'),
                                    ));

                                    $answer = CHtml::value($info, 'answer');

                                    if (!$set) {
                                        Yii::log('*ERROR* ExamSet not found in the line.', CLogger::LEVEL_TRACE);
                                    }
                                    Yii::log('Data of Line ' . ($countLine + 1) . ' is ..', CLogger::LEVEL_TRACE);
                                    Yii::log(print_r($info, true), CLogger::LEVEL_TRACE);

                                    /* ตรวจข้อสอบ */
                                    if (isset($set)) {
                                        $case = 0;
                                        $score = 0;
                                        $correct = array('a' => 0, 'b' => 0);
                                        if ($set->is_grade_set === ExamSet::YES) {
                                            $score = $answer{$case};
                                            $case++;
                                        } else {
                                            foreach ($set->examSetTasks as $task) {
                                                switch ($task->exam_question_method_id) {
                                                    case 1:
                                                    case 2:
                                                        foreach ($task->examSetTaskItems as $item) {
                                                            if ($answer{$case} === $item->answer) {
                                                                $score++;
                                                                $correct['a'] ++;
                                                            }
                                                            $case++;
                                                        }
                                                        break;
                                                    case 3:
                                                    case 4:
                                                        for ($j = 0; $j < $task->task_num; $j++) {
                                                            if (isset($answer{$case}) && $answer{$case} == '1') {
                                                                $score++;
                                                                $correct['b'] ++;
                                                            }
                                                            $case++;
                                                        }
                                                        break;
                                                    case 5:
                                                        //for ($i = 0; $i < $task->task_num; $i++) {
                                                        $score += (int) ($answer{$case} . $answer{$case + 1});
                                                        //}
                                                        $case += 2;
                                                        break;
                                                }
                                            }
                                        }
                                    }

                                    /* ให้เกรด */
                                    try {
                                        if (isset($set)) {
                                            if ($set->is_grade_set === ExamSet::YES) {
                                                $grade = ExamSetGrade::model()->findByAttributes(array(
                                                    'exam_set_id' => $set->id,
                                                    'order_no' => $score,
                                                ));
                                            } else {
                                                $criteria = new CDbCriteria();
                                                $criteria->compare('exam_set_id', $set->id);
                                                $criteria->compare('min_score', '<=' . $score);
                                                $criteria->order = 'min_score DESC';
                                                $grade = ExamSetGrade::model()->find($criteria);
                                            }

                                            $account = Account::model()->findByAttributes(array(
                                                'entry_code' => CHtml::value($info, 'account'),
                                                'status' => Account::STATUS_ACTIVED,
                                            ));

                                            if ($account) {
                                                $criteria = new CDbCriteria();
                                                $criteria->compare('account_id', $account->id);
                                                $criteria->compare('exam_schedule_id', CHtml::value($schedule, 'id'));
                                                $application = ExamApplication::model()->scopeValid()->find($criteria);

                                                if ($application) {
                                                    $criteria = new CDbCriteria();
                                                    $criteria->compare('exam_application_id', CHtml::value($application, 'id'));
                                                    $criteria->compare('exam_schedule_id', CHtml::value($schedule, 'id'));
                                                    $criteria->compare('exam_subject_id', $set->exam_subject_id);
                                                    /* @var $e ExamApplicationExamSet */
                                                    $e = ExamApplicationExamSet::model()->find($criteria);

                                                    $result = new ImportResult;
                                                    $result->exam_application_id = CHtml::value($application, 'id');
                                                    $result->exam_schedule_id = CHtml::value($schedule, 'id');
                                                    $result->exam_subject_id = $set->exam_subject_id;
                                                    $result->exam_set_id = $set->id;
                                                    $result->exam_application_id = $application->id;
                                                    if (!isset($e)) {
                                                        $e = new ExamApplicationExamSet;
                                                        $e->exam_application_id = CHtml::value($application, 'id');
                                                        $e->exam_schedule_id = CHtml::value($schedule, 'id');
                                                        $e->exam_subject_id = $set->exam_subject_id;
                                                        $e->created = new CDbExpression('NOW()');
                                                        $result->comment = 'ระบบกำหนดชุดข้อสอบให้อัตโนมัต';
                                                    }
                                                    if (isset($e)) {
                                                        $e->created = new CDbExpression('NOW()');
                                                        if (!$e->created) {
                                                            $e->created = new CDbExpression('NOW()');
                                                        }
                                                        $e->score = $score;
                                                        $e->grade = CHtml::value($grade, 'grade');
                                                        if (isset($schedule)) {
                                                            $e->grade_expire = date('Y-m-d', strtotime('+2 years', strtotime(CHtml::value($schedule, 'db_date', date('Y-m-d')))));
                                                        }
                                                        $e->raw_data = CHtml::value($info, 'answer');
                                                        $e->modified = new CDbExpression('NOW()');
                                                        if (isset($grade)) {
                                                            $e->is_border_line = (CHtml::value($grade->nextGrade(), 'min_score', 0) - 1) == $score ? self::YES : self::NO;
                                                        } else {
                                                            $e->is_border_line = self::NO;
                                                        }
                                                        $e->teacher_1 = CHtml::value($info, 'teacher_code_1');
                                                        $t1 = ExamApprover::model()->findByPk($e->teacher_1);
                                                        if (isset($t1)) {
                                                            $e->teacher_1_name = $t1->name;
                                                        }
                                                        $e->teacher_2 = CHtml::value($info, 'teacher_code_2');
                                                        $t2 = ExamApprover::model()->findByPk($e->teacher_2);
                                                        if (isset($t2)) {
                                                            $e->teacher_2_name = $t2->name;
                                                        }
                                                        $result->score = $e->score;
                                                        $result->grade = $e->grade;
                                                        $result->is_border_line = $e->is_border_line;
                                                        if ($e->exam_set_id !== $set->id) {
                                                            $result->prev_exam_set_id = $e->exam_set_id;
                                                            $e->exam_set_id = $set->id;
                                                            $result->is_success = self::NO;
                                                            $result->comment = 'ชุดข้อสอบไม่ตรงกับที่กำหนดไว้ (' . CHtml::value($result, 'prev_exam_set_id', '--ไม่ระบุ--') . ')';
                                                        } else {
                                                            if ($e->save()) {
                                                                $result->is_success = self::YES;
                                                            } else {
                                                                $result->is_success = self::NO;
                                                                $result->comment = CHtml::errorSummary($e->errors);
                                                                $this->addError('omr_file', CHtml::errorSummary($e->errors));
                                                            }
                                                        }
                                                    } else {
                                                        $result->is_success = false;
                                                        $result->comment = 'ไม่พบรายการที่ตรงกับข้อมูลผลสอบ';
                                                    }
                                                    $this->_result[] = $result;
                                                }
                                            }
                                        }
                                    } catch (CException $e) {
                                        $this->addError('omr_file', $e->getMessage());
                                    }

                                    /* บันทึกข้อมูลลง OMR Storage */
                                    $omr = OmrStorageData::model()->findByAttributes(array(
                                        'exam_set' => CHtml::value($info, 'exam_set'),
                                        'dvifa_code' => CHtml::value($info, 'account'),
                                        'exam_num' => CHtml::value($info, 'desk_no'),
                                    ));
                                    if (!isset($omr)) {
                                        $omr = new OmrStorageData;
                                        $omr->exam_set = CHtml::value($info, 'exam_set');
                                        $omr->dvifa_code = CHtml::value($info, 'account');
                                        $omr->exam_num = CHtml::value($info, 'desk_no');
                                        if (isset($schedule)) {
                                            $omr->exam_schedule = CHtml::value($schedule, 'id');
                                        }
                                        if (isset($application)) {
                                            $omr->desk_no = CHtml::value($application, 'desk_no');
                                        }
                                    }
                                    $omr->raw_data = CHtml::value($info, 'answer');
                                    $omr->import_date = new CDbExpression('NOW()');
                                    $omr->omr_serial = CHtml::value($info, 'omr_serial');
                                    $omr->modified = new CDbExpression('NOW()');
                                    try {
                                        if (!$omr->save(false)) {
                                            var_dump($omr->errors);
                                        } else {
                                            $importData->omrSerial[CHtml::value($info, 'omr_serial')] = $omr;
                                        }
                                    } catch (CDbException $e) {
                                        
                                    }
                                }
                            }
                            $importData->examSet = $examSet;
                            break;
                    }
                }

                if (isset($importData->omrSerial)) {
                    foreach ($importData->omrSerial as $serial => $model) {
                        if (isset($importData->imageIndexData[$serial])) {
                            $model->saveAttributes(array(
                                'json_data' => json_encode(array(
                                    'photos' => $importData->imageIndexData[$serial],
                                )),
                            ));
                        }
                    }
                }
                $zip->close();
            } else {
                echo 'failed, code:' . $res;
            }
            Yii::log('======= END Exam Parser =======', CLogger::LEVEL_TRACE);
            return true;
        }
    }

    public function import() {
        if ($this->validate(array('omr_file'))) {
            $file = CUploadedFile::getInstance($this, 'omr_file');
            if ($file) {
                $zip = new ZipArchive();
                $res = $zip->open($file->tempName);
                if ($res === true) {
                    for ($i = 0; $i < $zip->numFiles; $i++) {
                        $basename = $zip->getNameIndex($i);
                        /* parse .DAT file. */
                        if (pathinfo($basename, PATHINFO_EXTENSION) === 'dat') {
                            $filename = pathinfo($basename, PATHINFO_FILENAME);
                            $content = $zip->getFromIndex($i);
                        }
                    }
                    $zip->close();
                } else {
                    echo 'failed, code:' . $res;
                }
                return true;
            }
        }
    }

}
