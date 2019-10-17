<table border="0" width="100%">
    <tr>
        <td>
            <?php echo CHtml::image(Yii::app()->baseUrl . '/images/logo.png', '', array('width' => '200')); ?>        
        </td>
        <td>
            <h1>บัตรประจำตัวสอบ</h1>
        </td>
        <td style="font-size:12pt;" align="right">
            <?php echo CHtml::image($this->createUrl('/get/qr', array('code' => $model->getConfirmLink()))); ?>
        </td>
    </tr>
</table>
<table width="100%" style="border-top:1px solid #000000;">
    <tr>
        <th align="right">เลขประจำตัวสอบ</th>
        <td><?php echo CHtml::value($model, 'desk_code'); ?></td>
        <td align="right" rowspan="7">
            <?php echo CHtml::image(CHtml::value($model, 'account.profile.empCardFile.fileUrl', CHtml::value($model, 'account.profile.passportFile.fileUrl')), '', array('width' => 300, 'style' => 'border:1px solid;')); ?>
        </td>                
    </tr>
    <tr>
        <th align="right">ชื่อ-นามสกุล</th>
        <td><?php echo CHtml::value($model, 'account.profile.fullname'); ?></td>
    </tr>
    <tr>
        <th align="right">รอบสอบที่</th>
        <td><?php echo CHtml::value($model, 'examSchedule.exam_code'); ?></td>
    </tr>
    <tr>
        <th align="right">สถานที่สอบ</th>
        <td><?php echo CHtml::value($model, 'examSchedule.place_name'); ?></td>
    </tr>
    <tr>
        <th align="right">เลขที่นั่งสอบ</th>
        <td><?php echo CHtml::value($model, 'desk_no'); ?></td>
    </tr>
    <tr>
        <th align="right">ชั้น/ห้อง</th>
        <td><?php echo CHtml::value($model, 'examSchedule.place_remark'); ?></td>        
    </tr>
    <tr>
        <th align="right">ประเภทการสอบ</th>
        <td><?php echo CHtml::value($model, 'examSchedule.examType.name'); ?></td>
    </tr>
</table>