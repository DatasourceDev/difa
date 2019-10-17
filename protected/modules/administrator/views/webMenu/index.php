<div class="btn-toolbar">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'เพิ่มเมนู',
        'context' => 'primary',
        'url' => array('create'),
        'buttonType' => 'link',
    ))
    ?>
</div>
<div id="menu-grid" class="grid-view">
    <table class="table table-condensed table-bordered">
        <thead>
            <tr>
                <td>ชื่อเมนู</td>
                <td>URL</td>
                <td></td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($menu as $item): ?>
                <tr>
                    <td><?php echo CHtml::value($item, 'name'); ?></td>
                    <td><?php echo CHtml::value($item, 'url'); ?></td>
                    <td class="button-column">
                        <?php if ($item->isDropDown) : ?>
                            <?php echo CHtml::link(Helper::glyphicon('plus'), array('addItem', 'id' => $item->id), array('data-toggle' => 'tooltip', 'title' => 'เพิ่มเมนูย่อย')); ?>
                        <?php endif; ?>
                    </td>
                    <td class="button-column">
                        <?php echo CHtml::link(Helper::glyphicon('edit'), array('update', 'id' => $item->id)); ?>
                        <?php echo CHtml::link(Helper::glyphicon('trash'), array('delete', 'id' => $item->id), array('class' => 'btn-ajax-post', 'data-content-update' => '#menu-grid', 'data-confirm' => 'ต้องการลบรายการนี้ ?')); ?>
                    </td>
                </tr>
                <?php foreach ($item->webMenuItems as $subItem): ?>
                    <tr class="bg-warning">
                        <td><span class="tree-box"></span><?php echo CHtml::value($subItem, 'name'); ?></td>
                        <td><?php echo CHtml::value($subItem, 'url'); ?></td>
                        <td class="button-column">
                        </td>
                        <td class="button-column">
                            <?php echo CHtml::link(Helper::glyphicon('edit'), array('updateItem', 'id' => $subItem->id)); ?>
                            <?php echo CHtml::link(Helper::glyphicon('trash'), array('deleteItem', 'id' => $subItem->id), array('class' => 'btn-ajax-post', 'data-content-update' => '#menu-grid', 'data-confirm' => 'ต้องการลบรายการนี้ ?')); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>            
            <?php endforeach; ?>            
        </tbody>
    </table>
</div>
