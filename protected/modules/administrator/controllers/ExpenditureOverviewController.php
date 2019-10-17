<?php

class ExpenditureOverviewController extends AdministratorController {

    public function actionIndex($year = null) {
        $year = $year ? $year : date('Y');
        $model = new Expenditure('search');
        $model->unsetAttributes();
        $model->year = $year;
        $model->attributes = Yii::app()->request->getQuery('Expenditure');
        $dataProvider = $model->sortBy('expenditure_date DESC')->search();
        $dataProvider->pagination->pageSize = Configuration::getKey('grid_display_row');


        $criteria = new CDbCriteria();
        $criteria->group = 'expenditure_type_id';
        $items = $model->monthly()->findAll($criteria);

        $expenditures = array();
        foreach ($items as $item) {
            for ($i = 1; $i <= 12; $i++) {
                if (isset($expenditures[$i][$item->expenditure_type_id])) {
                    $expenditures[$i][$item->expenditure_type_id] += $item->{'m' . $i};
                } else {
                    $expenditures[$i][$item->expenditure_type_id] = $item->{'m' . $i};
                }
            }
            if (isset($expenditures['y'][$item->expenditure_type_id])) {
                $expenditures['y'][$item->expenditure_type_id] += $item->y;
            } else {
                $expenditures['y'][$item->expenditure_type_id] = $item->y;
            }
        }

        $summary = new Expenditure;
        $summary->unsetAttributes();
        $summary->year = $year;
        $expenditureSummary = $summary->summary()->find();

        $months = array();
        for ($i = 1; $i <= 12; $i++) {
            $months[] = Yii::app()->format->textMonthShort($i);
        }

        $expenditureTypes = ExpenditureType::model()->findAll();


        $series = array();
        foreach ($expenditureTypes as $expenditureType) {
            $data = array();
            for ($i = 1; $i <= 12; $i++) {
                $data[] = (float) CHtml::value($expenditures, $i . '.' . $expenditureType->id, 0);
            }
            $series[] = array(
                'name' => CHtml::value($expenditureType, 'name'),
                'data' => $data,
            );
        }

        $json = array(
            'title' => array('text' => 'สรุปรายจ่ายประจำปี ' . ($model->year + 543)),
            'xAxis' => array(
                'categories' => $months,
            ),
            'yAxis' => array(
                'title' => array('text' => 'รายจ่าย')
            ),
            'series' => $series,
            'credits' => array(
                'enabled' => false,
            ),
        );

        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
            'expenditures' => $expenditures,
            'expenditureSummary' => $expenditureSummary,
            'expenditureTypes' => $expenditureTypes,
            'json' => CJSON::encode($json),
        ));
    }

}
