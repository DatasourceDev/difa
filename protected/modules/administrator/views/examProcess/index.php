<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'นำเข้าข้อมูลกระดาษคำตอบ',
    'headerIcon' => 'upload',
));
?>
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'type' => 'horizontal',
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
    ),
        ));
?>
<?php
echo $form->fileFieldGroup($model, 'omr_file', array(
    'widgetOptions' => array(
    ),
    'hint' => 'ไฟล์นามสกุล (.zip) เท่านั้น',
));
?>
<div class="form-group" >
    <div class="col-md-9 col-md-offset-3">
        <div id="ajax-result"></div>
        <div id="ajax-load-box" style="display:none;">
            <?php echo CHtml::image($this->module->assetUrl . '/images/ajax-loader.gif'); ?>
            <div>กำลังตรวจสอบไฟล์ กรุณารอสักครู่...</div>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="col-md-9 col-md-offset-3">
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'label' => 'อัพโหลดไฟล์',
            'icon' => 'upload',
            'buttonType' => 'submit',
            'context' => 'primary',
            'htmlOptions' => array(
                'id' => 'btn-upload',
                'disabled' => true,
            ),
        ));
        ?>
    </div>
</div>

<?php $this->endWidget(); ?>
<?php $this->endWidget(); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $("input[type='file']").bind('change', function () {
            $('#ajax-result').hide();
            $('#ajax-load-box').show();
            for (var i = 0; i < this.files.length; i++) {
                var name = this.files[i].name;
                var size = this.files[i].size;
                var type = this.files[i].type;
                var lastModified = this.files[i].lastModifiedDate;
                $.post('<?php echo $this->createUrl('checkFileName'); ?>', {name: name}, function (data) {
                    $('#ajax-result').html(data.comment);
                    if (data.result) {
                        $('#btn-upload').prop('disabled', false);
                    } else {
                        $('#btn-upload').prop('disabled', true);
                    }
                    $('#ajax-load-box').hide();
                    $('#ajax-result').show();
                }, 'json');
            }
        });
    });
</script>