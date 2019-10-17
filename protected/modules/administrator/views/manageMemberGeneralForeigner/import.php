<div class="row">
    <div class="col-sm-8">
        <?php
        $this->beginWidget('booster.widgets.TbPanel', array(
            'title' => 'นำเข้าข้อมูลผ่านไฟล์ Excel',
        ));
        ?>
        <?php
        $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
            'type' => 'horizontal',
            'focus' => array($model, 'course_name'),
            'htmlOptions' => array(
                'enctype' => 'multipart/form-data',
            ),
        ));
        ?>
        <?php echo $form->textFieldGroup($model, 'course_name'); ?>
        <?php
        echo $form->datePickerGroup($model, 'course_date', array(
            'widgetOptions' => array(
            ),
            'prepend' => Helper::glyphicon('calendar'),
        ));
        ?>
        <?php echo $form->fileFieldGroup($model, 'excel_file'); ?>
        <div class="form-group">
            <div class="col-md-9 col-md-offset-3">
                <?php
                Helper::buttonSubmit('บันทึกข้อมูล', array(
                    'htmlOptions' => array(
                        'class' => 'pull-right',
                    ),
                ));
                ?>
                <?php Helper::buttonBack(array('index')); ?>
            </div>
        </div>
        <?php $this->endWidget(); ?>
        <?php $this->endWidget(); ?>
    </div>
    <div class="col-sm-4">
        <h4 class="fancy"><span class="text-bold text-underline">หมายเหตุ</span> รูปแบบแบบของข้อมูลในไฟล์ Excel ต้องตรงตามที่ระบบกำหนด ดังนี้</h4>
        <table class="table table-condensed table-bordered table-striped">
            <thead>
                <tr>
                    <th>คอลั่มน์</th>
                    <th>ข้อมูล</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($model->columnMapper() as $col => $name): ?>
                    <tr> 
                        <td><?php echo chr(ord('A') + $col); ?></td>
                        <td><?php echo $name; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>    
</div>