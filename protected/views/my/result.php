<?php $this->beginContent('_layout', array('model' => $model,)); ?>
<div class="text-small">
   <?php
   $this->widget('booster.widgets.TbGridView', array(
       'template' => '{items}',
       'dataProvider' => $dataProvider,
       'columns' => array(
           array(
               'header' => 'รอบสอบ',
               'name' => 'exam_schedule_id',
               'value' => 'CHtml::value($data,"examSchedule.exam_code")',
               'headerHtmlOptions' => array(
                   'class' => 'text-center',
               ),
               'htmlOptions' => array(
                   'class' => 'text-center',
               ),
           ),
           array(
               'name' => 'desk_no',
               'headerHtmlOptions' => array(
                   'class' => 'text-center',
               ),
               'htmlOptions' => array(
                   'class' => 'text-center',
               ),
           ),
           array(
               'name' => 'examSchedule.db_date',
               'type' => 'dateText',
               'headerHtmlOptions' => array(
                   'class' => 'text-center',
               ),
               'htmlOptions' => array(
                   'class' => 'text-center',
               ),
           ),
           array(
               'header' => 'ทักษะในการสอบ',
               'value' => 'CHtml::value($data,"examSchedule.textSkill")',
           ),
           array(
               'header' => 'มารับใบรับรองได้ตั้งแต่วันที่',
               'value' => '$data->is_request ? Yii::app()->format->formatDate(Helper::getNextWorkDay(date("Y-m-d"), 3)) : ""',
           ),
           array(
               'header' => Helper::t('Detail', 'ขอใบรับรอง'),
               'class' => 'booster.widgets.TbButtonColumn',
               'headerHtmlOptions' => array(
                   'class' => 'text-center',
                   'style' => 'width:250px;',
               ),
               'template' => '{active}{inactive}',
               'buttons' => array(
                   'active' => array(
                       'label' => 'ขอใบรับรอง',
                       'url' => 'array("resultForm", "id" => CHtml::value($data, "id"))',
                       'visible' => '!$data->is_request',
                       'options' => array(
                           'class' => 'btn-ajax-post',
                           'data-grid-update' => '#data-grid',
                           //'confirm'=>'ต้องการที่จะขอใบรับรองใหม่?',
                       ),
                   ),
                   'inactive' => array(
                       'label' => 'ขอใบรับรองแล้ว',
                       'visible' => '$data->is_request',
                   ),
               ),
           ),
       ),
   ));
   ?>
</div>
<?php $this->endContent(); ?>