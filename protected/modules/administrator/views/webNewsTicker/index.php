<?php echo Helper::htmlTopic('จัดการตัววิ่งประชาสัมพันธ์', 'แสดงรายการตัววิ่งประชาสัมพันธ์'); ?>
<?php
$form = $this->beginWidget('booster.widgets.TbActiveForm', array(
    'type' => 'horizontal',
        ));
?>
<?php
$this->beginWidget('booster.widgets.TbPanel', array(
    'title' => 'ข้อมูลตัววิ่งประชาสัมพันธ์',
));
?>
<div class="row">
	<div class="col-md-12">
		<?php
        echo $form->radioButtonListGroup($model, 'web_news_ticker', array(
            'widgetOptions' => array(
                'data' => $model->getUseNewsTickerOptions(),
            ),
        ));
      ?>
	</div>
</div>
<div class="custom">
	<div class="row">
		<div class="col-md-12">
			<?php
			echo $form->radioButtonListGroup($model, 'web_news_ticker1', array(
				'widgetOptions' => array(
					'data' => $model->getUseNewsTickerCustomOptions(),
					'htmlOptions' => array(
					  'labelOptions' => array(
					  'class' => 'radio-inline',
					  ),
					),
				),
			));
         ?>
           
		</div>
	</div>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-4">
            <?php
            echo $form->datePickerGroup($model, 'custom_date_from1', array(
                'widgetOptions' => array(
                    'htmlOptions' => array(
					  'placeholder' => 'วันที่เริ่ม',
				    ),
                ),
                'prepend' => Helper::glyphicon('calendar'),
            ));
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-4">
            <?php
            echo $form->datePickerGroup($model, 'custom_date_to1', array(
                'widgetOptions' => array(
                    'htmlOptions' => array(
					  'placeholder' => 'ถึงวันที่',
				    ),
                ),
                'prepend' => Helper::glyphicon('calendar'),
            ));
            ?>
        </div>

    </div>
	<div class="row" id="divnews1">
		<div class="col-md-1"></div>
		<div class="col-md-8">
			<?php
			echo $form->dropDownListGroup($model, 'custom_new1', array(
				'widgetOptions' => array(
					'htmlOptions' => array(
					),
					'data' => CHtml::listData(WebContent::model()->findAll(), 'id', 'name'),
				),
				'labelOptions' => array(
					'label' => '',
				),
			));
			?>
		</div>
	</div>
	<div class="row" id="divcustom1">
		<div class="col-md-1"></div>
		<div class="col-md-8">
			<?php
			echo $form->textFieldGroup($model, 'custom_content1', array(
				'widgetOptions' => array(
					'htmlOptions' => array(
						'placeholder' => '',
					),
				),
			));
			?>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<?php
			echo $form->radioButtonListGroup($model, 'web_news_ticker2', array(
				'widgetOptions' => array(
					'data' => $model->getUseNewsTickerCustomOptions(),
					'htmlOptions' => array(
					  'labelOptions' => array(
					  'class' => 'radio-inline',
					  ),
					),
				),
			));
         ?>
		</div>
	</div>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-4">
            <?php
            echo $form->datePickerGroup($model, 'custom_date_from2', array(
                'widgetOptions' => array(
                    'htmlOptions' => array(
					  'placeholder' => 'วันที่เริ่ม',
				    ),
                ),
                'prepend' => Helper::glyphicon('calendar'),
            ));
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-4">
            <?php
            echo $form->datePickerGroup($model, 'custom_date_to2', array(
                'widgetOptions' => array(
                    'htmlOptions' => array(
					  'placeholder' => 'ถึงวันที่',
				    ),
                ),
                'prepend' => Helper::glyphicon('calendar'),
            ));
            ?>
        </div>

    </div>
	<div class="row" id="divnews2">
		<div class="col-md-1"></div>
		<div class="col-md-8">
			<?php
			echo $form->dropDownListGroup($model, 'custom_new2', array(
				'widgetOptions' => array(
					'htmlOptions' => array(
					),
					'data' => CHtml::listData(WebContent::model()->findAll(), 'id', 'name'),
				),
				'labelOptions' => array(
					'label' => '',
				),
			));
			?>

		</div>
	</div>
	<div class="row" id="divcustom2">
		<div class="col-md-1"></div>
		<div class="col-md-8">
			<?php
			echo $form->textFieldGroup($model, 'custom_content2', array(
				'widgetOptions' => array(
					'htmlOptions' => array(
						'placeholder' => '',
					),
				),
			));
         ?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<?php
			echo $form->radioButtonListGroup($model, 'web_news_ticker3', array(
				'widgetOptions' => array(
					'data' => $model->getUseNewsTickerCustomOptions(),
					'htmlOptions' => array(
					  'labelOptions' => array(
					  'class' => 'radio-inline',
					  ),
					),
				),
			));
         ?>
		</div>
	</div>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-4">
            <?php
            echo $form->datePickerGroup($model, 'custom_date_from3', array(
                'widgetOptions' => array(
                    'htmlOptions' => array(
					  'placeholder' => 'วันที่เริ่ม',
				    ),
                ),
                'prepend' => Helper::glyphicon('calendar'),
            ));
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-4">
            <?php
            echo $form->datePickerGroup($model, 'custom_date_to3', array(
                'widgetOptions' => array(
                    'htmlOptions' => array(
					  'placeholder' => 'ถึงวันที่',
				    ),
                ),
                'prepend' => Helper::glyphicon('calendar'),
            ));
            ?>
        </div>

    </div>
	<div class="row" id="divnews3">
		<div class="col-md-1"></div>
		<div class="col-md-8">
			<?php
			echo $form->dropDownListGroup($model, 'custom_new3', array(
				'widgetOptions' => array(
					'htmlOptions' => array(
					),
					'data' => CHtml::listData(WebContent::model()->findAll(), 'id', 'name'),
				),
				'labelOptions' => array(
					'label' => '',
				),
			));
			?>
		</div>
	</div>
	<div class="row" id="divcustom3">
		<div class="col-md-1"></div>
		<div class="col-md-8">
			<?php
			echo $form->textFieldGroup($model, 'custom_content3', array(
				'widgetOptions' => array(
					'htmlOptions' => array(
						'placeholder' => '',
					),
				),
			));
         ?>
		</div>
	</div>
