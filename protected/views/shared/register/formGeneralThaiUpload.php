<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/vendor/simple-ajax-uploader/SimpleAjaxUploader.min.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/vendor/jcrop/js/jquery.Jcrop.min.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/vendor/jcrop/js/jquery.color.js'); ?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/js/vendor/jcrop/css/jquery.Jcrop.min.css'); ?>
<?php
$this->beginWidget('booster.widgets.TbModal', array(
    'id' => 'upload-modal',
));
?>
<div class="modal-header">
    <h3 class="modal-title">อัพโหลดไฟล์รูปบัตร</h3>
</div>
<div class="modal-body">
    <p class="text-center">เฉพาะไฟล์ประเภท jpg หรือ png</p>
    <div id="progressOuter" class="progress progress-striped active" style="display:none;">
        <div id="progressBar" class="progress-bar progress-bar-success"  role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
    </div>
    <div>
        <div id="imgBox" class="thumbnail" style="display: none;"></div>
        <div id="msgBox"></div>
        <div id="preview-pane" style="width:260px;height:200px;overflow:hidden;margin:0px auto;border:1px solid #656565;">
            <?php if (CHtml::value($model, 'photoUrl')): ?>
                <?php echo CHtml::image(CHtml::value($model, 'photoUrl')) ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="modal-footer">
    <?php
    $this->widget('booster.widgets.TbButton', array(
        'label' => 'บันทึก',
        'icon' => 'ok',
        'context' => 'success',
        'htmlOptions' => array(
            'id' => 'btn-file-accept',
            'class' => 'pull-left',
        ),
    ));
    ?>
    <button id="uploadBtn" class="btn btn-large btn-primary">เลือกไฟล์</button>
</div>
<?php $this->endWidget(); ?>
<script>
    function escapeTags(str) {
        return String(str)
                .replace(/&/g, '&amp;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#39;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;');
    }

    window.onload = function () {

        var btn = document.getElementById('uploadBtn'),
                progressBar = document.getElementById('progressBar'),
                progressOuter = document.getElementById('progressOuter'),
                msgBox = document.getElementById('msgBox');

        var uploader = new ss.SimpleUpload({
            button: btn,
            url: '<?php echo $this->createUrl('/register/ajaxUploadFile'); ?>',
            name: 'uploadfile',
            multipart: true,
            hoverClass: 'hover',
            focusClass: 'focus',
            responseType: 'json',
            startXHR: function () {
                progressOuter.style.display = 'block'; // make progress bar visible
                this.setProgressBar(progressBar);
            },
            onSubmit: function () {
                msgBox.innerHTML = ''; // empty the message box
                btn.innerHTML = 'กำลังอัพโหลด...'; // change button text to "Uploading..."
            },
            onComplete: function (filename, response) {
                btn.innerHTML = 'เลือกไฟล์';
                progressOuter.style.display = 'none'; // hide progress bar when upload is completed

                if (!response) {
                    msgBox.innerHTML = 'ไม่สามารถอัพโหลดไฟล์ได้';
                    return;
                }

                if (response.success === true) {
                    $('#imgBox').show().html(response.html);
                    $('#preview-pane').html(response.html);
                    $('#imgBox img').Jcrop({
                        aspectRatio: 1.3,
                        setSelect: [0, 0, 260, 200],
                        onSelect: showPreview,
                        onChange: showPreview
                    });
                    msgBox.innerHTML = 'อัพโหลดไฟล์เรียบร้อย กรุณาปรับขนาดภาพให้เหมาะสม';
                } else {
                    if (response.msg) {
                        msgBox.innerHTML = escapeTags(response.msg);

                    } else {
                        msgBox.innerHTML = 'เกิดข้อผิดพลาดในการอัพโหลดไฟล์ กรุณาติดต่อเจ้าหน้าที่';
                    }
                }
            },
            onError: function () {
                progressOuter.style.display = 'none';
                msgBox.innerHTML = 'ไม่สามารถอัพโหลดไฟล์ได้';
            }
        });
    };

    function showPreview(coords) {
        var rx = 260 / coords.w;
        var ry = 200 / coords.h;
        console.log(coords);
        $('#preview-pane img').css({
            width: Math.round(rx * $('#preview').width()) + 'px',
            height: Math.round(ry * $('#preview').height()) + 'px',
            marginLeft: '-' + Math.round(rx * coords.x) + 'px',
            marginTop: '-' + Math.round(ry * coords.y) + 'px'
        }).attr('id', 'preview-img');
    }

    $(document).ready(function () {
        $('#btn-file-accept').click(function () {
            var img = $('#preview-pane img');
            $.post('<?php echo Yii::app()->createUrl('/register/processImage'); ?>', {
                data: {
                    src: $(img).attr('src'),
                    width: $(img).css('width'),
                    height: $(img).css('height'),
                    marginLeft: $(img).css('marginLeft'),
                    marginTop: $(img).css('marginTop'),
                    w: 260,
                    h: 200
                }
            }, function (data) {
                $('#register-photo').html(data.html);
                $('#emp-pic-file').val(data.filename);
            }, 'json');
            $('#upload-modal').modal('hide');
            return false;
        });
    });
</script>