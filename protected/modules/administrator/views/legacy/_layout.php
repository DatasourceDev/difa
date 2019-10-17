<?php $showMenu = isset($showMenu) ? $showMenu : true; ?>
<?php echo Helper::htmlTopic('ฐานข้อมูล ' . $model->name); ?>
<?php if ($showMenu): ?>
    <div class="well well-sm">
        <?php
        $this->widget('booster.widgets.TbButton', array(
            'label' => 'กลับไปหน้าแรก',
            'icon' => 'arrow-left',
            'url' => array('index'),
            'buttonType' => 'link',
        ));
        ?>
    </div>
<?php endif; ?>
<?php echo $content; ?>