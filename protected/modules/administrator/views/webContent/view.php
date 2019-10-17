<?php echo Helper::htmlTopic('จัดการเนื้อหาข่าวสาร', 'แสดงเนื้อหา'); ?>
<h3 class="fancy"><?php echo CHtml::value($model, 'name'); ?></h3>
<div class="text-muted">
    <small>สร้างเมื่อ : <?php echo CHtml::value($model, 'created'); ?> / โดย : <?php echo CHtml::value($model, 'user.username', '-'); ?></small>
</div>
<hr/>
<div class="row">
    <div class="col-sm-8">
        <div id="web-content-page">
            <?php echo CHtml::value($model, 'content'); ?>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="well well-sm">
            <h4 class="fancy">รูปหน้าปก</h4>
            <div class="thumbnail">
                <?php if(isset($model->vdo)): ?>
                    <video width="300" height="150" controls>
                        <source src="<?php echo $model->getVDOFile() ?>">
                    </video>
                <?php else: ?>
                    <?php echo CHtml::image($model->coverFile->getFileUrl('thumbnail') . '?t=' . time()); ?>
                <?php endif; ?>
            </div>
            <h4 class="fancy">เนื้อหา (ย่อ)</h4>
            <div class="container-fluid" style="color:<?php echo CHtml::value($model, 'brief_color', '#000000'); ?>;">
                <?php echo CHtml::encode($model->brief); ?>
            </div>
            <br/>
            <h4 class="fancy">การแสดงเนื้อหา</h4>
            <div class="container-fluid">
                <div>สถานะ :  <?php if ($model->isVisible): ?><span class="text-success">แสดงเนื้อหา</span><?php else: ?><span class="text-danger">ซ่อนการแสดงผล</span><?php endif; ?></div>
                <div>ตั้งแต่วันที่ : <span class="text-primary"><?php echo $model->date_start ? Yii::app()->format->formatDate($model->date_start) : 'ไม่ได้กำหนด'; ?></span></div>
                <div>ถึงวันที่ :  <span class="text-primary"><?php echo $model->date_end ? Yii::app()->format->formatDate($model->date_end) : 'ไม่ได้กำหนด'; ?></span></div>
            </div>
            <br/>
        </div>
    </div>

</div>
<hr/>
<div class="well well-sm btn-toolbar">
    <?php echo Helper::buttonBack(array('index')); ?>
    <?php
    $this->widget('booster.wigets.TbButton', array(
        'icon' => 'edit',
        'url' => array('update', 'id' => $model->id),
        'buttonType' => 'link',
        'context' => 'info',
        'htmlOptions' => array(
            'class' => 'pull-right',
            'title' => 'แก้ไขข้อมูล',
            'data-toggle' => 'tooltip',
        ),
    ));
    ?>
    <?php
    $this->widget('booster.wigets.TbButton', array(
        'icon' => 'trash',
        'url' => array('delete', 'id' => $model->id),
        'buttonType' => 'link',
        'context' => 'danger',
        'htmlOptions' => array(
            'class' => 'pull-right',
            'title' => 'ลบข้อมูล',
            'data-toggle' => 'tooltip',
            'onclick' => 'return confirm("คุณต้องการลบข้อมูลนี้?")',
        ),
    ));
    ?>
</div>
