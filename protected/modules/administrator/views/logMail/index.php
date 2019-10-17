<?php echo Helper::htmlTopic('ข้อมูลการส่งจดหมายอิเล็กทรอนิกส์'); ?>
<div class="btn-toolbar">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'ลบรายการทั้งหมด',
        'buttonType' => 'link',
        'icon' => 'trash',
        'url' => array('deleteAll'),
        'context' => 'danger',
        'htmlOptions' => array(
            'onclick' => 'return confirm("ต้องการลบข้อมูลการส่งจดหมายอิเล็กทรอนิกส์ทั้งหมด ?")',
        ),
    ));
    ?>
</div>
<?php
$this->widget('booster.widgets.TbGridView', array(
    'dataProvider' => $dataProvider,
    'columns' => array(
        array(
            'name' => 'title',
            'value' => 'CHtml::link($data->title,array("ajaxView","id" => $data->id),array("class" => "btn-ajax-modal","data-modal-size" => "large"))',
            'type' => 'raw',
        ),
        array(
            'name' => 'mail_from',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'name' => 'mail_to',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'name' => 'created',
            'type' => 'datetime',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'name' => 'is_sent',
            'value' => '$data->htmlIsSent',
            'type' => 'html',
            'headerHtmlOptions' => array(
                'class' => 'text-center',
            ),
            'htmlOptions' => array(
                'class' => 'text-center',
            ),
        ),
        array(
            'class' => 'ext.codesk.widgets.CodeskButtonColumn',
            'template' => '{resend} {delete}',
            'buttons' => array(
                'resend' => array(
                    'label' => 'ส่งอีกครั้ง',
                    'url' => 'array("resend","id" => $data->id)',
                    'icon' => 'refresh',
                    'options' => array(
                        'class' => 'btn-ajax-post',
                        'data-grid-update' => '.grid-view',
                    ),
                ),
                'delete' => array(
                    'label' => 'ลบรายการ',
                ),
            ),
        ),
    ),
));
?>