	<?php 
		$criteria = new CDbCriteria;
		$criteria->limit = 3;
		$questions = WebFAQ::model()->sortBy('order_no')->findAll($criteria);

		$countRecord =  WebFAQ::model()->count();
	?>
	<input type="checkbox" id="load-more-question"/>
	<div class="topic"><?php echo Helper::t('Q&A', 'คำถามที่พบบ่อย'); ?></div>
	<ul id="nav-question" class="text-small">
		<?php foreach ($questions as $question): ?>
         <?php $ans =  CHtml::value($question, 'content')  ?>
         <?php if (strlen($ans) > 220): ?>
         <?php $ans =  substr($ans,0,200) . "..."  ?>
         <?php endif; ?>
			<li>
				<span class="question-text"><?php echo Helper::glyphicon('question-sign') . CHtml::value($question, 'question') ?></span>
				<span class="answer-text"><?php echo  $ans?></span>
			</li>
		<?php endforeach; ?>
	</ul>
	<?php if (isset($countRecord) && $countRecord > 5): ?>
	<label class="load-more-btn-question" for="load-more-question">
		<span class="unloaded">
			<?php echo CHtml::link(Helper::glyphicon('collapse-down'), array('question'), array('target' => '_blank')) ?>
		</span>
		<span class="loaded">
			<?php echo Helper::glyphicon('collapse-up') ?>
		</span>
	</label>
	<?php endif; ?>
	<style>
		.question-text {
			color: #428bca;
			margin-top: 10px;
			font-size: 22px;
		}
		.answer-text {
			margin-top: 10px;
			color: #9d9d9d;
		}
	</style>

