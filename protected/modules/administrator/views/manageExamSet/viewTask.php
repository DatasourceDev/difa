<?php
$this->beginContent('/manageExamSet/_layout', array(
    'model' => $model,
));
?>
<?php if ($model->is_grade_set === ExamSet::YES): ?>
<br/>
<div class="alert alert-info">ไม่สามารถเพิ่ม Task ได้ เนื่องจาก ชุดข้อสอบนี้ถูกตั้งค่าการให้คะแนนเป็น <strong>กำหนดระดับโดยตรง</strong></div>
<?php else: ?>
    <div class="row">
        <div class="col-sm-8">
            <h4 class="fancy">รายการ Task</h4>
            <?php if (!$model->getIsTaskReady()): ?>
                <div class="alert alert-danger">
                    <span class="glyphicon glyphicon-exclamation-sign"></span> กรุณาบันทึกเฉลยข้อสอบให้เรียบร้อย
                </div>
            <?php endif; ?>
            <?php if (count($tasks)): ?>
                <?php $form = $this->beginWidget('CodeskActiveForm'); ?>
                <?php $count = 0; ?>
                <?php foreach ($tasks as $task): ?>
                    <div class="well well-sm clearfix">
                        <div class="fancy">
                            <span class="text-bold">Task #<?php echo CHtml::value($task, 'task_no'); ?></span>
                            ชนิดข้อสอบ : <span class="text-success"><?php echo CHtml::value($task, 'examQuestionMethod.name'); ?></span> / 
                            จำนวน : <span class="text-success"><?php echo CHtml::value($task, 'task_num', 0); ?></span> ข้อ
                            <div class="pull-right">
                                <?php echo CHtml::link(Helper::glyphicon('trash'), array('taskDelete', 'id' => $model->id, 'task_no' => $task->task_no), array('onclick' => 'return confirm("ต้องการลบรายการนี้ ?")')); ?>
                            </div>
                        </div>
                        <?php if ($task->isAutoCheck): ?>
                            <?php foreach ($task->examSetTaskItems as $item): ?>
                                <div class="exam-task-item">
                                    <label><?php echo $count + 1; ?></label>
                                    <?php echo CHtml::textField('answer[' . $item->task_no . '][' . $item->order_no . ']', CHtml::value(Yii::app()->request->getPost('answer'), $item->task_no . '.' . $item->order_no, $item->answer), array('size' => 5, 'class' => 'text-center answer-field', 'maxlength' => 1)); ?>
                                </div>
                                <?php $count++; ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="text-center">
                                <span class="primary">-- ตรวจคะแนนโดยเจ้าหน้าที่ --</span>
                            </div>
                            <?php $count += $task->task_num; ?>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
                <div class="btn-toolbar">
                    <?php
                    $this->widget('booster.widgets.TbButton', array(
                        'label' => 'บันทึกข้อมูลข้อสอบ',
                        'buttonType' => 'submit',
                        'context' => 'primary',
                        'htmlOptions' => array(
                            'class' => 'pull-right',
                        ),
                    ));
                    ?>
                </div>
                <?php $this->endWidget(); ?>
            <?php else: ?>
                <div class="well well-sm text-center">ยังไม่มีรายการใดๆ</div>
            <?php endif; ?>
        </div>
        <div class="col-sm-4">
            <?php
            $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
            ));
            ?>
            <h4 class="fancy">เพิ่มข้อมูล Task</h4>
            <div class="well well-sm">
                <?php
                echo $form->dropDownListGroup($newTask, 'exam_question_method_id', array(
                    'widgetOptions' => array(
                        'data' => CHtml::listData(ExamQuestionMethod::model()->findAll(), 'id', 'name'),
                        'htmlOptions' => array(
                            'prompt' => '(กรุณาเลือก)',
                        ),
                    ),
                ));
                ?>
                <?php echo $form->textFieldGroup($newTask, 'task_num'); ?>
                <div class="btn-toolbar">
                    <?php
                    $this->widget('booster.widgets.TbButton', array(
                        'label' => 'เพิ่ม Task',
                        'buttonType' => 'submit',
                        'context' => 'primary',
                        'htmlOptions' => array(
                            'class' => 'pull-right',
                        ),
                    ));
                    ?>
                </div>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
<?php endif; ?>
<?php $this->endContent(); ?>