</div>
<div class="form-group">
	<div class="col-md-9 col-md-offset-3">
		<?php
        Helper::buttonSubmit('บันทึกข้อมูล', array(
            'htmlOptions' => array(
                'class' => 'pull-right',
            ),
        ));
      ?>
	</div>
</div>
<?php $this->endWidget(); ?>
<?php $this->endWidget(); ?>
<script>
	$(document).ready(function () {
		web_news_ticker_onchange();
		web_news_ticker1_onchange();
		web_news_ticker2_onchange();
		web_news_ticker3_onchange();
		$("#WebNewsTicker_web_news_ticker_0, #WebNewsTicker_web_news_ticker_1").change(function () {
			web_news_ticker_onchange();
		});
		$("#WebNewsTicker_web_news_ticker1_0, #WebNewsTicker_web_news_ticker1_1").change(function () {
			web_news_ticker1_onchange();
		});
		$("#WebNewsTicker_web_news_ticker2_0, #WebNewsTicker_web_news_ticker2_1").change(function () {
			web_news_ticker2_onchange();
		});
		$("#WebNewsTicker_web_news_ticker3_0, #WebNewsTicker_web_news_ticker3_1").change(function () {
			web_news_ticker3_onchange();
		});

	});
	function web_news_ticker_onchange() {
		if ($("#WebNewsTicker_web_news_ticker_0").get(0).checked == true) {
			$(".custom").hide();
		}
		else {
			$(".custom").show();
		}
	}
	function web_news_ticker1_onchange() {
		if ($("#WebNewsTicker_web_news_ticker1_0").get(0).checked == true) {
			$("#divnews1").show();
			$("#divcustom1").hide();
		}
		else {
			$("#divnews1").hide();
			$("#divcustom1").show();
		}
	}
	function web_news_ticker2_onchange() {
		if ($("#WebNewsTicker_web_news_ticker2_0").get(0).checked == true) {
			$("#divnews2").show();
			$("#divcustom2").hide();
		}
		else {
			$("#divnews2").hide();
			$("#divcustom2").show();
		}
	}
	function web_news_ticker3_onchange() {
		if ($("#WebNewsTicker_web_news_ticker3_0").get(0).checked == true) {
			$("#divnews3").show();
			$("#divcustom3").hide();
		}
		else {
			$("#divnews3").hide();
			$("#divcustom3").show();
		}
	}
</script>