<html>
    <head>
        <style>
            body {font-family: 'TH SarabunPSK', thsarabun;font-size:14pt;}
            table {border-collapse: collapse;}
            h3 {font-size:22pt;margin-bottom:0.5cm;}
            h4 {margin:0px;}
            .text-center {text-align: center;}
            .text-right {text-align: right;}
            a {text-decoration: none;color:#000000;}
            th, td {border:1px solid #000000;}
        </style>
    </head>
    <body>
        <div class="text-center">
            <h3>รายงานการชำระเงิน</h3>
            <h4>ตั้งแต่วันที่ <span class="text-primary"><?php echo Yii::app()->format->formatDateText($model->date_start); ?></span> ถึง <span class="text-primary"><?php echo Yii::app()->format->formatDateText($model->date_end); ?></span></h4>
        </div>
        <?php
        $this->widget('booster.widgets.TbGridView', array(
            'dataProvider' => $dataProvider,
            'columns' => array(
                array(
                    'header' => 'วันที่ชำระเงิน',
                    'name' => 'payment_date',
                    'type' => 'datetime',
                    'headerHtmlOptions' => array(
                        'class' => 'text-center',
                    ),
                    'htmlOptions' => array(
                        'class' => 'text-center',
                    ),
                ),
                array(
                    'header' => 'วันที่สอบ',
                    'name' => 'exam_schedule_id',
                    'value' => 'CHtml::value($data,"examSchedule.db_date")',
                    'type' => 'date',
                    'headerHtmlOptions' => array(
                        'class' => 'text-center',
                    ),
                    'htmlOptions' => array(
                        'class' => 'text-center',
                    ),
                ),
                array(
                    'header' => 'รอบสอบ',
                    'name' => 'exam_schedule_id',
                    'value' => 'CHtml::link(CHtml::value($data,"examSchedule.exam_code"),array("manageSchedule/view","id" => $data->exam_schedule_id))',
                    'type' => 'raw',
                    'headerHtmlOptions' => array(
                        'class' => 'text-center',
                    ),
                    'htmlOptions' => array(
                        'class' => 'text-center',
                    ),
                ),
                array(
                    'header' => 'ประเภทการสอบ',
                    'name' => 'exam_schedule_id',
                    'value' => 'CHtml::value($data,"examSchedule.examType.name")',
                    'type' => 'text',
                    'headerHtmlOptions' => array(
                        'class' => 'text-center',
                    ),
                    'htmlOptions' => array(
                        'class' => 'text-center',
                    ),
                ),
                array(
                    'header' => 'ทักษะ',
                    'value' => 'CHtml::value($data,"examSchedule.textSkillCode")',
                    'type' => 'text',
                    'headerHtmlOptions' => array(
                        'class' => 'text-center',
                    ),
                    'htmlOptions' => array(
                        'class' => 'text-center',
                    ),
                ),
                array(
                    'header' => 'วัตถุประสงค์',
                    'name' => 'exam_objective_id',
                    'value' => 'CHtml::value($data,"textObjective")',
                    'type' => 'text',
                ),
                array(
                    'header' => 'เลขที่นั่งสอบ',
                    'name' => 'desk_no',
                    'value' => 'CHtml::value($data,"deskNumber")',
                    'headerHtmlOptions' => array(
                        'class' => 'text-center',
                    ),
                    'htmlOptions' => array(
                        'class' => 'text-center',
                    ),
                ),
                array(
                    'header' => 'ชื่อ-นามสกุล',
                    'name' => 'member_id',
                    'value' => 'CHtml::value($data,"fullname_th")',
                    'type' => 'raw',
                ),
                array(
                    'header' => 'หน่วยงาน',
                    'name' => 'department_th',
                    'value' => 'CHtml::value($data,"department_th")',
                    'type' => 'raw',
                ),
                array(
                    'header' => 'ค่าธรรมเนียม',
                    'value' => 'CHtml::value($data,"examSchedule.register_fee")',
                    'headerHtmlOptions' => array(
                        'class' => 'text-center',
                    ),
                    'htmlOptions' => array(
                        'class' => 'text-right',
                    ),
                ),
                array(
                    'header' => 'เลขที่ใบเสร็จ',
                    'value' => 'CHtml::value($data,"receipt") ? CHtml::link(CHtml::value($data,"receipt.doc_name"),array("reportReceipt/print","items" =>  CHtml::value($data,"receipt.id")),array("target" => "_blank")) : ""',
                    'type' => 'raw',
                    'headerHtmlOptions' => array(
                        'class' => 'text-center',
                    ),
                    'htmlOptions' => array(
                        'class' => 'text-center',
                    ),
                ),
            ),
        ));
        ?>
    </body>
</html>