<?php if (!$solve): ?>
    <div class="row">
        <div class="col-sm-6">
            <h4 class="fancy">การดำเนินการ</h4>
            <div class="btn-toolbar">
                <?php
                $this->widget('booster.widgets.TbButton', array(
                    'block' => true,
                    'label' => '1. ยกเลิก บัญชีที่สมัครใหม่ และ แจ้งผู้สมัครให้ใช้บัญชีเดิม โดยใช้รหัสผ่านที่สมัครใหม่',
                    'url' => array('solution1', 'src_id' => $src->id, 'des_id' => $des->id),
                    'context' => 'info',
                    'buttonType' => 'link',
                    'htmlOptions' => array(
                        'onclick' => 'return confirm("ยืนยันการดำเนินการ?")',
                    ),
                ));
                ?>
                <?php
                $this->widget('booster.widgets.TbButton', array(
                    'block' => true,
                    'label' => '2. กรณีที่ข้อมูลเดิมไม่มี ชื่อบัญชี 13 หลัก ให้ใช้บัญชีที่สมัครเข้ามาใหม่',
                    'url' => array('solution2', 'src_id' => $src->id, 'des_id' => $des->id),
                    'context' => 'warning',
                    'buttonType' => 'link',
                    'htmlOptions' => array(
                        'disabled' => $des->username,
                        'onclick' => 'return confirm("ยืนยันการดำเนินการ?")',
                    ),
                ));
                ?>
                <?php
                $this->widget('booster.widgets.TbButton', array(
                    'block' => true,
                    'label' => '3. ไม่ใช่ข้อมูลที่ตรงกัน อนุญาติให้ใช้ข้อมูลที่สมัครมาใหม่',
                    'url' => array('solution3', 'src_id' => $src->id, 'des_id' => $des->id),
                    'context' => 'success',
                    'buttonType' => 'link',
                    'htmlOptions' => array(
                        'onclick' => 'return confirm("ยืนยันการดำเนินการ?")',
                    ),
                ));
                ?>
            </div>
        </div>
    </div>
    <hr/>
<?php endif; ?>
<div class="row">
    <div class="col-sm-6">
        <h4 class="fancy">ข้อมูลผู้สมัคร</h4>
        <?php
        $this->widget('booster.widgets.TbDetailView', array(
            'data' => $src,
            'attributes' => array(
                array(
                    'label' => 'สถานะ',
                    'name' => 'status',
                    'value' => CHtml::value($src, 'status') === Account::STATUS_ACTIVED ? Helper::htmlSignSuccess() . ' ยืนยันการสมัคร' : Helper::htmlSignFail() . ' ยังไม่ได้ยืนยันการสมัคร',
                    'type' => 'raw',
                ),
                array(
                    'label' => 'ชื่อบัญชี',
                    'name' => 'username',
                ),
                array(
                    'label' => 'ประเภทบัญชี',
                    'value' => CHtml::value($src, 'accountType.name_th'),
                ),
                array(
                    'label' => 'ชื่อ-นามสกุล',
                    'value' => CHtml::value($src, 'profile.fullname'),
                ),
                array(
                    'label' => 'วันเดือนปีเกิด',
                    'value' => Yii::app()->format->formatDateText(CHtml::value($src, 'profile.birth_date')),
                ),
                array(
                    'label' => 'สัญชาติ',
                    'value' => CHtml::value($src, 'profile.nationality.name_th'),
                ),
                array(
                    'label' => 'อีเมล์',
                    'value' => CHtml::value($src, 'profile.contact_email'),
                ),
                array(
                    'label' => 'วันที่สมัคร',
                    'name' => 'created',
                    'type' => 'datetime',
                ),
                array(
                    'label' => 'รูปหนังสือเดินทาง',
                    'value' => CHtml::link(CHtml::image(CHtml::value($src, 'profile.photoUrl')), array('#'), array('class' => 'thumbnail')),
                    'type' => 'raw',
                ),
            ),
        ));
        ?>
    </div>
    <div class="col-sm-6">
        <h4 class="fancy">ข้อมูลเดิมที่มีแนวโน้มจะซ้ำซ้อน</h4>
        <?php
        $this->widget('booster.widgets.TbDetailView', array(
            'data' => $des,
            'attributes' => array(
                array(
                    'label' => 'สถานะ',
                    'name' => 'status',
                    'value' => CHtml::value($des, 'status') === Account::STATUS_ACTIVED ? Helper::htmlSignSuccess() . ' ยืนยันการสมัคร' : Helper::htmlSignFail() . ' ยังไม่ได้ยืนยันการสมัคร',
                    'type' => 'raw',
                ),
                array(
                    'label' => 'ชื่อบัญชี',
                    'name' => 'username',
                ),
                array(
                    'label' => 'ประเภทบัญชี',
                    'value' => CHtml::value($des, 'accountType.name_th'),
                ),
                array(
                    'label' => 'ชื่อ-นามสกุล',
                    'value' => CHtml::value($des, 'profile.fullname'),
                ),
                array(
                    'label' => 'วันเดือนปีเกิด',
                    'value' => Yii::app()->format->formatDateText(CHtml::value($des, 'profile.birth_date')),
                ),
                array(
                    'label' => 'สัญชาติ',
                    'value' => CHtml::value($des, 'profile.nationality.name_th'),
                ),
                array(
                    'label' => 'อีเมล์',
                    'value' => CHtml::value($des, 'profile.contact_email'),
                ),
                array(
                    'label' => 'วันที่สมัคร',
                    'name' => 'created',
                    'type' => 'datetime',
                ),
                array(
                    'label' => 'รูปหนังสือเดินทาง',
                    'value' => CHtml::link(CHtml::image(CHtml::value($des, 'profile.photoUrl')), array('#'), array('class' => 'thumbnail')),
                    'type' => 'raw',
                ),
            ),
        ));
        ?>
    </div>
</div>