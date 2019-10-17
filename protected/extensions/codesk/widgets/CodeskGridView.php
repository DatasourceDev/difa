<?php

Yii::import('zii.widgets.grid.CGridView');

class CodeskGridView extends CGridView {

    public $summaryText = 'แสดงรายการที่ {start} - {end} จากทั้งหมด {count} รายการ';
    public $template = '{items} {pager} {summary}';

}
