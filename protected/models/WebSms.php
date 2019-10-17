<?php

Yii::import('application.models._base.BaseWebSms');

class WebSms extends BaseWebSms {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function rules() {
        return array_merge(parent::rules(), array(
            array('title, content', 'required'),
            array('search', 'safe'),
        ));
    }

    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), array(
            'title' => 'หัวเรื่อง',
            'content' => 'เนื้อหา',
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

    public function afterSave() {
        parent::afterSave();

        WebMailItem::model()->deleteAllByAttributes(array(
            'web_mail_id' => $this->id,
        ));

        $iterator = new CDataProviderIterator($this->getRecipients());
        foreach ($iterator as $item) {
            $mailItem = new WebMailItem;
            $mailItem->web_mail_id = $this->id;
            $mailItem->address_to = CHtml::value($item, 'account.msisdn');
            $mailItem->address_from = Configuration::getKey('sys_mail', 'noreply@difa-tes.mfa.go.th');
            $mailItem->save();
        }
    }

    public function relations() {
        return array_merge(parent::relations(), array(
            'examSchedule' => array(self::BELONGS_TO, 'ExamSchedule', 'exam_schedule_id'),
        ));
    }

    public function getRecipientCount() {
        $dataProvider = $this->getRecipients();
        return $dataProvider->totalItemCount;
    }

    public function getRecipients() {
        $mainCriteria = new CDbCriteria();

        if (!empty($this->date_start)) {
            $criteria = new CDbCriteria();
            $criteria->with = array(
                'examSchedule' => array(
                    'together' => true,
                ),
            );
            $criteria->compare('DATE(examSchedule.db_date)', '>=' . $this->date_start);
            $mainCriteria->mergeWith($criteria);
        }

        if (!empty($this->date_end)) {
            $criteria = new CDbCriteria();
            $criteria->with = array(
                'examSchedule' => array(
                    'together' => true,
                ),
            );
            $criteria->compare('DATE(examSchedule.db_date)', '<=' . $this->date_end);
            $mainCriteria->mergeWith($criteria);
        }

        if (!empty($this->search['exam_type_id'])) {
            $criteria = new CDbCriteria();
            $criteria->with = array(
                'examSchedule' => array(
                    'together' => true,
                ),
            );
            $criteria->compare('examSchedule.exam_type_id', $this->search['exam_type_id']);
            $mainCriteria->mergeWith($criteria);
        }

        if (!empty($this->search['exam_subject_id'])) {
            $criteria = new CDbCriteria();
            $criteria->with = array(
                'examSchedule' => array(
                    'together' => true,
                ),
                'examSchedule.examScheduleItems' => array(
                    'together' => true,
                    'select' => false,
                ),
            );
            $criteria->compare('examScheduleItems.exam_subject_id', $this->search['exam_subject_id']);
            $mainCriteria->mergeWith($criteria);
        }

        if (!empty($this->search['department'])) {
            $criteria = new CDbCriteria();
            $criteria->with = array(
                'account' => array(
                    'together' => true,
                ),
                'account.accountProfile' => array(
                    'together' => true,
                ),
            );
            $criteria->compare('accountProfile.department', $this->search['department'], true);
            $mainCriteria->mergeWith($criteria);
        }

        $mainCriteria->with = array(
            'account' => array(
                'together' => true,
            ),
            'account.accountProfile' => array(
                'together' => true,
            ),
            'examSchedule' => array(
                'together' => true,
            ),
        );
        $mainCriteria->addCondition('accountProfile.email IS NOT NULL');
        $mainCriteria->compare('is_sms', self::YES);
        $mainCriteria->group = 'accountProfile.email';

        return new CActiveDataProvider(new ExamApplication, array(
            'criteria' => $mainCriteria,
        ));
    }

}
