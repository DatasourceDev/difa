<?php

class RegisterController extends Controller {

    public function accessRules() {
        return array_merge(array(
            array(
                'allow',
                'users' => array('?'),
                'actions' => array(
                    'register',
                    'confirm',
                    'confirmComplete',
                    'createGeneralThai',
                    'createGeneralForeigner',
                    'createDiplomatThai',
                    'createDiplomatForeigner',
                    'doConfirm',
                    'resend',
                    'index',
                    'captcha',
                    'checkExistingAccount',
                    'checkExistingOfficeAccount',
                    'waitForApprove',
                    'getDepartmentList',
                    'ajaxUploadFile',
                    'processImage',
                ),
            ),
                ), parent::accessRules());
    }

    public function actions() {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
                'offset' => 5,
            ),
        );
    }

    public function actionAjaxUploadFile() {
        $upload_dir = Yii::getPathOfAlias('webroot.uploads.emp');
        $uploader = new FileUpload('uploadfile');
        $uploader->newFileName = 'draft_' . md5(time()) . '.' . $uploader->getExtension();
        $uploader->allowedExtensions = Helper::getAllowedImageExtension();
        $result = $uploader->handleUpload($upload_dir);
        if (!$result) {
            exit(CJSON::encode(array('success' => false, 'msg' => $uploader->getErrorMsg())));
        }
        echo CJSON::encode(array(
            'success' => true,
            'html' => CHtml::image(Yii::app()->baseUrl . '/uploads/emp/' . $uploader->newFileName, '', array('id' => 'preview')),
        ));
    }

    public function actionIndex($account_type_id) {
        $examType = ExamType::model()->findByAttributes(array(
            'code' => Yii::app()->request->getQuery('exam_code'),
        ));

        $accountType = AccountType::model()->findByPk($account_type_id);
        $this->render('index', array(
            'accountType' => $accountType,
            'examType' => $examType,
        ));
    }

    public function actionCreateGeneralThai() {
        Yii::app()->user->setState('current_language', 'th');
        Yii::app()->language = 'th';
        $profile = new AccountProfileGeneralThai('register');
        $profile->nationality_id = CHtml::value(CodeCountry::model()->findByAttributes(array('alpha2' => 'TH')), 'id');
        $profile->educate_country = 'ไทย';
        $profile->contact_phone_country = '+';
        $profile->contact_fax_country = '+';
        $profile->contact_mobile_country = '+';
        $this->create(1, $profile, 'createGeneralThai', 'createGeneralThai');
    }

    public function actionCreateGeneralForeigner() {
        Yii::app()->user->setState('current_language', 'en');
        Yii::app()->language = 'en';
        $profile = new AccountProfileGeneralForeigner('register');
        $profile->contact_phone_country = '+';
        $profile->contact_fax_country = '+';
        $profile->contact_mobile_country = '+';
        $this->create(2, $profile, 'createGeneralForeigner', 'createGeneralForeigner');
    }

    public function actionCreateDiplomatThai() {
        Yii::app()->user->setState('current_language', 'en');
        Yii::app()->language = 'en';
        $profile = new AccountProfileDiplomatThai('register');
        $profile->contact_fax_country = '+';
        $profile->contact_mobile_country = '+';
        $profile->nationality_id = CHtml::value(CodeCountry::model()->findByAttributes(array('alpha2' => 'TH')), 'id');
        $this->create(3, $profile, 'createDiplomatThai', 'createDiplomatThai');
    }

    public function actionCreateDiplomatForeigner() {
        Yii::app()->user->setState('current_language', 'en');
        Yii::app()->language = 'en';
        $profile = new AccountProfileDiplomatForeigner('register');
        $profile->contact_phone_country = '+';
        $profile->contact_fax_country = '+';
        $profile->contact_mobile_country = '+';
        $this->create(4, $profile, 'createDiplomatForeigner', 'createDiplomatForeigner');
    }

    public function actionCreateOfficeUser() {
        Yii::app()->user->setState('current_language', 'th');
        Yii::app()->language = 'th';
        $this->create(5, new AccountProfileOfficeUser('register'), 'createOfficeUser', 'createOfficeUser');
    }

    public function actionConfirm($id) {
        $model = Account::model()->findByPk($id);
        if ($model->isForeign) {
            Yii::app()->user->setState('current_language', 'en');
            Yii::app()->language = 'en';
        } else {
            Yii::app()->user->setState('current_language', 'th');
            Yii::app()->language = 'th';
        }
        $this->render('confirm', array(
            'model' => $model,
        ));
    }

    public function create($type, $profile, $scenario, $view) {
        $model = new Account($scenario);
        $model->account_type_id = $type;
        if ($model->getIsForeign()) {
            $model->secure_question_1 = '10';
        }
        if (Yii::app()->request->isPostRequest) {
            $model->attributes = Yii::app()->request->getPost('Account');
            $profile->attributes = Yii::app()->request->getPost(get_class($profile));
            $profile->account_id = 0;

            $valid = $profile->validateRegister() & $model->validate();
            $model->cProfile = $profile;


            if (!Yii::app()->request->isAjaxRequest && $valid && $model->save(false)) {
                $profile->account_id = $model->id;
                $profile->save(false);

                /* ตรวจเงื่อนไขของต่างประเทศ */
                if ($model->accountType->isForeigner) {
                    $criteria = new CDbCriteria();
                    $criteria->with = array(
                        'account' => array(
                            'together' => true,
                        ),
                    );
                    $criteria->compare('t.birth_date', $profile->birth_date);
                    $criteria->compare('t.nationality_id', $profile->nationality_id);
                    $criteria->compare('account.status', Account::STATUS_ACTIVED);
                    $criteria->compare('account.id', '<>' . $model->id);
                    $found = AccountProfileDiplomatForeigner::model()->count($criteria);
                    if (!$found) {
                        $found = AccountProfileGeneralForeigner::model()->count($criteria);
                    }
                    if ($found) {
                        $this->redirect(array('waitForApprove', 'id' => $model->id));
                    }
                }
                $this->redirect(array('resend', 'id' => $model->id));
            }
        }
        $this->render($view, array(
            'model' => $model,
            'profile' => $profile,
        ));
    }

    public function actionResend($id) {
        $model = Account::model()->findByPk($id);
        $model->confirmation_code = str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);
        $model->save();
        Mailer::sendConfirmation($model->getProfile()->contact_email, array(
            'data' => array(
                'model' => $model,
            ),
        ));
        Yii::app()->user->setFlash('success', 'We have sent confirmation by email to you. Please check your inbox.');
        $this->redirect(array('confirm', 'id' => $model->id));
    }

    public function actionDoConfirm($id, $c) {
        $model = Account::model()->findByPk($id);
        if ($model->confirm($c)) {
            Yii::app()->user->setFlash('success', 'Your are now confirmed as a DIFA TES member.');
            $this->redirect(array('confirmComplete', 'id' => $model->id));
        } else {
            Yii::app()->user->setFlash('success', 'Invalid comfirmation code !! Please try again.');
        }
        $this->redirect(array('site/index'));
    }

    public function actionConfirmComplete($id) {
        $model = Account::model()->findByPk($id);
        $this->render('confirmComplete', array(
            'model' => $model,
        ));
    }

    public function actionCheckExistingAccount() {
        $model = new Account('checkExistingAccount');
        $data = Yii::app()->request->getQuery('data');
        $account = $model->checkExistingAccount($data);
        if ($account !== false) {
            $this->renderPartial('checkExistingAccount', array(
                'account' => $account,
            ));
        } else {
            echo 'OK';
        }
    }

    public function actionCheckExistingOfficeAccount($entry_code) {
        $model = Account::model()->findByAttributes(array(
            'entry_code' => $entry_code,
            'is_office_user' => Account::YES,
        ));
        if ($model) {
            $this->renderPartial('checkExistingOfficeAccount', array(
                'model' => $model,
            ));
        } else {
            $model = Account::model()->findByAttributes(array(
                'entry_code' => $entry_code,
                'is_staff_user' => Account::YES,
            ));
            if ($model) {
                $this->renderPartial('checkExistingOfficeAccount', array(
                    'model' => $model,
                ));
            } else {
                echo 'OK';
            }
        }
    }

    public function actionWaitForApprove($id) {
        $model = Account::model()->findByPk($id);
        $this->render('waitForApprove', array(
            'model' => $model,
        ));
    }

    public function actionGetDepartmentList() {
        $id = Yii::app()->request->getQuery('id');
        if (isset($id)) {
            $department = CodeDepartment::model()->findByPk($id);
            echo CJSON::encode($department->getSelect2Item());
        } else {
            $work_office_type = Yii::app()->request->getQuery('work_office_type');
            echo CJSON::encode(CodeDepartment::model()->withIn($work_office_type)->sortBy('department_type_id DESC, id')->findAllForSelect2());
        }
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
