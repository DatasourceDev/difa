<?php

class WebSliderController extends AdministratorController {
   public function accessRules() {
      return array_merge(array(
          array(
              'allow',
              'users' => array('?'),
              'actions' => array(
                  'delete',
              ),
          ),
              ), parent::accessRules());
   }


   public function actionIndex() {
      $model = new WebSliderForm;
      $ret = array();
      $arr =  WebSlider::getSilderIndexArray();
      for ($i = 1; $i <= 20; $i++){
         $id =array_shift($arr);
         $ret[] = array(
            'id' => $id,
            'index' => $id,
            'web_slider_index' =>   WebSlider::getHtmlIndex($id),
            'web_slider_url' => Configuration::getKey('web_slider_url'. $id),
            'web_slider_is_visible' =>  WebSlider::getIsVisibleText($id),
            'image' => WebSlider::getHtmlSource($id),
         );
      }


      $data = new CArrayDataProvider( $ret ,array());
      $data->pagination->pageSize = 20;
      $this->render('index', array(
          'model' => $model,
          'dataProvider' => $data,
      ));
   }

   public function actionIndexChange($id,$newindex)
   {
      if($newindex > 0 & $newindex <= 20){
         Configuration::setKey('web_slider_index'.$id, $newindex);

         $web_slider_index1 = Configuration::getKey('web_slider_index1');
         $web_slider_index2 = Configuration::getKey('web_slider_index2');
         $web_slider_index3 = Configuration::getKey('web_slider_index3');
         $web_slider_index4= Configuration::getKey('web_slider_index4');
         $web_slider_index5 = Configuration::getKey('web_slider_index5');
         $web_slider_index6 = Configuration::getKey('web_slider_index6');
         $web_slider_index7 = Configuration::getKey('web_slider_index7');
         $web_slider_index8 = Configuration::getKey('web_slider_index8');
         $web_slider_index9= Configuration::getKey('web_slider_index9');
         $web_slider_index10 = Configuration::getKey('web_slider_index10');
         $web_slider_index11 = Configuration::getKey('web_slider_index11');
         $web_slider_index12 = Configuration::getKey('web_slider_index12');
         $web_slider_index13 = Configuration::getKey('web_slider_index13');
         $web_slider_index14= Configuration::getKey('web_slider_index14');
         $web_slider_index15 = Configuration::getKey('web_slider_index15');
         $web_slider_index16 = Configuration::getKey('web_slider_index16');
         $web_slider_index17 = Configuration::getKey('web_slider_index17');
         $web_slider_index18 = Configuration::getKey('web_slider_index18');
         $web_slider_index19= Configuration::getKey('web_slider_index19');
         $web_slider_index20 = Configuration::getKey('web_slider_index20');

         $arr = array(
            'web_slider_index'.'1'=>$web_slider_index1,
            'web_slider_index'.  '2'=> $web_slider_index2,
            'web_slider_index'.  '3'=>$web_slider_index3,
            'web_slider_index'.   '4'=> $web_slider_index4,
            'web_slider_index'.   '5'=> $web_slider_index5,
            'web_slider_index'.    '6'=>$web_slider_index6,
            'web_slider_index'.    '7'=> $web_slider_index7,
            'web_slider_index'.     '8'=>$web_slider_index8,
            'web_slider_index'.    '9'=> $web_slider_index9,
            'web_slider_index'.     '10'=> $web_slider_index10,
            'web_slider_index'.   '11'=>$web_slider_index11,
            'web_slider_index'.  '12'=> $web_slider_index12,
            'web_slider_index'.  '13'=>$web_slider_index13,
            'web_slider_index'.   '14'=> $web_slider_index14,
            'web_slider_index'.  '15'=> $web_slider_index15,
            'web_slider_index'.  '16'=>$web_slider_index16,
            'web_slider_index'.   '17'=> $web_slider_index17,
            'web_slider_index'.   '18'=>$web_slider_index18,
            'web_slider_index'.   '19'=> $web_slider_index19,
            'web_slider_index'.    '20'=> $web_slider_index20
              );

         $arr = array(
                  'web_slider_index1'=>$web_slider_index1,
                  'web_slider_index2'=> $web_slider_index2,
                  'web_slider_index3'=>$web_slider_index3,
                  'web_slider_index4'=> $web_slider_index4,
                  'web_slider_index5'=> $web_slider_index5
             );

         asort($arr);
         $keys= array_keys($arr);
         $temparr = $arr;

         $index =1;
         for ($i= 1; $i <= 20; $i++){
            $item =array_shift($keys);
            if($newindex ==strval($index) & $item != 'web_slider_index'.$id){
               $index++;
               Configuration::setKey($item, $index);
               $index++;
            }
            else if($item != 'web_slider_index'.$id){
               Configuration::setKey($item, $index);
               $index++;
            }
            else if($item == 'web_slider_index'.$id){
            }
            else{
               Configuration::setKey($item, $index);
               $index++;
            }
         }

      }

      $model = new WebSliderForm;
      $ret = array();
      $newarr =  WebSlider::getSilderIndexArray();
      for ($i = 1; $i <= 20; $i++){
         $id =array_shift($newarr);
         $ret[] = array(
            'id' => $id,
            'index' => $id,
            'web_slider_index' =>   WebSlider::getHtmlIndex($id),
            'web_slider_url' => Configuration::getKey('web_slider_url'. $id),
            'web_slider_is_visible' =>  WebSlider::getIsVisibleText($id),
            'image' => WebSlider::getHtmlSource($id),
         );
      }


      $data = new CArrayDataProvider( $ret ,array());
      $data->pagination->pageSize = 20;
      $this->render('index', array(
          'model' => $model,
          'dataProvider' => $data,
      ));
   }

