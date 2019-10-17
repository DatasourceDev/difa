<?php

class IncomeOverviewController extends AdministratorController {

    public function actionIndex($year = null) {
        $year = $year ? $year : date('Y');
        $model = new Income('search');
        $model->unsetAttributes();
        $model->year = $year;
        $model->attributes = Yii::app()->request->getQuery('Income');
        $dataProvider = $model->sortBy('income_date DESC')->search();
        $dataProvider->pagination->pageSize = Configuration::getKey('grid_display_row');


        $criteria = new CDbCriteria();
        $criteria->group = 'income_type_id';
        $items = $model->monthly()->findAll($criteria);
        $incomes = array();
        foreach ($items as $item) {
            for ($i = 1; $i <= 12; $i++) {
                if (isset($incomes[$i][$item->income_type_id])) {
                    $incomes[$i][$item->income_type_id] += $item->{'m' . $i};
                } else {
                    $incomes[$i][$item->income_type_id] = $item->{'m' . $i};
                }
            }
            if (isset($incomes['y'][$item->income_type_id])) {
                $incomes['y'][$item->income_type_id] += $item->y;
            } else {
                $incomes['y'][$item->income_type_id] = $item->y;
            }
        }

        $summary = new Income;
        $summary->unsetAttributes();
        $summary->year = $year;
        $incomeSummary = $summary->summary()->find();

        $months = array();
        for ($i = 1; $i <= 12; $i++) {
            $months[] = Yii::app()->format->textMonthShort($i);
        }

        $incomeTypes = IncomeType::model()->findAll();


        $series = array();
        foreach ($incomeTypes as $incomeType) {
            $data = array();
            for ($i = 1; $i <= 12; $i++) {
                $data[] = (float) CHtml::value($incomes, $i . '.' . $incomeType->id, 0);
            }
            $series[] = array(
                'name' => CHtml::value($incomeType, 'name'),
                'data' => $data,
            );
        }

        $json = array(
            'title' => array('text' => 'สรุปรายรับประจำปี ' . ($model->year + 543)),
            'xAxis' => array(
                'categories' => $months,
            ),
            'yAxis' => array(
                'title' => array('text' => 'รายรับ')
            ),
            'series' => $series,
            'credits' => array(
                'enabled' => false,
            ),
        );

        $this->render('index', array(
            'model' => $model,
            'dataProvider' => $dataProvider,
            'incomes' => $incomes,
            'incomeSummary' => $incomeSummary,
            'incomeTypes' => $incomeTypes,
            'json' => CJSON::encode($json),
        ));
    }

}
