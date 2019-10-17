<?php

Yii::import('application.models._base.BaseExamApplicationExamSet');

class ExamApplicationExamSet extends BaseExamApplicationExamSet {

    public $countExam;
    public $db_date;
    public $date_start;
    public $date_end;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), array(
            'score' => 'คะแนน',
            'grade' => 'ระดับ',
            'score_update' => 'คะแนน',
            'grade_update' => 'ระดับ',
        ));
    }

    public function behaviors() {
        return array_merge(parent::behaviors(), array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'created',
                'updateAttribute' => 'modified',
                'setUpdateOnCreate' => true,
            ),
        ));
    }

    public function beforeDelete() {
        if (parent::beforeDelete()) {
            ExamApplicationExamSetAudit::model()->deleteAllByAttributes(array(
                'exam_application_id' => $this->exam_application_id,
                'exam_schedule_id' => $this->exam_schedule_id,
                'exam_set_id' => $this->exam_set_id,
            ));
            return true;
        }
    }

    public function relations() {
        return array_merge(parent::relations(), array(
            'updateUser' => array(self::BELONGS_TO, 'User', 'update_user_id'),
            'approve' => array(self::BELONGS_TO, 'User', 'approve_id'),
            'examSubject' => array(self::BELONGS_TO, 'ExamSubject', 'exam_subject_id'),
            'examSet' => array(self::BELONGS_TO, 'ExamSet', 'exam_set_id'),
        ));
    }

    public function rules() {
        return array_merge(parent::rules(), array(
            array('score_update', 'required', 'on' => 'updateScore'),
            array('search', 'safe', 'on' => 'search'),
        ));
    }

    public function getScoreBefore() {
        if ($this->is_update === self::NO) {
            return isset($this->score_update) ? $this->score_update : $this->score;
        } else {
            return $this->score;
        }
    }

    public function getGradeBefore() {
        if ($this->is_update === self::NO) {
            return isset($this->grade_update) ? $this->grade_update : $this->grade;
        } else {
            return $this->grade;
        }
    }

    public function getScoreAfter() {
        if ($this->is_update === self::NO) {
            return isset($this->score_update) ? $this->score : null;
        } else {
            return $this->score_update;
        }
    }

    public function getGradeAfter() {
        if ($this->is_update === self::NO) {
            return isset($this->grade_update) ? $this->grade : null;
        } else {
            return $this->grade_update;
        }
    }

    public function markAsUpdate() {
        if ($this->validate()) {
            $this->update_user_id = Yii::app()->user->id;
            $this->update_date = new CDbExpression('NOW()');
            $this->is_update = self::YES;
            $this->is_approved = self::NO;

            /* Get New Grade */
            $criteria = new CDbCriteria();
            $criteria->compare('min_score', '<=' . $this->score_update);
            $criteria->compare('exam_set_id', $this->exam_set_id);
            $criteria->order = 'min_score DESC';
            $newGrade = ExamSetGrade::model()->find($criteria);
            $this->grade_update = CHtml::value($newGrade, 'grade');

            $this->save(false);
            return true;
        }
    }

    public function scoreApprove() {
        $oldScore = $this->score;
        $this->score = $this->score_update;
        $this->score_update = $oldScore;

        $oldGrade = $this->grade;
        $this->grade = $this->grade_update;
        $this->grade_update = $oldGrade;

        $this->is_approved = self::YES;
        $this->approve_id = Yii::app()->user->id;
        $this->is_update = self::NO;
        $this->save();

        $audit = new ExamApplicationExamSetAudit;
        $audit->attributes = $this->attributes;
        $command = Yii::app()->db->createCommand('SELECT COALESCE(MAX(id),0) +1 FROM exam_application_exam_set_audit WHERE exam_application_id = :exam_application_id AND exam_schedule_id = :exam_schedule_id AND exam_set_id = :exam_set_id');
        $command->bindValues(array(
            ':exam_application_id' => $this->exam_application_id,
            ':exam_schedule_id' => $this->exam_schedule_id,
            ':exam_set_id' => $this->exam_set_id,
        ));
        $audit->id = $command->queryScalar();
        return $audit->save();
    }

    public function scoreDisapprove() {
        $audit = new ExamApplicationExamSetAudit;
        $audit->attributes = $this->attributes;
        $audit->is_approved = self::NO;
        $audit->is_update = self::NO;
        $audit->approve_id = Yii::app()->user->id;
        $oldScore = $audit->score;
        $audit->score = $audit->score_update;
        $audit->score_update = $oldScore;

        $oldGrade = $audit->grade;
        $audit->grade = $audit->grade_update;
        $audit->grade_update = $oldGrade;

        $command = Yii::app()->db->createCommand('SELECT COALESCE(MAX(id),0) +1 FROM exam_application_exam_set_audit WHERE exam_application_id = :exam_application_id AND exam_schedule_id = :exam_schedule_id AND exam_set_id = :exam_set_id');
        $command->bindValues(array(
            ':exam_application_id' => $this->exam_application_id,
            ':exam_schedule_id' => $this->exam_schedule_id,
            ':exam_set_id' => $this->exam_set_id,
        ));
        $audit->id = $command->queryScalar();
        $audit->save();

        $this->is_approved = self::NO;
        $this->is_update = self::NO;
        $this->score_update = null;
        $this->grade_update = null;
        $this->update_date = null;
        $this->update_user_id = null;
        return $this->save();
    }

    public function getHtmlStatus() {
        if ($this->is_approved === ActiveRecord::YES) {
            return '<span class="text-success">อนุมัติ</span>';
        } else {
            if ($this->is_update === ActiveRecord::YES || ($this->is_update === ActiveRecord::NO && !isset($this->score_update, $this->grade_update))) {
                return '<span class="text-info">รอดำเนินการ</span>';
            } else {
                return '<span class="text-danger">ไม่อนุมัติ</span>';
            }
        }
    }

    public function getHtmlStatusClass() {
        if ($this->is_approved === ActiveRecord::YES) {
            return 'bg-success';
        } else {
            if ($this->is_update === ActiveRecord::YES || ($this->is_update === ActiveRecord::NO && !isset($this->score_update, $this->grade_update))) {
                return 'bg-info';
            } else {
                return 'bg-danger';
            }
        }
    }

    public function search() {
        $dataProvider = parent::search();

        if (!empty($this->search['exam_set_id'])) {
            $criteria = new CDbCriteria();
            $criteria->compare('t.exam_set_id', $this->search['exam_set_id'], true);
            $dataProvider->criteria->mergeWith($criteria);
        }

        if (!empty($this->search['exam_code'])) {
            $criteria = new CDbCriteria();
            $criteria->with = array(
                'examSchedule' => array(
                    'together' => true,
                ),
            );
            $criteria->compare('examSchedule.exam_code', $this->search['exam_code'], true);
            $dataProvider->criteria->mergeWith($criteria);
        }

        if (!empty($this->search['entry_code'])) {
            $criteria = new CDbCriteria();
            $criteria->with = array(
                'examApplication' => array(
                    'together' => true,
                ),
                'examApplication.account' => array(
                    'together' => true,
                ),
            );
            $criteria->compare('account.entry_code', $this->search['entry_code'], true);
            $dataProvider->criteria->mergeWith($criteria);
        }

        if (!empty($this->search['application_name'])) {
            $nameCriteria = new CDbCriteria();
            $nameCriteria->with = array(
                'examApplication' => array(
                    'together' => true,
                ),
                'examApplication.account.accountProfile' => array(
                    'together' => true,
                ),
            );
            $words = explode(' ', $this->search['application_name']);
            foreach ($words as $word) {
                if ($word) {
                    $wordCriteria = new CDbCriteria();
                    $wordCriteria->compare('accountProfile.firstname', $word, true, 'OR');
                    $wordCriteria->compare('accountProfile.midname', $word, true, 'OR');
                    $wordCriteria->compare('accountProfile.lastname', $word, true, 'OR');
                }
                $nameCriteria->mergeWith($wordCriteria);
            }
            $dataProvider->criteria->mergeWith($nameCriteria);
        }

        if (!empty($this->search['exam_date_range'])) {
            list($this->date_start, $this->date_end) = explode(' - ', $this->search['exam_date_range']);
            $criteria = new CDbCriteria();
            $criteria->with = array(
                'examSchedule' => array(
                    'together' => true,
                ),
            );
            $criteria->addBetweenCondition('DATE(examSchedule.db_date)', $this->date_start, $this->date_end);
            $dataProvider->criteria->mergeWith($criteria);
        }

        return $dataProvider;
    }

    public function getSearchDateStart($key = 'exam_date_range') {
        list($start, $end) = array_pad(explode(' - ', $this->search[$key]), 2, null);
        return $start;
    }

    public function getSearchDateEnd($key = 'exam_date_range') {
        list($start, $end) = array_pad(explode(' - ', $this->search[$key]), 2, null);
        return $end;
    }

    public function doApprove() {
        $this->is_grade_confirm = self::YES;
        $this->grade_confirm_user_id = Yii::app()->user->id;
        $this->grade_confirm_date = new CDbExpression('NOW()');
        return $this->save();
    }

    public function doDisapprove() {
        $this->is_grade_confirm = self::NO;
        $this->grade_confirm_user_id = null;
        $this->grade_confirm_date = null;
        return $this->save();
    }

    public function getExamPhotos() {
        return array();
    }

    public function getIsDuplicateExamSet() {
        $criteria = new CDbCriteria();
        $criteria->with = array(
            'examSchedule' => array(
                'together' => true,
            ),
            'examApplication' => array(
                'together' => true,
            ),
        );
        $criteria->compare('t.exam_subject_id', $this->exam_subject_id);
        $criteria->compare('t.exam_set_id', $this->exam_set_id);
        $criteria->compare('examApplication.account_id', $this->examApplication->account_id);
        $criteria->compare('examApplication.is_present', self::YES);
        $criteria->compare('t.exam_schedule_id', '<>' . $this->exam_schedule_id);
        $criteria->compare('examSchedule.db_date', '<' . $this->examSchedule->db_date);
        return ExamApplicationExamSet::model()->count($criteria);
    }

    public function getIsGradeConfirm() {
        return $this->is_grade_confirm === self::YES;
    }

    public function getTextGradeConfirmed() {
        if ($this->isGradeConfirm) {
            return $this->grade;
        }
        return '-';
    }

    public function getHtmlGradeConfirmed() {
        if ($this->isGradeConfirm) {
            return '<strong class="text-primary">' . CHtml::value($this, 'grade', '-') . '</strong>';
        }
        return '<span class="text-muted">?</span>';
    }


    public static function getOrderType($code = null) {
       $ret = array(
           0 => 'เรียงตามเลขที่สอบ',
           1 => 'เรียงตามระดับผลสอบ ',
       );
       return isset($code) ? $ret[$code] : $ret;
    }

}
