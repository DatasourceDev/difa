<?php

class Helper {

 const MSG_ERROR = '';
 const MSG_SAVED = 'Your data has been saved successfully.';
 const MSG_DELETED = 'Your data has been deleted successfully.';
 const MSG_TH_SAVED = 'บันทึกข้อมูลเรียบร้อย';
 const MSG_TH_DELETED = 'ลบข้อมูลเรียบร้อย';

 public static function tis($str) {
  return iconv('UTF-8', 'TIS-620//TRANSLIT', $str);
 }

 public static function wordwrap($string, $width = 10, $break = "<br/>", $cut = true) {
  if ($cut) {
   // Match anything 1 to $width chars long followed by whitespace or EOS,
   // otherwise match anything $width chars long
   $search = '/(.{1,' . $width . '})(?:\s|$)|(.{' . $width . '})/uS';
   $replace = '$1$2' . $break;
  } else {
   // Anchor the beginning of the pattern with a lookahead
   // to avoid crazy backtracking when words are longer than $width
   $search = '/(?=\s)(.{1,' . $width . '})(?:\s|$)/uS';
   $replace = '$1' . $break;
  }
  return preg_replace($search, $replace, $string);
 }

 public static function getStartDate($range) {
  $components = explode(' - ', $range);
  if (isset($components[0])) {
   return $components[0];
  }
 }

 public static function exportHtml2Excel($content) {
  Yii::import('application.vendors.PHPExcel.PHPExcel.Classes.PHPExcel', true);

  $handle = tmpfile();
  $metaDatas = stream_get_meta_data($handle);
  $tmpFilename = $metaDatas['uri'];
  fwrite($handle, pack("CCC", 0xef, 0xbb, 0xbf) . $content);

  $objReader = PHPExcel_IOFactory::createReader('HTML');
  $objReader->setInputEncoding('utf-8');
  $objPHPExcel = $objReader->load($tmpFilename);

  Helper::sendFile(time() . '.xlsx');
  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
  $objWriter->save('php://output');
  fclose($handle);
  Yii::app()->end();
 }

 public static function getEndDate($range) {
  $components = explode(' - ', $range);
  if (isset($components[1])) {
   return $components[1];
  }
 }

 public static function getYearList($count = 0, $isBE = false) {
  $ret = array();
  for ($i = date('Y'); $i >= date('Y') - abs($count); $i--) {
   $ret[$i] = $isBE ? $i + 543 : $i;
  }
  return $ret;
 }

 public static function randomString($len = 8) {
  $randstr = '';
  srand((double) microtime() * 1000000);
  for ($i = 0; $i < $len; $i++) {
   $n = rand(48, 120);
   while (($n >= 58 && $n <= 64) || ($n >= 91 && $n <= 96)) {
    $n = rand(48, 120);
   }
   $randstr .= chr($n);
  }
  return $randstr;
 }

 public static function getFiscalYear($date = null) {
  $date = strtotime(isset($date) ? $date : date('Y-m-d H:i:s'));
  $year = date('Y', $date);
  $month = date('m', $date);
  if ($month > 9) {
   $year = $year + 1;
  }
  return $year;
 }

 public static function getMaxFileSize() {
  return 10 * 1024 * 1024;
 }

 public static function prettyDateRange($start, $end) {
  if (date('Y', strtotime($start)) === date('Y', strtotime($end))) {
   $year = date('Y', strtotime($start));
   return Yii::app()->format->formatDateWithoutYear($start) . ' - ' . Yii::app()->format->formatDateWithoutYear($end) . ' ' . Helper::t($year, $year + 543);
  }
  return Yii::app()->format->formatDate($start) . ' - ' . Yii::app()->format->formatDate($end);
 }

 public static function prettyDateRangeThai($start, $end) {
  $str = '';
  if (isset($start, $end)) {
   if ($start === $end) {
    $str .= 'วัน';
    $str .= '<span class="text-primary">' . (Yii::app()->format->formatDateText($start)) . '</span>';
   } else {
    $str .= 'ตั้งแต่';
    $str .= '<span class="text-primary">วัน' . (Yii::app()->format->formatDateText($start)) . '</span>';
    $str .= ' ถึง ';
    $str .= '<span class="text-primary">วัน' . (Yii::app()->format->formatDateText($end)) . '</span>';
   }
  }
  return $str;
 }

 public static function t($en, $th) {
  return Yii::app()->language === 'th' ? $th : $en;
 }

 public static function dateFirstOfMonth($m, $y) {
  $date = DateTime::createFromFormat('Y-m-d', $y . '-' . str_pad($m, 2, '0', STR_PAD_LEFT) . '-01');
  return $date->format('Y-m-01');
 }

