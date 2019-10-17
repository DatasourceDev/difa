<?php

class ShareSelect2Controller extends AdministratorController {

    public function actionListAccount($q = null, $id = null) {

        $ret = array();
        $criteria = new CDbCriteria();
        $criteria->limit = 10;
        $criteria->with = array(
            'accountProfile' => array(
                'together' => true,
            ),
        );
        $criteria->compare('t.is_disable', 0);
        if ($id) {
            $criteria->addInCondition('id', explode(',', $id));
        } else {
            $words = explode(' ', $q);
            foreach ($words as $word) {
                $wordCriteria = new CDbCriteria();
                $wordCriteria->compare('t.username', $word, true, 'OR');
                $wordCriteria->compare('accountProfile.firstname', $word, true, 'OR');
                $wordCriteria->compare('accountProfile.midname', $word, true, 'OR');
                $wordCriteria->compare('accountProfile.lastname', $word, true, 'OR');
                $wordCriteria->compare('accountProfile.department', $word, true, 'OR');
                $wordCriteria->compare('accountProfile.position', $word, true, 'OR');
                $wordCriteria->compare('accountProfile.level', $word, true, 'OR');
                $criteria->mergeWith($wordCriteria);
            }
            $criteria->order = 't.username DESC';
        }
        $items = Account::model()->scopeMember()->findAll($criteria);
        foreach ($items as $item) {
            $ret['items'][] = array(
                'id' => $item->id,
                'text' => '(' . CHtml::value($item, 'username', 'no-account') . ') ' . CHtml::value($item, 'profile.fullname'),
            );
        }
        echo CJSON::encode($ret);
    }

}
