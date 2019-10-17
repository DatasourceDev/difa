<?php

Yii::import('zii.widgets.CListView');

class CodeskListView extends CListView {

    public $summaryText = 'แสดงรายการที่ {start} - {end} จากทั้งหมด {count} รายการ';
    public $template = '{items} {pager} {summary}';
    public $emptyText = 'ไม่พบรายการใดๆ';

}
