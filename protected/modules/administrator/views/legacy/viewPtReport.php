<?php
$this->beginContent('_layout', array(
    'model' => $model,
    'showMenu' => false,
));
?>
<h4 class="text-center fancy">รายงาน :: PT Report</h4>
<div class="well well-sm">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'ย้อนกลับ',
        'icon' => 'arrow-left',
        'url' => array('view', 'id' => $model->id),
        'buttonType' => 'link',
    ));
    ?>
</div>
<?php $this->beginWidget('booster.widgets.TbCollapse'); ?>
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'type' => 'horizontal',
    'method' => 'get',
    'action' => array('viewPtReport', 'id' => $model->id),
        ));
?>
<div class="panel-group" id="accordion">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                    <span class="glyphicon glyphicon-search"></span> ค้นหาตามเงื่อนไข
                </a>
            </h4>
        </div>
        <div id="collapseOne" class="panel-collapse collapse">
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <?php
                        echo $form->datePickerGroup($core, 'search[room_date]', array(
                            'widgetOptions' => array(
                                'htmlOptions' => array(
                                    'placeholder' => '',
                                ),
                            ),
                            'labelOptions' => array(
                                'label' => 'วันที่สอบ',
                            ),
                        ));
                        ?>
                        <?php
                        echo $form->textFieldGroup($core, 'search[room_round]', array(
                            'widgetOptions' => array(
                                'htmlOptions' => array(
                                    'placeholder' => '',
                                ),
                            ),
                            'labelOptions' => array(
                                'label' => 'รอบสอบ',
                            ),
                        ));
                        ?>
                        <?php
                        echo $form->textFieldGroup($core, 'search[person_title]', array(
                            'widgetOptions' => array(
                                'htmlOptions' => array(
                                    'placeholder' => '',
                                ),
                            ),
                            'labelOptions' => array(
                                'label' => 'คำนำหน้า',
                            ),
                        ));
                        ?>
                        <?php
                        echo $form->textFieldGroup($core, 'search[person_name]', array(
                            'widgetOptions' => array(
                                'htmlOptions' => array(
                                    'placeholder' => '',
                                ),
                            ),
                            'labelOptions' => array(
                                'label' => 'ชื่อผู้สอบ',
                            ),
                        ));
                        ?>
                        <?php
                        echo $form->textFieldGroup($core, 'search[person_department]', array(
                            'widgetOptions' => array(
                                'htmlOptions' => array(
                                    'placeholder' => '',
                                ),
                            ),
                            'labelOptions' => array(
                                'label' => 'หน่วยงาน',
                            ),
                        ));
                        ?>
                        <?php
                        echo $form->textFieldGroup($core, 'search[room_testset]', array(
                            'widgetOptions' => array(
                                'htmlOptions' => array(
                                    'placeholder' => '',
                                ),
                            ),
                            'labelOptions' => array(
                                'label' => 'ชุดสอบ',
                            ),
                        ));
                        ?>
                    </div>
                    <div class="col-sm-6">
                        <?php
                        echo $form->textFieldGroup($core, 'DeskNumber', array(
                            'widgetOptions' => array(
                                'htmlOptions' => array(
                                    'placeholder' => '',
                                ),
                            ),
                            'labelOptions' => array(
                                'label' => 'เลขที่นั่งสอบ',
                            ),
                        ));
                        ?>
                        <?php
                        echo $form->textFieldGroup($core, 'Reading', array(
                            'widgetOptions' => array(
                                'htmlOptions' => array(
                                    'placeholder' => '',
                                ),
                            ),
                            'labelOptions' => array(
                                'label' => 'คะแนนการอ่าน',
                            ),
                        ));
                        ?>
                        <?php
                        echo $form->textFieldGroup($core, 'Listening', array(
                            'widgetOptions' => array(
                                'htmlOptions' => array(
                                    'placeholder' => '',
                                ),
                            ),
                            'labelOptions' => array(
                                'label' => 'คะแนนการฟัง',
                            ),
                        ));
                        ?>
                        <?php
                        echo $form->textFieldGroup($core, 'ScoreTotal', array(
                            'widgetOptions' => array(
                                'htmlOptions' => array(
                                    'placeholder' => '',
                                ),
                            ),
                            'labelOptions' => array(
                                'label' => 'คะแนนรวม',
                            ),
                        ));
                        ?>
                        <?php
                        echo $form->dropDownListGroup($core, 'search[sort_by]', array(
                            'widgetOptions' => array(
                                'data' => MdbNameAPList::getSortOptions(),
                                'htmlOptions' => array(
                                    'placeholder' => '',
                                ),
                            ),
                            'labelOptions' => array(
                                'label' => 'การเรียงลำดับ',
                            ),
                        ));
                        ?>
                        <?php
                        echo $form->dropDownListGroup($core, 'search[sort_direction]', array(
                            'widgetOptions' => array(
                                'data' => array(
                                    'asc' => 'น้อยไปหามาก',
                                    'desc' => 'มากไปหาน้อย',
                                ),
                                'htmlOptions' => array(
                                    'placeholder' => '',
                                ),
                            ),
                            'labelOptions' => array(
                                'label' => 'การเรียงลำดับ',
                            ),
                        ));
                        ?>
                    </div>
                </div>
                <?php
                $this->widget('booster.widgets.TbButton', array(
                    'label' => 'ค้นหา',
                    'icon' => 'search',
                    'buttonType' => 'submit',
                    'context' => 'info',
                ));
                ?>
                <?php
                $this->widget('booster.widgets.TbButton', array(
                    'label' => 'ล้างเงื่อนไข',
                    'icon' => 'refresh',
                    'buttonType' => 'link',
                    'url' => array('viewPtReport', 'id' => $model->id),
                    'context' => 'success',
                ));
                ?>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php $this->endWidget(); ?>

<?php
$this->widget('booster.widgets.TbListView', array(
    'itemView' => '_itemPt',
    'template' => $this->renderPartial('reportTemplatePt', array(), true),
    'dataProvider' => $dataProvider,
    'summaryText' => 'แสดงรายการ {start} - {end} จากทั้งหมด {count} รายการ',
    'pager' => array(
        'class' => 'CListPager',
    ),
));
?>
<?php $this->endContent(); ?>