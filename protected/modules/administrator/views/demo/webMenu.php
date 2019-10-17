<div class="box box-solid">
    <div class="box-header">
        <h3 class="box-title">เมนูเว็บไซต์ </h3>
        <div class="box-tools">
            <?php
            $this->widget('booster.widgets.TbButton', array(
                'label' => 'เพิ่มเมนูใหม่',
                'buttonType' => 'link',
                'url' => array('webMenuCreate'),
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
                    <th>ชื่อเมนู</th>
                    <th>เชื่อมโยง</th>
                    <th class="text-center button-column">เครื่องมือ</th>
                </tr>    
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>กระทรวงการต่างประเทศ</td>
                    <td>http://www.mfa.go.th</td>
                    <td class="text-center button-column">
                        <i class="glyphicon glyphicon-pencil"></i>
                        <i class="glyphicon glyphicon-trash"></i>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>เกี่ยวกับเรา</td>
                    <td>http://www.mfa.go.th/aboutus</td>
                    <td class="text-center button-column">
                        <i class="glyphicon glyphicon-pencil"></i>
                        <i class="glyphicon glyphicon-trash"></i>
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>คู่มือการสมัครสอบ</td>
                    <td>http://www.mfa.go.th/manual.pdf</td>
                    <td class="text-center button-column">
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
