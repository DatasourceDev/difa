<?php echo Helper::htmlTopic('ระบบรายงาน', 'ใบเสร็จรับเงิน'); ?>
<?php
$this->widget('booster.widgets.TbMenu', array(
    'type' => 'tabs',
    'items' => array(
        array(
            'label' => 'ประเภทรายบุคคล',
            'icon' => 'user',
            'url' => array('index'),
            'active' => $this->action->id === 'index',
        ),
        array(
            'label' => 'รายชื่อผู้รับเงิน',
            'icon' => 'th',
            'url' => array('recipient'),
            'active' => $this->action->id === 'recipient',
        ),
    ),
));
?>
<br/>
<?php echo $content; ?>