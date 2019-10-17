<?php

class CodeskHelper {

    public static function getAllowedImageExtension() {
        return 'jpg,gif,png';
    }

    public static function getAllowedFileExtension() {
        return 'jpg,gif,png,zip,pdf,doc,docx,xls,xlsx,ppt,rar';
    }

    public static function glyphIcon($name) {
        return '<span class="glyphicon glyphicon-' . $name . '"></span>';
    }

    public static function getSeoString($raw) {
        $raw = strtolower(trim($raw));
        $raw = str_replace(' ', '-', $raw);
        $raw = preg_replace('#[^-ก-๙a-zA-Z0-9]#u', '', $raw);
        $raw = preg_replace("/-+/i", "-", $raw);
        return urlencode($raw);
    }

}
