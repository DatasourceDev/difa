<div class="topic">Member Register</div>
<?php echo CHtml::value($examType, 'html_page'); ?>
<div class="well well-sm text-center" style="margin-top:60px;">
    <?php
    $link = array(
        1 => 'createGeneralThai',
        2 => 'createGeneralForeigner',
        3 => 'createDiplomatThai',
        4 => 'createDiplomatForeigner',
    );
    $this->widget('booster.widgets.TbButton', array(
        'label' => Helper::t('Register', 'Register'),
        'url' => array(CHtml::value($link, $accountType->id, 1),
            'account_type_id' => Yii::app()->request->getQuery('account_type_id'),
            'exam_code' => Yii::app()->request->getQuery('exam_code'),
        ),
        'buttonType' => 'link',
        'context' => 'primary',
        'size' => 'large',
    ));
    ?>
</div>
<?php
$this->beginWidget('booster.widgets.TbModal', array(
    'id' => 'register-general-modal',
));
?>
<div class="modal-header bg-primary">
    <h3 class="fancy modal-title text-center"><?php echo Yii::t('register', 'Please select'); ?></h3>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-6">
            <?php
            $this->widget('booster.widgets.TbButton', array(
                'size' => 'large',
                'label' => Yii::t('register', 'Thai'),
                'block' => true,
                'context' => 'success',
                'buttonType' => 'link',
                'url' => array(
                    'createGeneralThai',
                    'account_type_id' => Yii::app()->request->getQuery('account_type_id'),
                    'exam_code' => Yii::app()->request->getQuery('exam_code'),
                ),
            ));
            ?>
        </div>
        <div class="col-md-6">
            <?php
            $this->widget('booster.widgets.TbButton', array(
                'size' => 'large',
                'label' => Yii::t('register', 'Foreigner'),
                'block' => true,
                'context' => 'warning',
                'buttonType' => 'link',
                'url' => array(
                    'createGeneralForeigner',
                    'account_type_id' => Yii::app()->request->getQuery('account_type_id'),
                    'exam_code' => Yii::app()->request->getQuery('exam_code'),
                ),
            ));
            ?>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php if (isset($examType->infoFile->fileUrl)): ?>
    <?php
    $this->beginWidget('CodeskModal', array(
        'autoOpen' => true,
    ));
    ?>
    <div class="modal-body">
        <div class="thumbnail">
            <?php echo CHtml::link(CHtml::image($examType->infoFile->fileUrl), array('#'), array('data-dismiss' => 'modal')); ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>
<?php endif; ?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#btn-register-general').on('click', function () {
            checkButtonState($(this));
        });
        checkButtonState($('#btn-register-general'));
    });

    function checkButtonState(e) {
        if (!$(e).hasClass('active')) {
            $('#general-pane').show();
        } else {
            $('#general-pane').hide();
        }
        return false;
    }
</script>