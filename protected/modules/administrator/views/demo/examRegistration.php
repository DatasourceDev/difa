<div class="box box-solid">
    <div class="box-header">
        <h3 class="box-title">รายชื่อสมาชิก</h3>
        <div class="box-tools">
            <?php
            $this->widget('booster.widgets.TbButton', array(
                'label' => 'เพิ่มสมาชิกใหม่',
                'buttonType' => 'link',
                'url' => array('adminMemberCreate'),
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
                    <th>ประเภทการสอบ</th>
                    <th>หัวข้อ</th>
                    <th>สร้างเมื่อ</th>
                    <th class="text-center button-column">เครื่องมือ</th>
                </tr>    
            </thead>
            <tbody>
                <tr>
                    <td>4101700092130</td>
                    <td>นายสุรเชษฐ์ มั่นชวนนท์</td>
                    <td>ET</td>
                    <td>10/09/2015 09:00</td>
                    <td>Yes</td>
                    <td class="text-center button-column">
                        <i class="glyphicon glyphicon-eye-open"></i>
                        <i class="glyphicon glyphicon-pencil"></i>
                        <i class="glyphicon glyphicon-trash"></i>
                    </td>
                </tr>
                <tr>
                    <td>F032032000001</td>
                    <td>Mr.Joseph Mathews</td>
                    <td>ET</td>
                    <td>10/09/2015 09:00</td>
                    <td>Yes</td>
                    <td class="text-center button-column">
                        <i class="glyphicon glyphicon-eye-open"></i>
                        <i class="glyphicon glyphicon-pencil"></i>
                        <i class="glyphicon glyphicon-trash"></i>
                    </td>
                </tr>
                <tr>
                    <td>F028028000002</td>
                    <td>Mrs.Janett Green</td>
                    <td>ET</td>
                    <td>10/09/2015 09:00</td>
                    <td>No</td>
                    <td class="text-center button-column">
                        <i class="glyphicon glyphicon-eye-open"></i>
                        <i class="glyphicon glyphicon-pencil"></i>
                        <i class="glyphicon glyphicon-trash"></i>
                    </td>
                </tr>
                <tr>
                    <td>3215445104510</td>
                    <td>นางกิมกี ศรีสงคราม</td>
                    <td>ET</td>
                    <td>10/09/2015 09:00</td>
                    <td>Yes</td>
                    <td class="text-center button-column">
                        <i class="glyphicon glyphicon-eye-open"></i>
                        <i class="glyphicon glyphicon-pencil"></i>
                        <i class="glyphicon glyphicon-trash"></i>
                    </td>
                </tr>
                <tr>
                    <td>F042042000003</td>
                    <td>Mr.Fred Flintstones</td>
                    <td>IH</td>
                    <td>10/09/2015 09:00</td>
                    <td>Yes</td>
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
