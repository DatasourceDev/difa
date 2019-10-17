<?php

Yii::import('zii.widgets.grid.CDataColumn');

class CodeskCounterColumn extends CDataColumn {

    public $header = 'ลำดับ';

    public function init() {

        if (isset($this->headerHtmlOptions['class'])) {
            $this->headerHtmlOptions['class'] = $this->headerHtmlOptions['class'] . ' codesk-counter-column';
        } else {
            $this->headerHtmlOptions['class'] = 'codesk-counter-column';
        }

        if (isset($this->htmlOptions['class'])) {
            $this->htmlOptions['class'] = $this->htmlOptions['class'] . ' codesk-counter-column';
        } else {
            $this->htmlOptions['class'] = 'codesk-counter-column';
        }
    }

    public function renderDataCellContent($row, $data) {
        echo (CHtml::value($this, 'grid.dataProvider.pagination.currentPage', 0) * (CHtml::value($this, 'grid.dataProvider.pagination.pageSize')) + ($row + 1));
    }

}
