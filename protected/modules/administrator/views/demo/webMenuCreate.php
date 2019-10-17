<form class="form-horizontal" method="get">
    <div class="box box-solid">
        <div class="box-header">
            <h3 class="box-title">สร้างเมนูใหม่</h3>
        </div>
        <div class="box-body">
            <div class="form-group">
                <div class="col-sm-3 text-right">
                    <label class="control-label">ชื่อเมนู</label>
                </div>
                <div class="col-sm-9">
                    <input type="text" class="form-control"/>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-3 text-right">
                    <label class="control-label">ลิงค์เชื่อมโยง</label>
                </div>
                <div class="col-sm-9">
                    <input type="text" class="form-control"/>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <?php
            $this->widget('booster.widgets.TbButton', array(
                'label' => 'ย้อนกลับ',
                'buttonType' => 'link',
                'url' => array('webMenu'),
            ));
            ?>
            <?php
            $this->widget('booster.widgets.TbButton', array(
                'label' => 'บันทึกข้อมูล',
                'buttonType' => 'link',
                'url' => array('webMenu'),
                'context' => 'primary',
                'htmlOptions' => array(
                    'class' => 'pull-right',
                ),
            ));
            ?>
        </div>
    </div>
</form>