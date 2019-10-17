<?php $autoOpen = isset($autoOpen) ? $autoOpen : false; ?>
<?php $this->beginWidget('booster.widgets.TbCollapse'); ?>
<div class="panel-group" id="accordion">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                    <span class="glyphicon glyphicon-search"></span> ค้นหาตามเงื่อนไข
                </a>
            </h4>
        </div>
        <div id="collapseOne" class="panel-collapse collapse <?php echo $autoOpen ? 'in' : '' ?>">
            <div class="panel-body">
                <?php echo $content; ?>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>