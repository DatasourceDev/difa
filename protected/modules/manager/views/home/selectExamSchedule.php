<?php Yii::app()->clientScript->registerCss('login', '.login-box {width:560px;}'); ?>
<div class="login-box">
    <div class="login-logo">
        <b>DVIFA</b> Test Manager
    </div><!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg text-bold fancy">กรุณาเลือกรอบสอบ</p>
        <?php
        $this->widget('booster.widgets.TbGridView', array(
            'dataProvider' => $dataProvider,
            'columns' => array(
                array(
                    'name' => 'exam_code',
                    'htmlOptions' => array(
                        'class' => 'text-center',
                    ),
                    'headerHtmlOptions' => array(
                        'class' => 'text-center',
                    ),
                ),
                array(
                    'name' => 'db_date',
                    'type' => 'date',
                    'htmlOptions' => array(
                        'class' => 'text-center',
                    ),
                    'headerHtmlOptions' => array(
                        'class' => 'text-center',
                    ),
                ),
                array(
                    'header' => 'ประเภท',
                    'name' => 'examType.name',
                    'htmlOptions' => array(
                        'class' => 'text-center',
                    ),
                    'headerHtmlOptions' => array(
                        'class' => 'text-center',
                    ),
                ),
                array(
                    'header' => 'ทักษะ',
                    'name' => 'textSkillCode',
                    'htmlOptions' => array(
                        'class' => 'text-center',
                    ),
                    'headerHtmlOptions' => array(
                        'class' => 'text-center',
                    ),
                ),
                array(
                    'class' => 'booster.widgets.TbButtonColumn',
                    'template' => '{join}',
                    'buttons' => array(
                        'join' => array(
                            'label' => 'เปิดข้อมูล',
                            'icon' => 'share',
                            'url' => 'array("joinExamSchedule","id" => $data->id)',
                        ),
                    ),
                ),
            ),
        ));
        ?>
        <div class="row">
            <div class="col-xs-4">

            </div><!-- /.col -->
            <div class="col-xs-4 col-xs-offset-4">
                <?php echo CHtml::link('Exit', array('home/logout'), array('class' => 'btn btn-danger btn-block btn-flat')); ?>
            </div><!-- /.col -->
        </div>
    </div><!-- /.login-box-body -->
</div><!-- /.login-box -->