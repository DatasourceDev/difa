<?php

class ReportExamApproveController extends AdministratorController {

   public function actionIndex() {
      $model = new ExamApplicationExamSet('search');
      $model->unsetAttributes();
      $model->search['exam_date_range'] = Helper::defaultDateRange();
      $model->search['exam_order_type'] =0;
      $model->attributes = Yii::app()->request->getParam('ExamApplicationExamSet');
      $dataProvider = $model->search();
      $this->render('index', array(
          'model' => $model,
          'dataProvider' => $dataProvider,
      ));
   }

   private function gen_level_rule1($levels,&$result){
      foreach ($levels as $level) {
         $arr = [];
         $arr[] = $level;
         if (!in_array($arr, $result)) {
            $result[] = $arr;
         }
      }
      $result[] = array ('-');
   }

   private function gen_level_rule2($levels,&$result){
      foreach ($levels as $level) {
         $arr = [];
         $arr[] = $level;
         foreach ($levels as $level2) {
            $arr[] = $level2;
            if (!in_array($arr, $result)) {
               $result[] = $arr;
            }
            if($level2 != $levels[count($levels)-1]){
               array_pop($arr);
            }
         }
      }
      $this->sortArrayByLevel($result);
      $result[] = array ('-','-');
   }
   private function gen_level_rule3($levels,&$result){
      foreach ($levels as $level) {
         $arr = [];
         $arr[] = $level;
         foreach ($levels as $level2) {
            $arr[] = $level2;

            foreach ($levels as $level3) {
               $arr[] = $level3;
               if (!in_array($arr, $result)) {
                  $result[] = $arr;
               }
               if($level3 != $levels[count($levels)-1]){
                  array_pop($arr);
               }
            }
            if($level2 != $levels[count($levels)-1]){
               array_pop($arr);
               array_pop($arr);
            }
         }
      }
      $this->sortArrayByLevel($result);
      $result[] = array ('-','-','-');
   }

   private function gen_level_rule4($levels,&$result){
      foreach ($levels as $level) {
         $arr = [];
         $arr[] = $level;
         foreach ($levels as $level2) {
            $arr[] = $level2;

            foreach ($levels as $level3) {
               $arr[] = $level3;

               foreach ($levels as $level4) {
                  $arr[] = $level4;
                  if (!in_array($arr, $result)) {
                     $result[] = $arr;
                  }
                  if($level4 != $levels[count($levels)-1]){
                     array_pop($arr);
                  }
               }
               if($level3 != $levels[count($levels)-1]){
                  array_pop($arr);
                  array_pop($arr);
               }
            }
            if($level2 != $levels[count($levels)-1]){
               array_pop($arr);
               array_pop($arr);
               array_pop($arr);
            }
         }
      }
      $this->sortArrayByLevel($result);
      $result[] = array ('-','-','-','-');
   }

