<div class="btn-toolbar">
    <?php echo Helper::buttonBack(array('index')); ?>
</div>
<br/>
<div class="row">
    <div class="col-sm-6">
        <h4 class="fancy">ข้อความที่แจ้งเข้ามา</h4>
        <?php
        $this->widget('booster.widgets.TbDetailView', array(
            'data' => $model,
            'attributes' => array(
                array(
                    'label' => 'Name',
                    'name' => 'fullname',
                ),
                array(
                    'name' => 'email',
                ),
                array(
                    'name' => 'topic',
                ),
                array(
                    'name' => 'message',
                    'type' => 'html',
                ),
                array(
                    'name' => 'place_of_birth',
                ),
                array(
                    'name' => 'attachment_file',
                    'value' => $model->attachmentFile->fileUrl ? CHtml::link('[Download]', $model->attachmentFile->fileUrl, array('target' => '_blank')) : 'No attachment.',
                    'type' => 'raw',
                ),
                array(
                    'name' => 'created',
                    'type' => 'datetime',
                ),
                array(
                    'name' => 'status',
                    'value' => $model->is_done === ActiveRecord::YES ? Helper::htmlSignSuccess() . ' ดำเนินการเรียบร้อย' : Helper::htmlSignFail() . ' ยังไม่ได้ดำเนินการ',
                    'type' => 'raw',
                ),
            ),
        ));
        ?>
        <hr/>
        <div class="btn-toolbar">
            <?php
            $this->widget('booster.widgets.TbButtonGroup', array(
                'htmlOptions' => array(
                    'class' => 'pull-right',
                ),
                'buttons' => array(
                    array(
                        'label' => 'ตั้งค่าเป็น : ',
                    ),
                    array(
                        'label' => 'ดำเนินการเรียบร้อย',
                        'icon' => 'ok',
                        'context' => 'success',
                        'url' => array('setDone', 'id' => $model->id),
                        'buttonType' => 'link',
                    ),
                    array(
                        'label' => 'ยังไม่ได้ดำเนินการ',
                        'icon' => 'remove',
                        'context' => 'danger',
                        'url' => array('setUnread', 'id' => $model->id),
                        'buttonType' => 'link',
                    ),
                ),
            ));
            ?>
        </div>
        <hr/>
        <h4 class="fancy">ข้อความตอบกลับ</h4>
        <?php
        $this->widget('booster.widgets.TbDetailView', array(
            'data' => $model,
            'attributes' => array(
                array(
                    'name' => 'reply_message',
                    'type' => 'html',
                ),
                array(
                    'name' => 'reply_datetime',
                    'type' => 'datetime',
                ),
                array(
                    'label' => 'ผู้ตอบกลับ',
                    'name' => 'user_id',
                    'value' => CHtml::value($model, 'user.username'),
                    'type' => 'text',
                ),
            ),
        ));
        ?>
    </div>
    <div class="col-sm-6">
        <h4 class="fancy">แบบฟอร์มตอบกลับ</h4>
        <div class="well">
            <?php $form = $this->beginWidget('CodeskActiveForm'); ?>
            <?php
            echo $form->textFieldGroup($model, 'email', array(
                'widgetOptions' => array(
                    'htmlOptions' => array(
                        'disabled' => true,
                    ),
                ),
                'labelOptions' => array(
                    'label' => 'ส่งกลับไปที่'
                ),
                'prepend' => Helper::glyphicon('envelope'),
            ));
            ?>
            <?php
            echo $form->redactorGroup($model, 'reply_message', array(
            ));
            ?>
            <div class="btn-toolbar">
                <?php
                $this->widget('booster.widgets.TbButton', array(
                    'label' => 'ส่งข้อความ',
                    'context' => 'primary',
                    'buttonType' => 'submit',
                    'htmlOptions' => array(
                        'class' => 'pull-right',
                    ),
                ));
                ?>
            </div>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>
