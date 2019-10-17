<?php $this->beginContent('administrator.views.layouts.html'); ?>
<?php
$this->widget('booster.widgets.TbNavbar', array(
    'brand' => 'DVIFA Test Manager : ' . CHtml::value($this->examSchedule, 'exam_code') . ' <small>' . CHtml::value($this->examSchedule, 'textSkill') . '</small>',
    'brandUrl' => $this->module->homeUrl,
    'fluid' => true,
    'fixed' => false,
    'htmlOptions' => array(
        'class' => 'fancy navbar-green',
    ),
    'items' => array(
        array(
            'class' => 'booster.widgets.TbMenu',
            'type' => 'navbar',
            'encodeLabel' => false,
            'items' => array(),
        ),
        array(
            'class' => 'booster.widgets.TbMenu',
            'type' => 'navbar',
            'htmlOptions' => array(
                'class' => 'navbar-right',
            ),
            'items' => array(
                array(
                    'label' => Yii::app()->user->name,
                    'icon' => 'user',
                    'items' => array(
                        array(
                            'label' => 'เปลี่ยนรอบสอบ',
                            'url' => array('home/selectExamSchedule'),
                        ),
                        array(
                            'label' => 'ออกจากระบบจัดการสอบ',
                            'url' => array('home/quit'),
                        ),
                    ),
                ),
            ),
        ),
    ),
));
?>
<div id="page">
    <table style="table-layout: fixed;border-collapse: collapse;" width="100%">
        <td  style="vertical-align: top;" width="270">
            <?php $this->renderPartial('/layouts/_menu'); ?>
        </td>
        <td style="vertical-align: top;">
            <div class="container-fluid">
                <?php echo $content; ?>
            </div>
        </td>
    </table>
</div>
<?php
$this->beginWidget('booster.widgets.TbModal', array(
    'id' => 'base-modal',
));
?>
<?php $this->endWidget(); ?>

<?php
$this->beginWidget('booster.widgets.TbModal', array(
    'id' => 'alert-modal',
    'autoOpen' => Yii::app()->user->hasFlash('success'),
));
?>
<div class="modal-header">
    <h3 class="modal-title fancy">ข้อความแจ้งเตือน</h3>
</div>
<div class="modal-body">
    <?php if (Yii::app()->user->hasFlash('success')): ?>
        <?php echo Yii::app()->user->getFlash('success'); ?>
    <?php endif; ?>
</div>
<div class="modal-footer">
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
<?php $this->endContent(); ?>