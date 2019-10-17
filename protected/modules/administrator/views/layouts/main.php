<?php $this->beginContent('administrator.views.layouts.html'); ?>
<?php
$this->widget('booster.widgets.TbNavbar', array(
    'brand' => 'DVIFA Control Panel',
    'brandUrl' => $this->module->homeUrl,
    'fluid' => true,
    'fixed' => false,
    'htmlOptions' => array(
        'class' => 'fancy',
    ),
    'items' => array(
        array(
            'class' => 'booster.widgets.TbMenu',
            'type' => 'navbar',
            'encodeLabel' => false,
            'items' => array(
                require('modules/exam.php'),
                require('modules/storage.php'),
                require('modules/expenditure.php'),
                require('modules/report.php'),
                require('modules/web.php'),
                require('modules/admin.php'),
                require('modules/debug.php'),
            ),
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
                            'label' => 'ออกจากระบบ',
                            'url' => array('home/logout'),
                            'linkOptions' => array(
                                'onclick' => '$.fn.idleTimeout().logout();',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
));
?>
<div id="page">
    <div class="container">
        <?php if (!Yii::app()->user->isGuest && Yii::app()->user->model->is_legacy): ?>
            <div class="container" style="margin-top:15px;">
                <div class="row">
                    <div class="alert alert-danger">
                        <?php echo Helper::glyphicon('exclamation-sign'); ?> เพื่อความปลอดภัยที่ดียิ่งขึ้น กรุณาอัพเดทรหัสผ่านของคุณ <?php echo CHtml::link('[คลิ๊กที่นี่]', array('manageUser/update', 'id' => Yii::app()->user->id)); ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php echo $content; ?>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $(document).idleTimeout({
            redirectUrl: '<?php echo $this->createUrl('home/logout'); ?>' // redirect to this url. Set this value to YOUR site's logout page.
        });
    });
</script>
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

<script type="text/javascript">
   $(document).ready(function () {
        $(".colorpicker-element").attr("autocomplete", "off");
   });
</script>