<form class="form-horizontal" method="get">
    <div class="box box-solid">
        <div class="box-header">
            <h3 class="box-title">สมัครสมาชิกใหม่</h3>
        </div>
        <div class="box-body">
            <div class="form-group">
                <div class="col-sm-3 text-right">
                    <label class="control-label">ชื่อ</label>
                </div>
                <div class="col-sm-9">
                    <input type="text" class="form-control"/>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-3 text-right">
                    <label class="control-label">นามสกุล</label>
                </div>
                <div class="col-sm-9">
                    <textarea class="form-control" rows="15"></textarea>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <?php
            $this->widget('booster.widgets.TbButton', array(
                'label' => 'ย้อนกลับ',
                'buttonType' => 'link',
                'url' => array('webContent'),
            ));
            ?>
            <?php
            $this->widget('booster.widgets.TbButton', array(
                'label' => 'บันทึกข้อมูล',
                'buttonType' => 'link',
                'url' => array('webContentView'),
                'context' => 'primary',
                'htmlOptions' => array(
                    'class' => 'pull-right',
                ),
            ));
            ?>
        </div>
    </div>
</form>