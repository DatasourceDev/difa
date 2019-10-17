<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'type' => 'horizontal',
    'focus' => array($model, 'name'),
        ));
?>
<?php echo $form->textFieldGroup($model, 'name'); ?>
<div class="form-group">
    <label class="control-label col-sm-3">สิทธิในการเข้าถึง</label>
    <div class="col-sm-9">
        <div class="control-text">  
            <table class="table table-condensed table-bordered">
                <?php foreach ($groups as $group => $permissions): ?>
                    <tr>
                        <th class="bg-info"><?php echo CHtml::checkBox('Role[permissions_group]', $model->checkPermission($group, true), array('class' => 'chk-all', 'data-id' => $group)); ?> <?php echo Permission::getGroupName($group); ?></th>
                    </tr>
                    <?php foreach ($permissions as $permission): ?>
                        <tr class="<?php echo $model->checkPermission($permission->id) ? 'bg-success' : 'bg-normal'; ?>">
                            <td style="padding-left:25px;"><?php echo CHtml::checkBox('Role[permissionData][' . $permission->id . ']', $model->checkPermission($permission->id), array('data-parent-id' => $group)); ?> <?php echo $permission->name; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="col-md-9 col-md-offset-3">
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'label' => 'บันทึกข้อมูล',
            'buttonType' => 'submit',
            'context' => 'primary',
            'htmlOptions' => array(
                'class' => 'pull-right',
            ),
        ));
        ?>
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'label' => 'ย้อนกลับ',
            'buttonType' => 'link',
            'url' => array('index'),
        ));
        ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $('.chk-all').change(function () {
            if ($(this).prop('checked')) {
                $('input[data-parent-id="' + $(this).data('id') + '"]').prop('checked', true);
            } else {
                $('input[data-parent-id="' + $(this).data('id') + '"]').prop('checked', false);
            }
        });
    });
</script>