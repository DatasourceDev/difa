<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/js/vendor/accordion/accordion.css'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/vendor/accordion/accordion.js', CClientScript::POS_END); ?>

<div class="topic"><?php echo Helper::t('Q&A', 'คำถามที่พบบ่อย'); ?></div>
<ul id="nav-question" class="text-small">
    <?php foreach ($model as $question): ?>
               <button class="accordion question-text"><?php echo Helper::glyphicon('question-sign') . " " . CHtml::value($question, 'question') ?><?php echo Helper::glyphicon('chevron-down') ?></button>
               <div class="panel">
                  <p class="answer-text"><?php echo CHtml::value($question, 'content') ?></p>
               </div>
    <?php endforeach; ?>
</ul>
