<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle = Yii::app()->name . ' - Error';
$this->breadcrumbs = array(
    'Error',
);
?>

<h2>Error <?php echo $code; ?></h2>

<div class="error">
    <?php echo CHtml::encode($message); ?>
</div>
<?php if (YII_DEBUG): ?>
    <?php echo CHtml::encode($file); ?>:<?php echo CHtml::encode($line); ?>
<?php endif; ?>