<?php if (false): ?>
    <?php if ($this->id !== 'register'): ?>
        <div id="language-tools">
            <?php echo CHtml::link(CHtml::image(Yii::app()->baseUrl . '/images/lang_th.png', 'Thai'), array('/site/switchLanguage', 'lang' => 'th', 'returnUrl' => Yii::app()->request->requestUri)); ?>
            <?php echo CHtml::link(CHtml::image(Yii::app()->baseUrl . '/images/lang_en.png', 'English'), array('/site/switchLanguage', 'lang' => 'en', 'returnUrl' => Yii::app()->request->requestUri)); ?>
        </div>
    <?php endif; ?>
<?php endif; ?>