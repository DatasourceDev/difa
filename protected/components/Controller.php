<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController {

    public $isRequestRepassword = false;

    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();

    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();

    public function init() {
        parent::init();
        Yii::app()->booster->init();
        Yii::app()->user->setState('current_language', CHtml::value(Yii::app()->user, 'account.defaultLanguage', 'en'));
        Yii::app()->language = Yii::app()->user->getState('current_language');
        $template = Configuration::getKey('web_template', 'default');
        Yii::app()->theme = $template;

        $log = new SecurityLog;
        $log->run();
    }

    public function beforeAction($action) {
        if (parent::beforeAction($action)) {

            if (($this->id === 'site' && $action->id === 'logout')) {
                return true;
            }

            /* Check Account ID */
            if (!Yii::app()->user->isGuest && date('Y-m-d') <= '2018-01-31' && !($this->id === 'my' && $action->id === 'security')) {
                $user = Yii::app()->user->account;
                if ($user->isLegacy) {
                    $this->isRequestRepassword = true;
                    $this->redirect(array('my/security'));
                }
            }

            /* Office User */
            if ($this->id !== 'office') {
                if (!Yii::app()->user->isGuest) {
                    $account = Yii::app()->user->account;
                    if ($account->accountType->table_name === 'accountProfileOfficeUser') {
                        if (isset($account->examScheduleAccount) && $account->examScheduleAccount->is_save_office !== ActiveRecord::YES) {
                            Yii::app()->user->setFlash('success', 'สำหรับการเข้าใช้งานครั้งแรก กรุณากรอกข้อมูลให้ครบถ้วนก่อน');
                            $this->redirect(array('office/prepare'));
                        }
                    }
                }
            }


            $route = $this->id . '/' . $action->id;
            if (!Yii::app()->request->isAjaxRequest && !in_array($route, array(
                        'my/profile',
                    ))) {
                if (!Yii::app()->user->isGuest) {
                    $account = Yii::app()->user->account;
                    if ($account->accountType->table_name !== 'accountProfileOfficeUser') {
                        if (!$account->secure_question_1) {
                            Yii::app()->user->setFlash('success', Helper::t('Please input required fields before using this account.', 'สำหรับการเข้าใช้งานครั้งแรก กรุณากรอกข้อมูลให้ครบถ้วนก่อน'));
                            $this->redirect(array('/my/profile', 'mode' => 'firsttime'));
                        }
                    }
                }
            }

            if ($this->id !== 'site' && $action->id !== 'generateSessionKey') {
                if (Yii::app()->user->getIsOfficeUser()) {
                    Yii::app()->user->account->saveAttributes(array(
                        'session_timeout' => date('Y-m-d H:i:s', strtotime('+10 minutes')),
                    ));
                }
            }

            return true;
        }
    }

    public function filters() {
        return array_merge(parent::filters(), array(
            'accessControl',
        ));
    }

    public function accessRules() {
        return array_merge(parent::accessRules(), array(
            array(
                'allow',
                'users' => array('@'),
            ),
            array(
                'deny',
                'users' => array('*'),
            ),
        ));
    }

}
