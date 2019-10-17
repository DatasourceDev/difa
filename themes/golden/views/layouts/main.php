<?php $this->beginContent('/layouts/html'); ?>
<header>
    <div class="container">
        <?php $this->renderPartial('/layouts/language'); ?>
        <div class="logo">
            <?php echo CHtml::link(CHtml::image(WebConfigurationForm::getLogoUrl()), Yii::app()->homeUrl); ?>
        </div>
        <div class="title">
            <?php if (Yii::app()->language === 'th'): ?>
                <h1 class="fancy"><?php echo Configuration::getKey('web_title', 'สถาบันการต่างประเทศเทวะวงศ์วโรปการ'); ?></h1>
                <h2 class="fancy"><?php echo Configuration::getKey('web_title_en', 'Devawongse Varopakarn Institute of Foreign Affairs'); ?></h2>
            <?php else: ?>
                <h1 class="fancy"><?php echo Configuration::getKey('web_title', 'สถาบันการต่างประเทศเทวะวงศ์วโรปการ'); ?></h1>
                <h2 class="fancy"><?php echo Configuration::getKey('web_title_en', 'Devawongse Varopakarn Institute of Foreign Affairs'); ?></h2>
            <?php endif; ?>
        </div>
    </div>
</header>
<?php $this->renderPartial('/layouts/menu'); ?>
<main>
    <div id="page" class="container">
        <?php echo $content; ?>
    </div>
</main>
<footer>
    <div class="container">
        <div class="text-center">
            <small>Copyright &copy; 2012-<?php echo date('Y'); ?> Devawongse Varopakarn Institute of Foreign Affairs (DVIFA) All rights reserved.</small>
        </div>
    </div>
</footer>

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
    <h3 class="modal-title fancy">Message Alert</h3>
</div>
<div class="modal-body">
    <?php if (Yii::app()->user->hasFlash('success')): ?>
        <?php echo Yii::app()->user->getFlash('success'); ?>
    <?php endif; ?>
</div>
<div class="modal-footer">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'Close',
        'htmlOptions' => array(
            'data-dismiss' => 'modal',
        ),
    ));
    ?>
</div>
<?php $this->endWidget(); ?>
<?php $this->endContent(); ?>