   public static function sortArrayByLevel(&$arrayToSort) {
      usort($arrayToSort, function($a, $b) {
         $levels = ['C1', 'B2+','B2','B1+','B1','Below B1'];
         $rtext = 0;
         $atext = implode(" ",$a);
         $btext = implode(" ",$b);
         foreach ($levels as $level){
            if($rtext == 0){
               $anew_array=array_count_values($a);
               $bnew_array=array_count_values($b);
               $a_cnt=0;
               $b_cnt=0;
               if (in_array($level, $a))
                  $a_cnt = $anew_array[$level];

               if (in_array($level, $b))
                  $b_cnt = $bnew_array[$level];

               if($a_cnt > 0 |  $b_cnt > 0){
                  if($a_cnt > $b_cnt)
                     $rtext = -1;
                  else if($a_cnt == $b_cnt)
                  {
                     /*กรณีที่มีจำนวน C1 เท่ากันให้เชคที่ตำแหน่ง*/

                     for($i=0;$i<count($a);$i++){
                        $avalue = $a[$i];
                        $bvalue = $b[$i];
                        if($avalue == $level & $bvalue != $level){
                           $rtext = -1;
                           break;
                        }
                        else  if($avalue != $level & $bvalue == $level){
                           $rtext = 1;
                           break;
                        }
                     }
                     //if($rtext == 0){
                     //   $apoint =0;
                     //   $bpoint =0;
                     //   for($i=0;$i<count($a);$i++){
                     //      $avalue = $a[$i];
                     //      $bvalue = $b[$i];
                     //      if($avalue == 'C1') $apoint +=6;
                     //      if($avalue == 'B2+') $apoint +=5;
                     //      if($avalue == 'B2') $apoint +=4;
                     //      if($avalue == 'B1+') $apoint +=3;
                     //      if($avalue == 'B1') $apoint +=2;
                     //      if($avalue == 'Below B1') $apoint +=1;

                     //      if($bvalue == 'C1') $bpoint +=6;
                     //      if($bvalue == 'B2+') $bpoint +=5;
                     //      if($bvalue == 'B2') $bpoint +=4;
                     //      if($bvalue == 'B1+') $bpoint +=3;
                     //      if($bvalue == 'B1') $bpoint +=2;
                     //      if($bvalue == 'Below B1') $bpoint +=1;
                     //   }

                     //   if($apoint > $bpoint)
                     //      $rtext = -1;
                     //   else if ($apoint < $bpoint)
                     //      $rtext = 1;
                     //}
                     //if($a[0] == 'C1' & $a[1] == 'C1' & $a[2] == 'B2+'  & $a[3] == 'B2'){
                     //   if($b[0] == 'C1' & $b[1] == 'C1' & $b[2] == 'B2' & $b[3] == 'B2+' ){
                     //      $t0=0;
                     //   }
                     //}
                     //if($b[0] == 'C1' & $b[1] == 'C1' & $b[2] == 'B2+'  & $b[3] == 'B2'){
                     //   if($a[0] == 'C1' & $a[1] == 'C1' & $a[2] == 'B2' & $a[3] == 'B2+' ){
                     //      $t0=0;
                     //   }
                     //}
                     /*กรณีที่ตำแหน่งเหมือนกันให้เชคที่ Priority Level*/
                     if($rtext == 0){
                        $amaxpri = 99;
                        $bmaxpri = 99;
                        $alastposision=0;
                        $blastposision=0;
                        for($i=0;$i<count($a);$i++){
                           $avalue = $a[$i];
                           $bvalue = $b[$i];

                           if($avalue != $level & $bvalue != $level){
                              $aindex = array_search($avalue,$levels);
                              $bindex = array_search($bvalue,$levels);
                              if($aindex < $amaxpri){
                                 $amaxpri = $aindex;
                                 $alastposision =$i;
                              }
                              if($bindex < $bmaxpri){
                                 $bmaxpri = $bindex;
                                 $blastposision =$i;
                              }

                           }
                        }
                        if($amaxpri < $bmaxpri){
                           $rtext = -1;
                           break;
                        }
                        else if($amaxpri > $bmaxpri){
                           $rtext = 1;
                           break;
                        }
                     }
                  }
                  else
                     $rtext = 1;
               }
            }
            else
               return $rtext;
         }
         return $rtext;
      });
   }

   private static function sortArrayByIndex(&$arrayToSort, $meta) {
      usort($arrayToSort, function($a, $b) use ($meta) {
         return ($a[$meta]-$b[$meta]) ? ($a[$meta]-$b[$meta])/abs($a[$meta]-$b[$meta]) : 0;
      });
   }

