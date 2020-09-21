<?php

$this->widget('booster.widgets.TbGridView', array(
    'dataProvider' => $dataProvider,
     'columns' => array(
        array(
            'header' => 'ลำดับ',
            'name' => 'web_slider_index',
            'type'=>'raw',
            'htmlOptions' => array('style' => 'width: 100px;'),
        ),
         array(
            'header' => 'รูป',
			   'name'=>'image',
			   'type'=>'html',
		   ),
         array(
            'header' => 'URL กำหนดเอง',
            'name' => 'web_slider_url',
        ),
        array(
            'header' => 'การแสดงผล',
            'name' => 'web_slider_is_visible',
        ),
        array(
            'class' => 'ext.codesk.widgets.CodeskButtonColumn',
            'template' => '{edit}',
            'buttons' => array(
                'edit' => array(
                    'label' => 'แก้ไข',
                    'icon' => 'pencil',
                    'url' => 'array("edit", "i" => CHtml::value($data, "id"))',
                ),
            ),
        ),
    ),
));
?>
<script>
   function index_change(i) {
      var newindex = $('#web_slider_index' + i).val();
      window.location = 'indexChange?id=' + i + '&newindex=' + newindex;
   }

</script>