 public static function dateLastOfMonth($m, $y) {
  $date = DateTime::createFromFormat('Y-m-d', $y . '-' . str_pad($m, 2, '0', STR_PAD_LEFT) . '-01');
  return $date->format('Y-m-t');
 }

 public static function defaultDateRange() {
  return date('Y-m-d', strtotime('first day of this month')) . ' - ' . date('Y-m-d', strtotime('last day of this month'));
 }

 public static function setLaguage($lang) {
  Yii::app()->language = $lang;
 }

 public static function setLaguageByClass($className) {
  switch ($className) {
   case 'AccountProfileGeneralThai':
    Yii::app()->setLanguage('th');
    break;
   case 'AccountProfileGeneralForeigner':
    Yii::app()->setLanguage('en');
    break;
   case 'AccountProfileDiplomatThai':
    Yii::app()->setLanguage('th');
    break;
   case 'AccountProfileDiplomatForeigner':
    Yii::app()->setLanguage('en');
    break;
   case 'AccountProfileOfficeUser':
    Yii::app()->setLanguage('th');
    break;
   default:
    Yii::app()->setLanguage('th');
    break;
  }
 }

 public static function activeLabelEx($model, $attribute, $htmlOptions = array()) {
  $realAttribute = $attribute;
  CHtml::resolveName($model, $attribute); // strip off square brackets if any
  if (!isset($htmlOptions['required'])) {
   $htmlOptions['required'] = $model->isAttributeRequired($attribute);
  }
  return CHtml::activeLabel($model, $realAttribute, $htmlOptions);
 }

 public static function htmlRequired() {
  return '<span class="required">*</span>';
 }

 public static function mdbValue($model, $attribute) {
  return CHtml::value($model, $attribute);
 }

 public static function getNextWorkDay($date, $num = 2) {
  $count = 0;
  $current = $date;
  while ($count < $num) {
   $current = date('Y-m-d', strtotime('+1 day', strtotime($current)));
   if (CodeHoliday::isWorkingDay($current)) {
    $count++;
   }
  }
  return $current;
 }

 public static function getTempPassword($length = 8) {
  $chrs = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
  $str = '';
  for ($i = 0; $i < $length; $i++) {
   $chr = $chrs[rand(0, count($chrs) - 1)];
   if (rand(0, 1)) {
    $chr = strtoupper($chr);
   }
   $str .= $chr;
  }
  return $chr;
 }

 public static function query($path, $values = array()) {
  $command = self::getSql($path, $values);
  $count = Yii::app()->db->createCommand('SELECT COUNT(*) FROM (' . $command->text . ') t')->queryScalar();
  return new CSqlDataProvider($command, array(
      'totalItemCount' => $count,
  ));
 }

 public static function excelDateToUnix($dateValue = 0) {
  return ($dateValue - 25569) * 86400;
 }

 public static function queryScalar($path, $values = array()) {
  $command = self::getSql($path, $values);
  return $command->queryScalar();
 }

 public static function queryRow($path, $values = array()) {
  $command = self::getSql($path, $values);
  return $command->queryRow();
 }

 public static function getSql($path, $values = array()) {
  $sql = file_get_contents(Yii::getPathOfAlias('application.data.sql') . DIRECTORY_SEPARATOR . $path . '.sql');
  $command = Yii::app()->db->createCommand($sql);
  $command->bindValues($values);
  return $command;
 }

 public static function getAllowedFileExtension() {
  return array(
      '7z',
      'jpg',
      'gif',
      'png',
      'doc',
      'docx',
      'xls',
      'xlsx',
      'pdf',
      'rar',
      'ppt',
      'pptx',
      'ppsx',
      'pps',
      'zip',
      'mp4',
      'ogg',
      'webm',
  );
 }

 public static function getAllowedImageExtension() {
  return array(
      'jpg',
      'jpeg',
      'gif',
      'png',
  );
 }

 public static function getAllowedDocumentExtension() {
  return array(
      'pdf',
      'doc',
      'docx',
      'jpg',
      'gif',
      'png',
  );
 }

 public static function listArray($items = array()) {
  $ret = array();
  foreach ($items as $item) {
   $ret[$item] = $item;
  }
  return $ret;
 }

 public static function glyphicon($name) {
  return '<span class="glyphicon glyphicon-' . $name . '"></span>';
 }

 public static function errorSummary(ActiveRecord $model) {
  $ret = array();
  foreach ($model->errors as $error) {
   $ret[] = implode(', ', $error);
  }
  return implode(', ', $ret);
 }

 public static function image($url, $options = array(), $ext = 'png') {
  return CHtml::image(Yii::app()->baseUrl . '/images/' . $url . '.' . $ext, '', $options);
 }

