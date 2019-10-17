<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'id' => 'update-info-frm',
    'type' => 'horizontal',
    'action' => array('updateInfo', 'id' => $model->id),
        ));
?>
<div class="modal-header">
    <h4 class="modal-title">แก้ไขข้อมูลใบสมัคร</h4>
</div>
<div class="modal-body">
    <div class="form-group">
        <label class="col-sm-3 control-label">Fullname <span class="required">*</span></label>
        <div class="col-sm-9">
            <div class="row">
                <div class="col-sm-2">
                    <?php
                    echo $form->textField($model, 'title_en', array(
                        'class' => 'form-control',
                        'placeholder' => 'Title',
                    ));
                    ?>
                </div>
                <div class="col-sm-3">
                    <?php
                    echo $form->textField($model, 'firstname_en', array(
                        'class' => 'form-control',
                        'placeholder' => 'Firstname',
                    ));
                    ?>
                </div>
                <div class="col-sm-3">
                    <?php
                    echo $form->textField($model, 'midname_en', array(
                        'class' => 'form-control',
                        'placeholder' => 'Middlename',
                    ));
                    ?>
                </div>
                <div class="col-sm-4">
                    <?php
                    echo $form->textField($model, 'lastname_en', array(
                        'class' => 'form-control',
                        'placeholder' => 'Lastname',
                    ));
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-3 control-label">ชื่อ-นามสกุล <span class="required">*</span></label>
        <div class="col-sm-9">
            <div class="row">
                <div class="col-sm-2">
                    <?php
                    echo $form->textField($model, 'title_th', array(
                        'class' => 'form-control',
                        'placeholder' => 'คำนำหน้า',
                    ));
                    ?>
                </div>
                <div class="col-sm-3">
                    <?php
                    echo $form->textField($model, 'firstname_th', array(
                        'class' => 'form-control',
                        'placeholder' => 'ชื่อ',
                    ));
                    ?>
                </div>
                <div class="col-sm-3">
                    <?php
                    echo $form->textField($model, 'midname_th', array(
                        'class' => 'form-control',
                        'placeholder' => 'ชื่อกลาง',
                    ));
                    ?>
                </div>
                <div class="col-sm-4">
                    <?php
                    echo $form->textField($model, 'lastname_th', array(
                        'class' => 'form-control',
                        'placeholder' => 'นามสกุล',
                    ));
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php
    echo $form->textFieldGroup($model, 'department', array(
        'prepend' => $this->module->getImage('lang_en'),
    ));
    ?>
    <?php
    echo $form->textFieldGroup($model, 'department_th', array(
        'prepend' => $this->module->getImage('lang_th'),
    ));
    ?>
    <?php
    echo $form->textFieldGroup($model, 'office', array(
        'prepend' => $this->module->getImage('lang_en'),
    ));
    ?>
    <?php
    echo $form->textFieldGroup($model, 'office_th', array(
        'prepend' => $this->module->getImage('lang_th'),
    ));
    ?>
</div>
<div class="modal-footer">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'บันทึกข้อมูล',
        'buttonType' => 'submit',
        'context' => 'primary',
    ));
    ?>
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'ปิด',
        'htmlOptions' => array(
            'data-dismiss' => 'modal',
        ),
    ));
    ?>    
</div>
<?php $this->endWidget(); ?>

<script type="text/javascript">
    $(document).ready(function () {
        $('#update-info-frm').submit(function () {
            var frm = $(this);
            $.post($(frm).attr('action'), $(frm).serialize(), function (data) {
                try {
                    var json = $.parseJSON(data);
                    if (json.success) {
                        $('.grid-view').yiiGridView('update');
                        $('#base-modal').modal('hide');
                    }
                } catch (e) {
                    $(frm).html($(data, 'form').html());
                }
            });
            return false;
        });
    });
</script>