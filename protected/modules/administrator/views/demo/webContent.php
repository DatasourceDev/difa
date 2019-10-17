<div class="box box-solid">
    <div class="box-header">
        <h3 class="box-title">เนื้อหาเว็บไซต์ </h3>
        <div class="box-tools">
            <?php
            $this->widget('booster.widgets.TbButton', array(
                'label' => 'เพิ่มเนื้อหาใหม่',
                'buttonType' => 'link',
                'url' => array('webContentCreate'),
                'context' => 'primary',
            ));
            ?>
        </div>
    </div>
    <div class="box-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>รหัส</th>
                    <th>หัวข้อ</th>
                    <th>สร้างเมื่อ</th>
                    <th class="text-center button-column">เครื่องมือ</th>
                </tr>    
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>ด่วน!! DVIFA เปิดรับสมัครสอบ เพื่อใช้สำหรับเดินทางไปทำงานยัง NASA ประเทศ USA</td>
                    <td>8 เดือนที่แล้ว</td>
                    <td class="text-center button-column">
                        <i class="glyphicon glyphicon-eye-open"></i>
                        <i class="glyphicon glyphicon-pencil"></i>
                        <i class="glyphicon glyphicon-trash"></i>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>การเตรียมตัวก่อนเข้าห้องสอบ</td>
                    <td>1 ปีที่ผ่านมา</td>
                    <td class="text-center button-column">
                        <i class="glyphicon glyphicon-eye-open"></i>
                        <i class="glyphicon glyphicon-pencil"></i>
                        <i class="glyphicon glyphicon-trash"></i>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="box-footer">
    </div>
</div>
