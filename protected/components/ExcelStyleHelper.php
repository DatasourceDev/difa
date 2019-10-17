<?php

class ExcelStyleHelper {

    public $style = array();

    public function td() {
        $this->style = array_merge($this->style, array(
            'borders' => array(
                'bottom' => array(
                    'color' => array(
                        'rgb' => '000000',
                    ),
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
                'top' => array(
                    'color' => array(
                        'rgb' => '000000',
                    ),
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
                'left' => array(
                    'color' => array(
                        'rgb' => '000000',
                    ),
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
                'right' => array(
                    'color' => array(
                        'rgb' => '000000',
                    ),
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                ),
            ),
        ));
        return $this;
    }

    public function textCenter() {
        $this->style = array_merge($this->style, array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        ));
        return $this;
    }

    public function toArray() {
        return $this->style;
    }

    public function getStyle() {
        $style = new PHPExcel_Style;
        $style->applyFromArray($this->style);
        return $style;
    }

}