 public static function buttonUpdate($url, $options = array()) {
  $defaultOptions = array(
      'label' => 'แก้ไขข้อมูล',
      'buttonType' => 'link',
      'url' => $url,
      'context' => 'info',
      'icon' => 'edit',
  );
  $options = array_merge($defaultOptions, $options);
  Yii::app()->controller->widget('booster.widgets.TbButton', $options);
 }

 public static function buttonBack($url, $options = array()) {
  $defaultOptions = array(
      'label' => Yii::app()->language === 'th' ? 'ย้อนกลับ' : 'Back',
      'buttonType' => 'link',
      'url' => $url,
      'icon' => 'arrow-left',
  );
  $options = array_merge($defaultOptions, $options);
  Yii::app()->controller->widget('booster.widgets.TbButton', $options);
 }

 public static function buttonSubmit($label = 'บันทึกข้อมูล', $options = array()) {
  $defaultOptions = array(
      'label' => $label,
      'buttonType' => 'submit',
      'icon' => 'floppy-save',
      'context' => 'primary',
  );
  $options = array_merge($defaultOptions, $options);
  Yii::app()->controller->widget('booster.widgets.TbButton', $options);
 }

 public static function buttonModalClose($label = 'ปิด', $options = array()) {
  $defaultOptions = array(
      'label' => $label,
      'htmlOptions' => array(
          'data-dismiss' => 'modal',
      ),
  );
  $options = array_merge($defaultOptions, $options);
  Yii::app()->controller->widget('booster.widgets.TbButton', $options);
 }

 public static function htmlSignSuccess($title = 'เรียบร้อย', $icon = 'ok-sign') {
  return '<span class="icon-status text-success" title="' . $title . '">' . Helper::glyphicon($icon) . '</span>';
 }

 public static function htmlSignFail($title = 'ยังไม่เรียบร้อย', $icon = 'exclamation-sign') {
  return '<span class="icon-status text-danger" title="' . $title . '">' . Helper::glyphicon($icon) . '</span>';
 }

 public static function htmlSignInfo($title = 'กำลังดำเนินการ', $icon = 'hourglass') {
  return '<span class="icon-status text-info" title="' . $title . '">' . Helper::image($icon) . '</span>';
 }

 public static function htmlSignWarning($title = 'กำลังดำเนินการ', $icon = 'exclamation-sign') {
  return '<span class="icon-status text-danger" data-toggle="tooltip" title="' . CHtml::encode($title) . '">' . Helper::glyphicon($icon) . '</span>';
 }

 public static function number2Text($number) {
  $position_call = array("แสน", "หมื่น", "พัน", "ร้อย", "สิบ", "");
  $number_call = array("", "หนึ่ง", "สอง", "สาม", "สี่", "ห้า", "หก", "เจ็ด", "แปด", "เก้า");
  $number = $number + 0;
  $ret = "";
  if ($number == 0)
   return $ret;
  if ($number > 1000000) {
   $ret .= self::number2Text(intval($number / 1000000)) . "ล้าน";
   $number = intval(fmod($number, 1000000));
  }

  $divider = 100000;
  $pos = 0;
  while ($number > 0) {
   $d = intval($number / $divider);
   $ret .= (($divider == 10) && ($d == 2)) ? "ยี่" :
           ((($divider == 10) && ($d == 1)) ? "" :
           ((($divider == 1) && ($d == 1) && ($ret != "")) ? "เอ็ด" : $number_call[$d]));
   $ret .= ($d ? $position_call[$pos] : "");
   $number = $number % $divider;
   $divider = $divider / 10;
   $pos++;
  }
  return $ret;
 }

 public static function htmlTopic($title, $subtitle = null) {
  return '<div class="topic">' . $title . (isset($subtitle) ? ' <small>:: ' . $subtitle . '</small>' : '') . '</div>';
 }

 public static function sendFile($filename) {
  /* Redirect output to a client’s web browser (Excel2007) */
  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=UTF-8');
  //header("Content-type: application/vnd.ms-excel; charset=UTF-8");
  header('Content-Disposition: attachment;filename="' . $filename . '"');
  header('Cache-Control: max-age=0');
  header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
  header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
  header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
  header('Pragma: public'); // HTTP/1.0
 }

 public static function post($url, $params = array(), $response = 'string') {
  $postData = '';
  foreach ($params as $k => $v) {
   $postData .= $k . '=' . $v . '&';
  }
  $postData = rtrim($postData, '&');

  $ch = curl_init();

  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HEADER, false);
  if(is_array($postData)){
   curl_setopt($ch, CURLOPT_POST, count($postData));
  }
  

  curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

  $output = curl_exec($ch);

  curl_close($ch);

  switch ($response) {
   case 'json':
    return CJSON::decode($output);
   default:
    return $output;
  }
 }

}
