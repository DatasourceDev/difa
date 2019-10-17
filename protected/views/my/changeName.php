<?php $this->beginContent('_layout', array('model' => $model)); ?>
<div class="text-small">
    <h3><?php echo Helper::t('List of name changes', 'ประวัติการเปลี่ยนชื่อ'); ?></h3>
    <?php
    $this->widget('booster.widgets.TbGridView', array(
        'template' => '{items} {summary}',
        'dataProvider' => $dataProvider,
        'columns' => array(
            array(
                'header' => Helper::t('From', 'เปลี่ยนจาก'),
                'value' => 'CHtml::value($data,"htmlChangeFrom")',
                'type' => 'html',
                'headerHtmlOptions' => array(
                    'class' => 'text-center',
                ),
                'htmlOptions' => array(
                    'class' => 'text-center',
                ),
            ),
            array(
                'value' => 'Helper::glyphicon("arrow-right")',
                'type' => 'raw',
                'headerHtmlOptions' => array(
                    'class' => 'text-center',
                ),
                'htmlOptions' => array(
                    'class' => 'text-center',
                ),
            ),
            array(
                'header' => Helper::t('To', 'เปลี่ยนเป็น'),
                'value' => 'CHtml::value($data,"htmlChangeTo")',
                'type' => 'html',
                'headerHtmlOptions' => array(
                    'class' => 'text-center',
                ),
                'htmlOptions' => array(
                    'class' => 'text-center',
                ),
            ),
            array(
                'header' => Helper::t('Date', 'วันที่ทำรายการ'),
                'name' => 'created',
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
    ?>
    <br/><br/>
    <h3><?php echo Helper::t('List of careers', 'ประวัติการทำงาน'); ?></h3>
    <?php
    $this->widget('booster.widgets.TbGridView', array(
        'template' => '{items} {summary}',
        'dataProvider' => $workProvider,
        'columns' => array(
            array(
                'header' => Helper::t('From', 'เปลี่ยนจาก'),
                'value' => 'CHtml::value($data,"htmlChangeFrom")',
                'type' => 'html',
                'headerHtmlOptions' => array(
                    'class' => 'text-center',
                ),
                'htmlOptions' => array(
                    'class' => 'text-center',
                ),
            ),
            array(
                'value' => 'Helper::glyphicon("arrow-right")',
                'type' => 'raw',
                'headerHtmlOptions' => array(
                    'class' => 'text-center',
                ),
                'htmlOptions' => array(
                    'class' => 'text-center',
                ),
            ),
            array(
                'header' => Helper::t('To', 'เปลี่ยนเป็น'),
                'value' => 'CHtml::value($data,"htmlChangeTo")',
                'type' => 'html',
                'headerHtmlOptions' => array(
                    'class' => 'text-center',
                ),
                'htmlOptions' => array(
                    'class' => 'text-center',
                ),
            ),
            array(
                'header' => Helper::t('Date', 'วันที่ทำรายการ'),
                'name' => 'created',
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
    ?>
</div>
<?php $this->endContent(); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#frm-register').change(function () {
            initForm();
        });
        initForm();
    });

    function initForm() {
        if ($('#Profile_title_id_th').val()) {
            $('#Profile_title_id_en').val($('#Profile_title_id_th').val());
        }
        if ($('#Profile_title_id_th').val() === 'O') {
            $('#Profile_title_th').closest('.form-group').show();
        } else {
            $('#Profile_title_th').closest('.form-group').hide();
        }

        if ($('#Profile_title_id_en').val() === 'O') {
            $('#Profile_title_en').closest('.form-group').show();
        } else {
            $('#Profile_title_en').closest('.form-group').hide();
        }
    }
</script>