   public function actionEdit($i) {
      $model = new WebSliderForm;
      $data = Yii::app()->request->getPost('WebSliderForm');
      $model->index = $i;
      $model->web_slider_index = Configuration::getKey('web_slider_index'. $i);
      $model->web_slider_url = Configuration::getKey('web_slider_url'. $i);
      $model->web_slider_is_visible =Configuration::getKey('web_slider_is_visible'. $i);
      if (isset($data)) {
         $model->web_slider_index = $data['web_slider_index'];
         $model->web_slider_url = $data['web_slider_url'];
         $model->web_slider_is_visible = $data['web_slider_is_visible'];
         if ($model->save($i)) {
            Yii::app()->user->setFlash('success', Helper::MSG_TH_SAVED);
            $this->redirect(array('index'));
         }
      }
      $this->render('form', array(
          'model' => $model,
      ));
   }

   //public function actionIndex3() {
   //   $model = new WebSlider;
   //   $data = Yii::app()->request->getPost('WebSlider');
   //   if (isset($data)) {


   //      $action=  $data['action'];
   //      $select_index=  $data['select_index'];

   //      if(isset($action)){
   //         $moveindex = (int)Configuration::getKey($select_index);
   //         $web_slider_index1 = Configuration::getKey('web_slider_index1');
   //         $web_slider_index2 = Configuration::getKey('web_slider_index2');
   //         $web_slider_index3 = Configuration::getKey('web_slider_index3');
   //         $web_slider_index4= Configuration::getKey('web_slider_index4');
   //         $web_slider_index5 = Configuration::getKey('web_slider_index5');

   //         $arr = array(
   //                  'web_slider_index1'=>$web_slider_index1,
   //                  'web_slider_index2'=> $web_slider_index2,
   //                 'web_slider_index3'=>$web_slider_index3,
   //                  'web_slider_index4'=> $web_slider_index4,
   //                   'web_slider_index5'=> $web_slider_index5
   //             );

   //         asort($arr);
   //         $keys= array_keys($arr);
   //         $temparr = $arr;

   //         if($action == 'moveup'){
   //            if($moveindex -1> 0){
   //               $latestindex = 0;
   //               arsort($arr);
   //               for ($i= 5; $i >= 1; $i--){
   //                  $item =(int)array_shift($arr);
   //                  if($item < $moveindex){
   //                     $latestindex = $i;
   //                     break;
   //                  }
   //               }
   //               $arr = $temparr;
   //               $newi =1;
   //               for ($i= 1; $i <= 5; $i++){
   //                  $item =array_shift($keys);
   //                  if ($latestindex == $i)
   //                  {
   //                     $data[$item] = $newi + 1;
   //                  }
   //                  else if ($select_index == $item)
   //                  {
   //                     $data[$item] = $newi;
   //                     $newi += 2;
   //                  }
   //                  else
   //                  {
   //                     $data[$item] = $newi;
   //                     $newi++;
   //                  }
   //               }
   //            }
   //         }
   //         else if($action == 'movedown'){
   //            if($moveindex +1<= 5 ){
   //               $latestindex = 0;
   //               for ($i= 1; $i <= 5; $i++){
   //                  $item =(int)array_shift($arr);
   //                  if($item > $moveindex){
   //                     $latestindex = $i;
   //                     break;
   //                  }
   //               }
   //               $arr = $temparr;
   //               $newi =1;
   //               for ($i= 1; $i <= 5; $i++){
   //                  $item =array_shift($keys);
   //                  if ($latestindex == $i)
   //                  {
   //                     $data[$item] = $newi;
   //                     $newi += 2;
   //                  }
   //                  else if ($select_index == $item)
   //                  {
   //                     $data[$item] = $newi + 1;
   //                  }
   //                  else
   //                  {
   //                     $data[$item] = $newi;
   //                     $newi++;
   //                  }
   //               }
   //            }
   //         }
   //      }
   //      $model->attributes = $data;
   //      $model->web_slider_index1 = $data['web_slider_index1'];
   //      $model->web_slider_index2 = $data['web_slider_index2'];
   //      $model->web_slider_index3 = $data['web_slider_index3'];
   //      $model->web_slider_index4 = $data['web_slider_index4'];
   //      $model->web_slider_index5 = $data['web_slider_index5'];
   //      $model->web_slider_url1 = $data['web_slider_url1'];
   //      $model->web_slider_url2 = $data['web_slider_url2'];
   //      $model->web_slider_url3 = $data['web_slider_url3'];
   //      $model->web_slider_url4 = $data['web_slider_url4'];
   //      $model->web_slider_url5 = $data['web_slider_url5'];
   //      $model->web_slider_is_visible1 = $data['web_slider_is_visible1'];
   //      $model->web_slider_is_visible2 = $data['web_slider_is_visible2'];
   //      $model->web_slider_is_visible3 = $data['web_slider_is_visible3'];
   //      $model->web_slider_is_visible4 = $data['web_slider_is_visible4'];
   //      $model->web_slider_is_visible5 = $data['web_slider_is_visible5'];

   //      if ($model->save()) {
   //         Yii::app()->user->setFlash('success', Helper::MSG_TH_SAVED);
   //         $this->redirect(array('index'));
   //      }
   //   }
   //   $this->render('index', array(
   //       'model' => $model,
   //   ));
   //}

   public function actionDelete($index) {
      $model = new WebSlider;
      $f = $model->remove($index);
      Yii::app()->user->setFlash('success', 'ลบรูป ' . $f . ' สำเร็จ');
   }


}
