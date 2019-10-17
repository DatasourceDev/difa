<?php

class AjaxViewController extends AdministratorController {

    public function actionAccountInfo($id) {
        $model = Account::model()->findByPk($id);

        /* ประวัติการสอบ */
        $criteria = new CDbCriteria();
        $criteria->with = array(
            'examSchedule' => array(
                'together' => true,
            ),
        );
        $criteria->compare('t.account_id', $model->id);
        $criteria->order = 'examSchedule.db_date DESC';
        $applications = ExamApplication::model()->scopeValid()->findAll($criteria);

        $this->renderPartial('accountInfo', array(
            'model' => $model,
            'applications' => $applications,
        ));
    }

}
