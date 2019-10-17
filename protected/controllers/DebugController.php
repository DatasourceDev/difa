<?php

class DebugController extends Controller {

    public function accessRules() {
        return array_merge(array(
            array(
                'allow',
                'actions' => array(
                    'processImage',
                    'testPwd',
                ),
            ),
                ), parent::accessRules());
    }

    public function actionIndex() {
        $client = new SoapClient('http://demo.sukung.com/cdt-dvifa/ktb/service.wsdl');
        echo '<pre>';
        var_dump($client->__getFunctions());
    }

    public function actionAbc() {
        $es = ExamSchedule::model()->findAll();
        foreach ($es as $e) {
            $e->place_name = str_replace(array('๐', '๘', '๗'), array('0', '8', 7), $e->place_name);
            $e->save();
        }
    }

    public function actionTestPwd() {
        /*
          for ($i = 0; $i <= 100; $i++) {
          echo PasswordStorage::create_hash('94149414') . '<br/>';
          } */
        $ret = array(
            'sha1:64000:18:qSrtvJje6oqFo91/YL5QKTRabCebeka8:zBo2x+GN+7rWhKt3lYmQdr3B',
        );

        foreach ($ret as $item) {
            echo PasswordStorage::verify_password('94149414', $item) ? 'OK' : 'FAIL';
            echo '<br/>';
        }
    }

    public function actionUpdateApply() {
        $applications = ExamApplication::model()->findAll();
        foreach ($applications as $application) {
            $application->fullname_en = CHtml::value($application, 'account.profile.fullnameEn');
            $application->fullname_th = CHtml::value($application, 'account.profile.fullnameTh');
            $application->department = CHtml::value($application, 'account.profile.textDepartment');
            $application->save();
        }
        echo 'done';
    }

    public function actionTest() {
        $model = new ExamApplication('apply');
        $model->apply_type = ExamApplication::APPLY_SELF;
        $model->exam_schedule_id = 82;
        $model->exam_schedule_objective_id = 1;
        $model->account_id = 850;
        $model->checkApplyCondition();
        echo '<pre>';
        var_dump($model->errors);
    }

    public function actionProcessImage() {
        Yii::import('ext.image.Image', true);
        $data = Yii::app()->request->getPost('data');
        $filename = basename(CHtml::value($data, 'src'));
        $path = Yii::getPathOfAlias('webroot.uploads.emp') . '/' . $filename;

        $img = new Image($path);
        $img->resize((int) CHtml::value($data, 'width'), (int) CHtml::value($data, 'height'));
        $img->crop((int) CHtml::value($data, 'w'), (int) CHtml::value($data, 'h'), abs((int) CHtml::value($data, 'marginTop')), abs((int) CHtml::value($data, 'marginLeft')));
        $img->save();

        echo CJSON::encode(array(
            'html' => CHtml::image(CHtml::value($data, 'src') . '?t=' . time()),
            'filename' => $filename,
            'src' => CHtml::value($data, 'src'),
        ));
    }

}
