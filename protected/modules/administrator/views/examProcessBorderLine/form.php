<div class="btn-toolbar">
    <?php
    echo Helper::buttonBack(array('index',
        'ExamApplicationExamSet' => array(
            'search' => array(
                //'exam_code' => CHtml::value($model, 'examSchedule.exam_code')
            ),
        ),
    ));
    ?>
</div>
<?php
$this->widget('booster.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
        'exam_set_id:text:ชุดข้อสอบ',
        array(
            'label' => 'ชื่อ-นามสกุล',
            'value' => CHtml::value($model, 'examApplication.account.profile.fullname'),
        ),
        array(
            'label' => 'รหัสประจำตัวสอบ',
            'value' => CHtml::value($model, 'examApplication.desk_code'),
        ),
        array(
            'label' => 'ข้อมูลดิบ',
            'value' => CHtml::value($model, 'raw_data'),
        ),
    ),
));
?>
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'type' => 'horizontal',
        ));
?>
<div class="row">
    <div class="col-sm-6">
        <h4 class="fancy">แก้ไขคะแนน</h4>
        <div class="well">
            <?php if ($model->is_update === ActiveRecord::NO): ?>
                <?php echo $form->textFieldGroup($model, 'score_update'); ?>
                <?php
                echo $form->textFieldGroup($model, 'grade_update', array(
                    'widgetOptions' => array(
                        'htmlOptions' => array(
                            'disabled' => true,
                        ),
                    ),
                ));
                ?>
            <?php else: ?>
                <div class="form-group">
                    <label class="control-label col-sm-3">คะแนน</label>
                    <div class="col-sm-9">
                        <div class="control-text"><span class="text-center" style="display:inline-block;min-width: 64px;"><?php echo CHtml::value($model, 'score'); ?></span> <?php echo Helper::glyphicon('arrow-right'); ?> <span class="text-center" style="display:inline-block;min-width: 64px;"><?php echo CHtml::value($model, 'score_update'); ?></span></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3">ระดับ</label>
                    <div class="col-sm-9">
                        <div class="control-text"><span class="text-center" style="display:inline-block;min-width: 64px;"><?php echo CHtml::value($model, 'grade'); ?></span> <?php echo Helper::glyphicon('arrow-right'); ?> <span class="text-center" style="display:inline-block;min-width: 64px;"><?php echo CHtml::value($model, 'grade_update'); ?></span></div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="form-group">
                <label class="control-label col-sm-3">ผู้ตรวจ</label>
                <div class="col-sm-9">
                    <div class="control-text"><?php echo CHtml::value($model, 'updateUser.username'); ?></div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3">สถานะ</label>
                <div class="col-sm-9">
                    <div class="control-text">
                        <?php if ($model->is_update === ActiveRecord::YES): ?>
                            อยู่ระหว่างรออนุมัติ
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-9 col-sm-offset-3">
                    <?php
                    $this->widget('booster.widgets.TbButton', array(
                        'label' => 'บันทึกข้อมูล',
                        'buttonType' => 'submit',
                        'context' => 'primary',
                        'visible' => $model->is_update === ActiveRecord::NO,
                    ));
                    ?>     
                    <?php
                    $this->widget('booster.widgets.TbButton', array(
                        'label' => 'อนุมัติ',
                        'icon' => 'ok',
                        'buttonType' => 'submit',
                        'context' => 'success',
                        'visible' => $model->is_update === ActiveRecord::YES,
                        'htmlOptions' => array(
                            'name' => 'mode',
                            'value' => 'approve',
                        ),
                    ));
                    ?>    
                    <?php
                    $this->widget('booster.widgets.TbButton', array(
                        'label' => 'ไม่อนุมัติ',
                        'icon' => 'remove',
                        'buttonType' => 'submit',
                        'context' => 'danger',
                        'visible' => $model->is_update === ActiveRecord::YES,
                        'htmlOptions' => array(
                            'name' => 'mode',
                            'value' => 'disapprove',
                        ),
                    ));
                    ?>    
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <h4 class="fancy">เกณฑ์การให้คะแนน</h4>
        <div class="grid-view" style="padding-top:0px;">
            <table class="table items table-bordered table-condensed table-striped">
                <thead>
                    <tr>
                        <th class="text-center">ระดับ</th>
                        <th class="text-center">ช่วงคะแนน</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($model->examSet->examSetGrades as $grade): ?>
                        <tr>
                            <td class="text-center"><?php echo CHtml::value($grade, 'grade'); ?></td>
                            <td class="text-center">
                                <?php echo CHtml::value($grade, 'min_score', 0); ?> 
                                <?php if ($grade->nextGrade()): ?>
                                    - <?php echo $grade->nextGrade()->min_score - 1; ?>
                                <?php else: ?>
                                    ขึ้นไป
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>
<div class="topic">ประวัติการแก้ไข</div>
<?php
$this->widget('booster.widgets.TbGridView', array(
    'dataProvider' => $auditProvider,
    'columns' => array(
        array(
            'header' => 'ชุด/รอบสอบ',
            'name' => 'exam_schedule_id',
            'value' => 'CHtml::value($data,"examSet.id") . "<div class=\"text-small text-muted\">". CHtml::value($data,"examSchedule.exam_code") . "</div>"',
            'type' => 'html',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => 'ชื่อ/รหัสประจำตัว',
            'name' => 'exam_application_id',
            'value' => 'CHtml::value($data,"examApplication.account.profile.fullname") . "<div class=\"text-small text-muted\">". CHtml::value($data,"examApplication.account.entry_code") . "</div>"',
            'type' => 'html',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => 'คะแนนก่อนตรวจ',
            'name' => 'score',
            'value' => '$data->getGradeBefore() . "<div class=\"text-small text-muted\">".$data->getScoreBefore(). "</div>"',
            'type' => 'html',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => 'คะแนนหลังตรวจ',
            'name' => 'score',
            'value' => '$data->getGradeAfter() . "<div class=\"text-small text-muted\">".$data->getScoreAfter(). "</div>"',
            'type' => 'html',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => 'สถานะ',
            'name' => 'is_approved',
            'value' => 'CHtml::value($data,"is_approved") === ActiveRecord::YES ? "<span class=\"text-success\">อนุมัติ</span>" : "<span class=\"text-danger\">ไม่อนุมัติ</span>"',
            'type' => 'html',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
            'cssClassExpression' => 'CHtml::value($data,"is_approved") === ActiveRecord::YES ? "bg-success" : "bg-danger"',
        ),
        array(
            'header' => 'ผู้ตรวจ/ผู้อนุมัติ',
            'name' => 'update_user_id',
            'value' => 'CHtml::value($data,"updateUser.username") . "<div class=\"text-small text-muted\">". CHtml::value($data,"approve.username","-"). "</div>"',
            'type' => 'html',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'header' => 'วันที่ปรับปรุงคะแนน',
            'name' => 'update_date',
            'type' => 'datetime',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
    ),
));
