<?php

class Formatter extends CFormatter {

    public $dateFormat = 'j F Y';
    public $timeFormat = 'H:i';

    public function formatTimeRange($v1, $v2) {
        if (Yii::app()->language === 'th') {
            return date('H:i', strtotime($v1)) . ' - ' . date('H:i', strtotime($v2)) . ' น.';
        }
        return date('h:i A', strtotime($v1)) . ' - ' . date('h:i A', strtotime($v2));
    }

    public function formatTimeRangeHtml($v1, $v2) {
        if (Yii::app()->language === 'th') {
            return date('H:i', strtotime($v1)) . ' น.' . '<br/>ถึง<br/> ' . date('H:i', strtotime($v2)) . ' น.';
        }
        return date('h:i A', strtotime($v1)) . '<br/>to<br/>' . date('h:i A', strtotime($v2));
    }

    public function formatTime($value) {

        if (Yii::app()->language === 'th') {
            $this->timeFormat = 'H:i น.';
        } else {
            $this->timeFormat = 'h:i A';
        }

        return parent::formatTime($value);
    }

    public function formatDateTime($d) {
        return $this->formatDate($d) . ' ' . $this->formatTime($d);
    }

    public function formatDate($d) {
        $dt = new DateTime($d);
        if (Yii::app()->language === 'th') {
            return $dt->format('j') . ' ' . self::textMonth($dt->format('n')) . ' ' . ($dt->format('Y') + 543);
        } else {
            return parent::formatDate($d);
        }
    }

    public function formatDateWithoutYear($d) {
        $dt = new DateTime($d);
        if (Yii::app()->language === 'th') {
            return $dt->format('j') . ' ' . self::textMonth($dt->format('n'));
        } else {
            return $dt->format('j') . ' ' . $dt->format('F');
        }
    }

    public function formatDateShort($d) {
        $dt = new DateTime($d);
        return $dt->format('d/m/') . ($dt->format('Y') + 543);
    }

    public function formatDateThai($d) {
        $dt = new DateTime($d);
        return $dt->format('j') . ' ' . self::textMonth($dt->format('n')) . ' ' . ($dt->format('Y') + 543);
    }

    public function formatDateText($d) {
        $dt = new DateTime($d);
        if (Yii::app()->language === 'th') {
            return self::textDay($dt->format('w')) . ' ที่ ' . $dt->format('j') . ' ' . self::textMonth($dt->format('n')) . ' ' . ($dt->format('Y') + 543);
        } else {
            return $dt->format('j') . ' ' . $dt->format('F') . ' ' . ($dt->format('Y'));
        }
    }

    public function formatMoney($d) {
        return number_format($d, 2);
    }

    public function formatMoneyRoundText($d) {
        return number_format($d) . ' ' . (Yii::app()->language === 'th' ? 'บาท' : 'Baht');
    }

    public function textDay($n) {
        switch ((int) $n) {
            case 1:
                return 'จันทร์';
            case 2:
                return 'อังคาร';
            case 3:
                return 'พุธ';
            case 4:
                return 'พฤหัสบดี';
            case 5:
                return 'ศุกร์';
            case 6:
                return 'เสาร์';
            case 0:
                return 'อาทิตย์';
        }
    }

    public function textMonth($n) {
        switch ((int) $n) {
            case 1:
                return 'มกราคม';
            case 2:
                return 'กุมภาพันธ์';
            case 3:
                return 'มีนาคม';
            case 4:
                return 'เมษายน';
            case 5:
                return 'พฤษภาคม';
            case 6:
                return 'มิถุนายน';
            case 7:
                return 'กรกฎาคม';
            case 8:
                return 'สิงหาคม';
            case 9:
                return 'กันยายน';
            case 10:
                return 'ตุลาคม';
            case 11:
                return 'พฤศจิกายน';
            case 12:
                return 'ธันวาคม';
        }
    }

    public function textMonthShort($n) {
        switch ((int) $n) {
            case 1:
                return 'ม.ค.';
            case 2:
                return 'ก.พ.';
            case 3:
                return 'มี.ค.';
            case 4:
                return 'เม.ย.';
            case 5:
                return 'พ.ค.';
            case 6:
                return 'มิ.ย.';
            case 7:
                return 'ก.ค.';
            case 8:
                return 'ส.ค.';
            case 9:
                return 'ก.ย.';
            case 10:
                return 'ต.ค.';
            case 11:
                return 'พ.ย.';
            case 12:
                return 'ธ.ค.';
        }
    }

}
