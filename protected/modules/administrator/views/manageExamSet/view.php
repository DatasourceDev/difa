<?php

$this->beginContent('/manageExamSet/_layout', array(
    'model' => $model,
));
?>
<?php

$this->widget('booster.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
        array(
            'label' => 'ประเภทการสอบ',
            'name' => 'examType.name',
        ),
        array(
            'label' => 'ทักษะในการสอบ',
            'name' => 'examSubject.name',
        ),
        array(
            'label' => 'หัวข้อในการสอบ',
            'name' => 'examSubjectTopic.name',
        ),
        'exam_num',
        'exam_year',
    ),
));
?>
<?php $this->endContent(); ?>