<?php
$this->widget('booster.widgets.TbNavbar', array(
    'brand' => false,
    'fixed' => false,
    'items' => array(
        array(
            'class' => 'booster.widgets.TbMenu',
            'type' => 'navbar',
            'items' => array(
                array(
                    'label' => 'Home',
                    'url' => array('/site/index'),
                    'active' => ($this->id === 'site' && CHtml::value($this, 'action.id') === 'index') || (Yii::app()->user->isOfficeUser && $this->id === 'office'),
                ),
            ),
        ),
        array(
            'class' => 'booster.widgets.TbMenu',
            'type' => 'navbar',
            'items' => WebMenu::getMenuItems(),
        ),
        array(
            'class' => 'booster.widgets.TbMenu',
            'type' => 'navbar',
            'htmlOptions' => array(
                'class' => 'navbar-right',
            ),
            'items' => array(
                array(
                    'label' => 'Login',
                    'url' => array('/site/login'),
                    'visible' => Yii::app()->user->isGuest,
                ),
                array(
                    'icon' => 'user',
                    'label' => CHtml::value(Yii::app()->user, 'account.profile.fullname'),
                    'url' => array('/profile'),
                    'visible' => !Yii::app()->user->isGuest,
                    'items' => array(
                        array(
                            'label' => Yii::t('app', 'My Profile'),
                            'url' => array('/my/profile'),
                            'visible' => !Yii::app()->user->isOfficeUser,
                        ),
                        array(
                            'label' => Yii::t('app', 'Logout'),
                            'url' => array('/site/logout'),
                        ),
                    ),
                ),
            ),
        ),
    ),
));
?>
<?php if (!Yii::app()->user->isGuest && Yii::app()->user->account->is_legacy): ?>
    <div class="container" style="margin-top:15px;">
        <div class="row">
            <div class="alert alert-danger">
                <?php echo Helper::glyphicon('exclamation-sign'); ?> For better security, please update your password. <?php echo CHtml::link('[click here]', array('/my/index')); ?>
            </div>
        </div>
    </div>
<?php endif; ?>