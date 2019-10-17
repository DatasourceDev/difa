<?php
$showTitle = isset($showTitle) ? $showTitle : false;
?>
<?php if ($showTitle): ?>
    <h3 class="fancy">รายละเอียด</h3>
<?php endif; ?>
<?php
$this->widget('booster.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
        array(
            'label' => Helper::t('Test Code', 'ประเภทการสอบ'),
            'name' => 'exam_type_id',
            'value' => $model->examType->name,
        ),
        array(
            'label' => Helper::t('Applicants', 'จำนวนผู้สมัคร'),
            'value' => '<span class="text-danger">' . Yii::app()->format->formatNumber($model->getCountCurrentSeatPreserved()) . '</span> / ' . Yii::app()->format->formatNumber($model->max_quota),
            'type' => 'html',
        ),
        array(
            'label' => Helper::t('Applicants', 'ค่าธรรมเนียมสอบ'),
            'name' => 'register_fee',
            'type' => 'moneyRoundText',
        ),
    ),
));
?>
<?php
$this->widget('booster.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => $model->getSkillDetailArray(),
));
?>
<?php
$this->widget('booster.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
        array(
            'label' => Helper::t('Information', 'ข้อมูลเพิ่มเติม'),
            'name' => 'remark',
            'visible' => isset($model->remark),
            'template' => '<tr><th>{label}</th><td><span class="text-danger">{value}</span></td></tr>',
        ),
    ),
));
?>
    