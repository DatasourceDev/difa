<?php

class ExcelStyle {

    public static function defaultStyle() {
        return array(
            'font' => array(
                'name' => 'TH SarabunPSK',
                'size' => 16,
            ),
        );
    }

    public static function tableHeaderCell() {
        return array(
            'font' => array(
                'bold' => true,
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
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
        );
    }

    public static function tableCell() {
        return array(
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
        );
    }

    public static function tableCellNoneBorderLeft() {
       return array(
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
                   'style' => PHPExcel_Style_Border::BORDER_NONE,
               ),
               'right' => array(
                   'color' => array(
                       'rgb' => '000000',
                   ),
                   'style' => PHPExcel_Style_Border::BORDER_THIN,
               ),
           ),
       );
    }

    public static function tableCellNoneBorderRight() {
       return array(
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
                   'style' => PHPExcel_Style_Border::BORDER_NONE,
               ),
           ),
       );
    }
    public static function alignCenter() {
        return array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
        );
    }

    public static function fontBold() {
        return array(
            'font' => array(
                'bold' => true,
            ),
        );
    }

}