   public function actionPrint() {
      Yii::import('application.vendors.PHPExcel.PHPExcel.Classes.PHPExcel', true);

      $query = Yii::app()->request->getQuery('ExamApplicationExamSet');

      $searchordertype = CHtml::value($query, 'search.exam_order_type');
      $searchsubjectids =  CHtml::value($query, 'search.exam_subject_id');
      $searchgrade =  CHtml::value($query, 'search.grade');
      //$levelssort =[];
      //if($searchordertype == "1"){
      //   $levels = ['C1', 'B2+','B2','B1+','B1','Below B1'];
      //   $this->gen_level_rule3($levels,$levelssort);
      //}
      if (CHtml::value($query, 'exam_schedule_id')) {
         $models = array(ExamSchedule::model()->findByPk(CHtml::value($query, 'exam_schedule_id')));
      } else {
         $criteria = new CDbCriteria();
         $criteria->with = array(
             'examScheduleItems' => array(
                 'select' => false ,
                 'together' => true,
             ),
         );
         $criteria->compare('exam_type_id', CHtml::value($query, 'search.exam_type_id'));
         $criteria->compare('examScheduleItems.exam_subject_id', CHtml::value($query, 'search.exam_subject_id'));
         $criteria->compare('t.db_date', '>=' . Helper::getStartDate(CHtml::value($query, 'search.exam_date_range')));
         $criteria->compare('t.db_date', '<=' . Helper::getEndDate(CHtml::value($query, 'search.exam_date_range')));
         $models = ExamSchedule::model()->findAll($criteria);
      }

      $tempexamapps = [];
      foreach ($models as $sheetCount => $model) {
         foreach ($model->examApplications(array('scopes' => array('scopeValid'))) as $data) {
            $show = true;
            if (isset($searchgrade) && !empty($searchgrade) ) {
               $show = false;
               foreach ($model->examScheduleUniqueItems as $count => $subject) {
                  $searchgrade =  strtolower(trim($searchgrade));
                  $grade = strtolower(trim(CHtml::value($data->getExamSetBySubject($subject->examSubject->code), 'grade', '-')));
                  if (isset($searchsubjectids) && !empty($searchsubjectids) ) {
                     foreach($searchsubjectids as $searchsubjectid){
                        if($searchsubjectid == $subject-> exam_subject_id){
                           if ($grade == $searchgrade) {
                              $show = true;
                              break;
                           }
                        }
                     }

                  }
                  else{
                     if ($grade == $searchgrade) {
                        $show = true;
                        break;
                     }
                  }
               }
            }

            if (!$show)
               continue;

            if($searchordertype == "1"){
               $grades = [];
               foreach ($model->examScheduleUniqueItems as $count => $subject) {
                  $grade=CHtml::value($data->getExamSetBySubject($subject->examSubject->code), 'grade', '-');
                  $grade = str_replace("below","Below",$grade );
                  $grades[] =$grade;
               }
               if(count($model->examScheduleUniqueItems )== 1){
                  $criteria = new CDbCriteria();
                  $criteria->compare('subject_count', 1);
                  $criteria->compare('grade1', $grades[0]);
                  $orders =   ExamResultLevelOrder::model()->findAll($criteria);
                  if(count($orders) ==1){
                     $data->temp_order_index = $orders[0]->order_index;
                  }
               }
               else if(count($model->examScheduleUniqueItems )== 2){
                  $criteria = new CDbCriteria();
                  $criteria->compare('subject_count', 2);
                  $criteria->compare('grade1', $grades[0]);
                  $criteria->compare('grade2', $grades[1]);
                  $orders =   ExamResultLevelOrder::model()->findAll($criteria);
                  if(count($orders) ==1){
                     $data->temp_order_index = $orders[0]->order_index;
                  }
               }
               else if(count($model->examScheduleUniqueItems )== 3){
                  $criteria = new CDbCriteria();
                  $criteria->compare('subject_count', 3);
                  $criteria->compare('grade1', $grades[0]);
                  $criteria->compare('grade2', $grades[1]);
                  $criteria->compare('grade3', $grades[2]);
                  $orders =   ExamResultLevelOrder::model()->findAll($criteria);
                  if(count($orders) ==1){
                     $data->temp_order_index = $orders[0]->order_index;
                  }
               }
               else if(count($model->examScheduleUniqueItems )== 4){
                  $criteria = new CDbCriteria();
                  $criteria->compare('subject_count', 4);
                  $criteria->compare('grade1', $grades[0]);
                  $criteria->compare('grade2', $grades[1]);
                  $criteria->compare('grade3', $grades[2]);
                  $criteria->compare('grade4', $grades[3]);
                  $orders =   ExamResultLevelOrder::model()->findAll($criteria);
                  if(count($orders) ==1){
                     $data->temp_order_index = $orders[0]->order_index;
                  }
               }
            }

            $tempexamapps[] = $data;
         }
      }
      if($searchordertype == "1"){
         $this->sortArrayByIndex($tempexamapps, "temp_order_index");
      }

      /* comment for testing*/
      //$excel = new PHPExcel;
      //$excel->getDefaultStyle()->applyFromArray(ExcelStyle::defaultStyle());
      //$row = 1;
      //$sheet = $excel->createSheet($sheetCount);
      //$sheet->setTitle($model->exam_code);
      ////foreach ($tempexamapps as $model) {
      ////   $sheet->setCellValueByColumnAndRow(0, $row, $model->temp_order_index);
      ////   $sheet->getStyleByColumnAndRow(0, $row)->applyFromArray(array_merge(ExcelStyle::tableCell(), ExcelStyle::alignCenter()));
      ////   $row++;
      ////}

      //foreach ($levelssort as $model) {
      //   //$insert = "insert into exam_result_level_order (subject_count, grade1,grade2,grade3,grade4,order_index) values (1,'" .$model[0] . "','','',''," . ($row-1) . ");";
      //   //$insert = "insert into exam_result_level_order (subject_count, grade1,grade2,grade3,grade4,order_index) values (2,'" .$model[0] . "','" . $model[1] . "','',''," . ($row-1) . ");";
      //   //$insert = "insert into exam_result_level_order (subject_count, grade1,grade2,grade3,grade4,order_index) values (3,'" .$model[0] . "','" . $model[1] . "','" . $model[2] . "',''," . ($row-1) . ");";
      //   //$insert = "insert into exam_result_level_order (subject_count, grade1,grade2,grade3,grade4,order_index) values (4,'" .$model[0] . "','" . $model[1] . "','" . $model[2] . "','" . $model[3] . "'," . ($row-1) . ");";
      //   $sheet->setCellValueByColumnAndRow(0, $row,$insert);
      //   $sheet->getStyleByColumnAndRow(0, $row)->applyFromArray(array_merge(ExcelStyle::tableCell(), ExcelStyle::alignCenter()));
      //   $row++;
      //}
      //Helper::sendFile(time() . '.xlsx');
      //$objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
      //$objWriter->save('php://output');
      //return;

      $excel = new PHPExcel;
      $excel->getDefaultStyle()->applyFromArray(ExcelStyle::defaultStyle());
      foreach ($models as $sheetCount => $model) {
         $sheet = $excel->createSheet($sheetCount);
         $sheet->setTitle($model->exam_code);
         $teachers = array();
         $criteria = new CDbCriteria();
         $criteria->with = array(
             'examApplication' => array(
                 'together' => true,
             ),
         );
         $criteria->compare('examApplication.exam_schedule_id', $model->id);
         $criteria->group = 't.teacher_1, t.teacher_1_name';
         $teacher1s = ExamApplicationExamSet::model()->findAll($criteria);
         foreach ($teacher1s as $teacher) {
            $teachers[] = $teacher->teacher_1 . ' ' . $teacher->teacher_1_name;
         }

         $criteria = new CDbCriteria();
         $criteria->with = array(
             'examApplication' => array(
                 'together' => true,
             ),
         );
         $criteria->compare('examApplication.exam_schedule_id', $model->id);
         $criteria->group = 't.teacher_2, t.teacher_2_name';
         $teacher2s = ExamApplicationExamSet::model()->findAll($criteria);
         foreach ($teacher2s as $teacher) {
            $teachers[] = $teacher->teacher_2 . ' ' . $teacher->teacher_2_name;
         }
         $teachers = array_unique($teachers);
         sort($teachers);

         $row = 1;
         $sheet->setCellValueByColumnAndRow(0, $row, 'รายงานการตรวจข้อสอบ');
         $sheet->getStyleByColumnAndRow(0, $row)->applyFromArray(ExcelStyle::fontBold());

         $row++;
         $sheet->setCellValueByColumnAndRow(0, $row, 'รอบสอบ');
         $sheet->setCellValueByColumnAndRow(2, $row, $model->exam_code);

         $row++;
         $sheet->setCellValueByColumnAndRow(0, $row, 'ชื่อผู้ตรวจ');
         if (count($teachers)) {
            foreach ($teachers as $teacher) {
               $sheet->setCellValueByColumnAndRow(2, $row, $teacher);
               $row++;
            }
         } else {
            $row++;
         }

         $sheet->setCellValueByColumnAndRow(0, $row, 'จำนวนผู้เข้าสอบ');
         $sheet->setCellValueByColumnAndRow(2, $row, Yii::app()->format->formatNumber(CHtml::value($model, 'countValidAttendee', 0)) . ' คน');

         $row++;
         $sheet->setCellValueByColumnAndRow(0, $row, 'จำนวนผู้ขาดสอบ');
         $sheet->setCellValueByColumnAndRow(2, $row, Yii::app()->format->formatNumber(CHtml::value($model, 'countValidAttendeeNotPresent', 0)) . ' คน');


         $row++;
         $sheet->setCellValueByColumnAndRow(0, $row, 'จำนวนการตรวจข้อสอบ');
         $sheet->setCellValueByColumnAndRow(2, $row, Yii::app()->format->formatNumber(CHtml::value($model, 'countExamSetTaskItemByApplication', 0)));

         $row++;
         $row++;
         $sheet->setCellValueByColumnAndRow(0, $row, 'เลขที่สอบ');
         $sheet->getStyleByColumnAndRow(0, $row)->applyFromArray(ExcelStyle::tableHeaderCell());
         $sheet->mergeCellsByColumnAndRow(1, $row, 2, $row);
         $sheet->setCellValueByColumnAndRow(1, $row, 'ชื่อ-นามสกุล');
         $sheet->getStyleByColumnAndRow(1, $row, 2, $row)->applyFromArray(ExcelStyle::tableHeaderCell());
         $sheet->setCellValueByColumnAndRow(3, $row, 'หน่วยงาน');
         $sheet->getStyleByColumnAndRow(3, $row)->applyFromArray(ExcelStyle::tableHeaderCell());
         foreach ($model->examScheduleUniqueItems as $count => $subject) {
            $sheet->setCellValueByColumnAndRow(4 + $count, $row, CHtml::value($subject, 'examSubject.code'));
            $sheet->getStyleByColumnAndRow(4 + $count, $row)->applyFromArray(ExcelStyle::tableHeaderCell());
         }
         foreach ($tempexamapps as $data) {
            $row++;
            $sheet->setCellValueByColumnAndRow(0, $row, CHtml::value($data, 'deskNo'));
            $sheet->getStyleByColumnAndRow(0, $row)->applyFromArray(array_merge(ExcelStyle::tableCell(), ExcelStyle::alignCenter()));
            $sheet->setCellValueByColumnAndRow(1, $row, CHtml::value($data, 'title_th') . CHtml::value($data, 'firstname_th'));
            $sheet->getStyleByColumnAndRow(1, $row)->applyFromArray(ExcelStyle::tableCell());
            $sheet->setCellValueByColumnAndRow(2, $row, CHtml::value($data, 'lastname_th'));
            $sheet->getStyleByColumnAndRow(2, $row)->applyFromArray(ExcelStyle::tableCell());
            $sheet->setCellValueByColumnAndRow(3, $row, CHtml::value($data, 'department_th'));
            $sheet->getStyleByColumnAndRow(3, $row)->applyFromArray(array_merge(ExcelStyle::tableCell(), ExcelStyle::alignCenter()));
            foreach ($model->examScheduleUniqueItems as $count => $subject) {
               $grade=CHtml::value($data->getExamSetBySubject($subject->examSubject->code), 'grade', '-');
               $grade = str_replace("below","Below",$grade );
               $sheet->setCellValueByColumnAndRow(4 + $count, $row, $grade);
               $sheet->getStyleByColumnAndRow(4 + $count, $row)->applyFromArray(array_merge(ExcelStyle::tableCell(), ExcelStyle::alignCenter()));
            }
         }

         foreach (range('B', $sheet->getHighestColumn()) as $columnID) {
            $excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
         }
      }


      Helper::sendFile(time() . '.xlsx');
      $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
      $objWriter->save('php://output');
   }






}
