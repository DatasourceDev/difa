<?php echo Helper::htmlTopic('จัดการข้อความ SMS', 'แสดงเนื้อหา'); ?>
<h3 class="fancy"><?php echo CHtml::value($model, 'title'); ?></h3>
<div class="text-muted">
    <small>สร้างเมื่อ : <?php echo CHtml::value($model, 'created'); ?></small>
</div>
<div class="well well-sm btn-toolbar">
    <?php echo Helper::buttonBack(array('index')); ?>
    <?php
    $this->widget('booster.wigets.TbButton', array(
        'icon' => 'edit',
        'url' => array('update', 'id' => $model->id),
        'buttonType' => 'link',
        'context' => 'info',
        'htmlOptions' => array(
            'class' => 'pull-right',
            'title' => 'แก้ไขข้อมูล',
            'data-toggle' => 'tooltip',
        ),
    ));
    ?>
    <?php
    $this->widget('booster.wigets.TbButton', array(
        'icon' => 'trash',
        'url' => array('delete', 'id' => $model->id),
        'buttonType' => 'link',
        'context' => 'danger',
        'htmlOptions' => array(
            'class' => 'pull-right',
            'title' => 'ลบข้อมูล',
            'data-toggle' => 'tooltip',
            'onclick' => 'return confirm("คุณต้องการลบข้อมูลนี้?")',
        ),
    ));
    ?>
</div>
<div style="padding:15px;"><?php echo CHtml::value($model, 'content'); ?></div>
<hr/>
<h4 class="fancy">สถานะการส่งจดหมาย</h4>
<?php
$this->widget('booster.widgets.TbButton', array(
    'label' => 'ส่งข้อความ',
    'icon' => 'envelope',
    'context' => 'info',
    'buttonType' => 'link',
    'url' => array('send', 'id' => $model->id),
));
?>
<?php
$this->widget('booster.widgets.TbGridView', array(
    'id' => 'mail-grid',
    'afterAjaxUpdate' => 'js:function() {
        window.setTimeout(function(){
            $("#mail-grid").yiiGridView("update");
        },1000);
    }',
    'dataProvider' => $dataProvider,
    'columns' => array(
        'address_from',
        'address_to',
        array(
            'name' => 'status',
            'value' => '$data->status === "1" ? $this->grid->controller->module->getImage("ajax-loader-small",array(),"gif") : $data->getTextStatus()',
            'type' => 'raw',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'name' => 'send_date',
            'type' => 'datetime',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'name' => 'msg',
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
