<?php echo Helper::htmlTopic($this->title); ?>
<div class="row">
    <div class="col-sm-8">
        <h4 class="fancy">รายการบันทึกรายจ่าย</h4>
        <?php
        $this->beginWidget('booster.widgets.TbPanel', array(
            'title' => 'ค้นหาตามเงื่อนไข',
            'headerIcon' => 'search',
        ));
        ?>
        <?php
        $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
            'type' => 'horizontal',
            'action' => array('index'),
            'method' => 'get',
        ));
        ?>
        <?php
        echo $form->datePickerGroup($model, 'search[date_start]', array(
            'widgetOptions' => array(
                'htmlOptions' => array(
                    'id' => 'from',
                    'class' => 'form-control',
                    'placeholder' => 'ตั้งแต่วันที่',
                ),
            ),
            'labelOptions' => array(
                'label' => 'ตั้งแต่วันที่',
            ),
        ));
        ?>
        <?php
        echo $form->datePickerGroup($model, 'search[date_end]', array(
            'widgetOptions' => array(
                'htmlOptions' => array(
                    'id' => 'to',
                    'class' => 'form-control',
                    'placeholder' => 'ถึงวันที่',
                ),
            ),
            'labelOptions' => array(
                'label' => 'ถึงวันที่',
            ),
        ));
        ?>
        <?php
        echo $form->dropDownListGroup($model, 'expenditure_type_id', array(
            'widgetOptions' => array(
                'data' => CHtml::listData(ExpenditureType::model()->findAll(), 'id', 'name'),
                'htmlOptions' => array(
                    'prompt' => '(ทั้งหมด)',
                ),
            ),
        ));
        ?>
        <div class="form-group">
            <div class="col-md-9 col-md-offset-3">
                <?php
                Helper::buttonSubmit('ค้นหา', array(
                    'icon' => 'search',
                ));
                ?>    
            </div>
        </div>
        <?php $this->endWidget(); ?>
        <?php $this->endWidget(); ?>
        <?php
        $this->widget('booster.widgets.TbGridView', array(
            'dataProvider' => $dataProvider,
            'columns' => array(
                array(
                    'name' => 'expenditure_date',
                    'type' => 'date',
                    'headerHtmlOptions' => array(
                        'class' => 'text-center',
                    ),
                    'htmlOptions' => array(
                        'class' => 'text-center',
                    ),
                ),
                array(
                    'name' => 'expenditure_type_id',
                    'value' => 'CHtml::value($data,"expenditureType.name")',
                    'headerHtmlOptions' => array(
                        'class' => 'text-center',
                    ),
                    'htmlOptions' => array(
                        'class' => 'text-center',
                    ),
                ),
                array(
                    'name' => 'amount',
                    'headerHtmlOptions' => array(
                        'class' => 'text-center',
                    ),
                    'htmlOptions' => array(
                        'class' => 'text-right',
                    ),
                ),
                array(
                    'name' => 'description',
                    'headerHtmlOptions' => array(
                        'class' => 'text-center',
                    ),
                    'htmlOptions' => array(
                        'class' => 'text-center',
                    ),
                ),
                array(
                    'name' => 'comment',
                    'headerHtmlOptions' => array(
                        'class' => 'text-center',
                    ),
                    'htmlOptions' => array(
                        'class' => 'text-center',
                    ),
                ),
                array(
                    'class' => 'ext.codesk.widgets.CodeskButtonColumn',
                    'template' => '{update} {delete}',
                ),
            ),
        ));
        ?>
    </div>
    <div class="col-sm-4">
        <h4 class="fancy">บันทึกรายจ่าย</h4>
        <div class="well">
            <?php $form = $this->beginWidget('CodeskActiveForm'); ?>
            <?php echo $form->datePickerGroup($newModel, 'expenditure_date'); ?>
            <?php
            echo $form->dropDownListGroup($newModel, 'expenditure_type_id', array(
                'widgetOptions' => array(
                    'data' => CHtml::listData(ExpenditureType::model()->findAll(), 'id', 'name'),
                ),
            ));
            ?>
            <?php echo $form->textFieldGroup($newModel, 'amount'); ?>
            <?php echo $form->textAreaGroup($newModel, 'description'); ?>
            <?php echo $form->textAreaGroup($newModel, 'comment'); ?>            
            <?php
            $this->widget('booster.widgets.TbButton', array(
                'label' => 'บันทึกข้อมูล',
                'context' => 'primary',
                'buttonType' => 'submit',
            ));
            ?>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>