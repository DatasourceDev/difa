<div class="btn-toolbar">
    <?php Helper::buttonBack(array('index')); ?>
    <?php Helper::buttonUpdate(array('update', 'id' => $model->id)); ?>
</div>
<div class="row">
    <div class="col-sm-6">
        <h4 class="fancy">ข้อมูลบัญชี</h4>
        <?php
        $this->widget('booster.widgets.TbDetailView', array(
            'data' => $model,
            'attributes' => array(
                'username',
                'email',
                'roleName:text:บทบาท',
                'last_login:datetime:เข้าใช้งานครั้งล่าสุด',
            ),
        ));
        ?>
        <hr/>
        <h4 class="fancy">บันทึกกิจกรรมในระบบ</h4>
        <?php
        $this->widget('booster.widgets.TbGridView', array(
            'dataProvider' => $dataProvider,
            'columns' => array(
                array(
                    'name' => 'created',
                    'type' => 'datetime',
                    'headerHtmlOptions' => array(
                        'class' => 'text-center col-sm-3',
                    ),
                    'htmlOptions' => array(
                        'class' => 'text-center',
                    ),
                ),
                array(
                    'name' => 'message',
                ),
            ),
        ));
        ?>
    </div>
    <div class="col-sm-6">
        <h4 class="fancy">สิทธิในการใช้งาน</h4>
        <table class="table table-condensed table-bordered">
            <?php if (isset($model->role)): ?>
                <?php foreach ($groups as $group => $permissions): ?>
                    <tr>
                        <th class="bg-info"><?php echo Permission::getGroupName($group); ?></th>
                    </tr>
                    <?php foreach ($permissions as $permission): ?>
                        <?php if ($model->checkPermission($permission->id)): ?>
                            <tr>
                                <td style="padding-left:25px;"><?php echo $permission->name; ?></td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <?php if ($model->isSuperUser): ?>
                        <td class="text-center bg-success"><span class="text-success">สามารถเข้าถึงได้ทุกฟังก์ชั่น</span></td>
                    <?php else: ?>
                        <td class="text-center bg-danger"><span class="text-danger">ยังไม่ได้กำหนดสิทธิการใช้งาน</span></td>
                    <?php endif; ?>

                </tr>
            <?php endif; ?>
        </table>
    </div>
</div>
