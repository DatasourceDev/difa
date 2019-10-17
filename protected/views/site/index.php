<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/vendor/inewsticker/inewsticker.js'); ?>

<div class="row">
    <div class="col-sm-12">
        <div class="topic"><?php echo Helper::t('Welcome to DVIFA', 'Welcome to DVIFA'); ?></div>
        <?php if(count($newsList) > 1): ?>
        <div class="topic">
            <ul class="news-ticker">
                <?php foreach ($newsList as $news): ?>
                     <?php if ($news != "" && count($news) ===3): ?>
                        <li>
                           <?php if ($news[1] > 0): ?>
                              <?php /*Get content from news and activity*/ ?>
                           <?php if (isset($news[2]) && $news[2] !== ''): ?>
                              <?php /*custom link*/ ?>
                              <?php echo CHtml::link( $news[0],$news[2], array('target'=>'_blank','class'=>'text-black')); ?>
                           <?php else: ?>
                              <?php echo CHtml::link( $news[0], array('webContent/view', 'id' =>  $news[1]), array('target'=>'_blank','class'=>'text-black')); ?>
                           <?php endif; ?>
                           <?php else: ?>
                              <?php /*Get content from text*/ ?>
                              <?php echo $news[0]; ?>
                           <?php endif; ?>
                        </li>
                     <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php elseif(count($newsList) ==1): ?>
            <div class="topic">
                <?php foreach ($newsList as $news): ?>
                     <?php if ($news != "" && count($news) ===3): ?>
                          <?php if ($news[1] > 0): ?>
                          <?php /*Get content from news and activity*/ ?>
                           <?php if (isset($news[2]) && $news[2] !== ''): ?>
                            <?php /*custom link*/ ?>
                              <?php echo CHtml::link( $news[0],$news[2], array('target'=>'_blank','class'=>'text-black')); ?>
                           <?php else: ?>
                              <?php echo CHtml::link( $news[0], array('webContent/view', 'id' =>  $news[1]), array('target'=>'_blank','class'=>'text-black')); ?>
                           <?php endif; ?>
                           <?php else: ?>
                              <?php echo $news[0]; ?>
                           <?php endif; ?>
                     <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif ?>
        <div class="row">
            <div style="display: flex; justify-content: center;">
            <div class="col-sm-12 offset-sm-1">
                <?php $this->renderPartial('/shared/slider'); ?>
            </div>
            </div>
        </div>
         <div class="row">
            <div class="col-sm-8 col-sm-offset-2 text-center">
               <div class="row">
               <?php
               $img = array(
                     CHtml::image(Yii::app()->baseUrl . '/images/writing.jpg', '', array('width' => '100%', 'style' => 'margin-bottom:10px;')),
                     CHtml::image(Yii::app()->baseUrl . '/images/meeting.jpg', '', array('width' => '100%', 'style' => 'margin-bottom:10px;')),
                     CHtml::image(Yii::app()->baseUrl . '/images/entry.jpg', '', array('width' => '100%', 'style' => 'margin-bottom:10px;')),
               );
               ?>
               <?php foreach ($examTypes as $i => $type): ?>
                     <?php if ($type->is_active === ActiveRecord::NO): ?>
                        <?php continue; ?>
                     <?php endif; ?>
                  <div class="col-sm-6">
                     <div class="well well-sm" style="position:relative; padding-bottom: 15px;">
                        <div class="row">                       
                        <div class="col-sm-12">
                        <h3 class="fancy"><?php echo Helper::t('Sign up', 'Sign up'); ?></h3>
                        <?php echo CHtml::image($type->coverFile->getFileUrl('thumbnail'), '', array('style' => 'width:100%;')); ?>
                        <h3 class="fancy"></h3>
                        <div class="btn-toolbar">
                            <?php foreach ($type->accountTypes as $aType): ?>
                                <?php
                                     switch ($aType->id) {
                                        case 1:
                                           $this->widget('booster.widgets.TbButton', array(
                                               'label' => 'ข้าราชการ พนักงานรัฐวิสาหกิจ และพนักงานในกำกับของรัฐ',
                                               'url' => array('register/index', 'account_type_id' => 1, 'exam_code' => $type->code),
                                               'buttonType' => 'link',
                                               'block' => true,
                                               'context' => 'primary',
                                               'size' => 'small',
                                               'htmlOptions' => array(
                                                   'title' => 'Thai civil servants / State enterprise employees',
                                                   'data-toggle' => 'tooltip',
                                               ),
                                           ));
                                           break;
                                        case 2:
                                           $this->widget('booster.widgets.TbButton', array(
                                               'encodeLabel' => false,
                                               'label' => 'Foreign Civil Servants' . ' <strong style="color:#0000aa;"> * สำหรับชาวต่างประเทศเท่านั้น</strong>',
                                               'url' => array('register/index', 'account_type_id' => 2, 'exam_code' => $type->code),
                                               'buttonType' => 'link',
                                               'block' => true,
                                               'context' => 'warning',
                                               'size' => 'small',
                                               'htmlOptions' => array(
                                                   'title' => 'Foreign civil servants / State enterprise employees / applicants for higher education scholarships or learning course in Thailand (as required).',
                                                   'data-toggle' => 'tooltip',
                                               ),
                                           ));
                                           break;
                                        case 3:
                                           $this->widget('booster.widgets.TbButton', array(
                                               'label' => 'นักการทูต / นักวิเทศสหการ',
                                               'url' => array('register/index', 'account_type_id' => 3, 'exam_code' => $type->code),
                                               'buttonType' => 'link',
                                               'block' => true,
                                               'context' => 'info',
                                               'size' => 'small',
                                           ));
                                           break;
                                        case 4:
                                           $this->widget('booster.widgets.TbButton', array(
                                               'label' => 'Foreign Diplomats',
                                               'url' => array('register/index', 'account_type_id' => 4, 'exam_code' => $type->code),
                                               'buttonType' => 'link',
                                               'block' => true,
                                               'context' => 'success',
                                               'size' => 'small',
                                           ));
                                           break;
                                     }
                                ?>
                            <?php endforeach; ?>
                            <?php if ($type->is_special_info === ActiveRecord::YES): ?>
                                <div class="text-center" style="position: absolute;bottom:10px;left:10px;">
                                    <h5 class="fancy" style="margin:0;">
                                        <?php echo CHtml::link('การสมัครกรณีพิเศษ', array('examType/ajaxViewSpecial', 'id' => $type->id), array('class' => 'btn-ajax-modal')); ?>
                                    </h5>
                                </div>
                            <?php endif; ?>
 </div>
                        </div>
                     </div>

                       
                         
                  </div>
               </div>
               <?php endforeach; ?>
            </div>
         </div>
        </div>
    </div>
</div>
<div class="subMenu row text-center">
    <div class="col-sm-3 text-center align-middle">
        <div  class="subItems news" onclick="gotoContent('.newsContent');"><span>News & Activities</span></div>
    </div>

    <div class="col-sm-3 text-center align-middle">
        <div class="subItems" onclick="gotoContent('.downloadContent');">Download</div>
    </div>
    <div class="col-sm-3 text-center align-middle">
        <div class="subItems" onclick="gotoContent('.questionContent');">Q&A</div>
    </div>
    <div class="col-sm-3 text-center align-middle">
        <div class="subItems" onclick="gotoContent('.contactContent');">Contact Us</div>
    </div>
</div>
<div class="topic newsContent"><?php echo Helper::t('News &amp; Activities', 'News &amp; Activities'); ?></div>
<div style="display: flex; justify-content: center; flex-direction: column;">
    <div class="MultiCarousel" data-items="1,3,3,3" data-slide="1" id="MultiCarousel"  data-interval="1000">
        <div class="MultiCarousel-inner">
    <?php
    $this->widget('booster.widgets.TbListView', array(
        'itemView' => '/webContent/contentItem',
        'dataProvider' => $contentProvider,
        'template' => '{items} {pager}'
    ));
    ?>
        </div>
        <button class="btn btn-primary leftLst"><</button>
        <button class="btn btn-primary rightLst">></button>
    </div>
</div>
<div class="row">
    <div id="downloadSection" class="col-sm-6 downloadContent">
        <?php $this->renderPartial('/shared/document'); ?>
    </div>
    <div id="questionSection" class="col-sm-6 questionContent">
        <?php $this->renderPartial('/shared/question'); ?>
    </div>
</div>
<?php $this->renderPartial('/shared/contact'); ?>
<style>
    .text-black{
color:#535353;
    }
    .news-ticker {
        min-height: 30px;
        margin-bottom: 0 !important;
        padding-left: 0 !important;
    }
    .news-ticker > li{
        list-style: none;
    }
    .MultiCarousel { 
        float: left; 
        overflow: hidden; 
        padding: 15px; 
        width: 90%; 
        position:relative; 
        margin: 0 auto;
    }
    .MultiCarousel .MultiCarousel-inner { 
        transition: 1s ease all; 
        float: left; 
    }
    .MultiCarousel .MultiCarousel-inner .item { 
        float: left;
    }
    .MultiCarousel .MultiCarousel-inner .item > div { 
        text-align: center; 
        padding:10px; 
        margin:10px; 
        background:#f1f1f1; 
        color:#666;
    }
    .MultiCarousel .leftLst, .MultiCarousel .rightLst { 
        position:absolute; 
        border-radius:50%;
        top:calc(50% - 20px); 
    }
    .MultiCarousel .leftLst { 
        left:0; 
    }
    .MultiCarousel .rightLst { 
        right:0; 
    }
    .MultiCarousel .leftLst.over, .MultiCarousel .rightLst.over {
         pointer-events: none;
    }
    .unloaded {
        color: #428bca;
        font-size: 28px;
        cursor: pointer;
    }
    .loaded {
        color: #428bca;
        font-size: 28px;
        cursor: pointer;        
    }
    .loaded { 
        display: none; 
    }

    #downloadSection {
        position: relative;
    }
    #downloadSection ul li:nth-child(1n + 6) {
        height: 0;
        min-height: 0;
        opacity: 0;
        transition: 0.1s ease-in;
    }
    #downloadSection .unloaded:hover {
        color: #ccc;
    }
    #downloadSection .loaded:hover {
        color: #ccc;
    }
    #downloadSection .load-more-btn-download {
        margin: 0 auto;
        padding-right: 15px;
        display: block;
        text-align: right;
    }
    #downloadSection .load-more-btn-download .loaded {
        display: none;
    }
    #downloadSection #load-more-download {
        display: none;
    }
    #downloadSection #load-more-download:checked ~ ul li:nth-child(1n + 6) {
        opacity: 1;
        transition: 0.2s ease-in;
        min-height: 44px;
    }
    #downloadSection #load-more-download:checked ~ .load-more-btn-download .loaded {
        display: block;
    }
    #downloadSection #load-more-download:checked ~ .load-more-btn-download .unloaded {
        display: none;
    }
    #questionSection {
        position: relative;
    }
    #questionSection ul li:nth-child(1n + 6) {
        height: 0;
        min-height: 0;
        opacity: 0;
        transition: 0.1s ease-in;
    }
    #downloadSection .unloaded:hover {
        color: #ccc;
    }
    #downloadSection .loaded:hover {
        color: #ccc;
    }
    #questionSection .load-more-btn-question {
        margin: 0 auto;
        padding-right: 15px;
        display: block;
        text-align: right;
    }
    #questionSection .load-more-btn-question .loaded {
        display: none;
    }
    #questionSection #load-more-question {
        display: none;
    }
    #questionSection #load-more-question:checked ~ ul li:nth-child(1n + 6) {
        opacity: 1;
        transition: 0.2s ease-in;
        min-height: 44px;
    }
    #questionSection #load-more-question:checked ~ .load-more-btn-question .loaded {
        display: block;
    }
    #questionSection #load-more-question:checked ~ .load-more-btn-question .unloaded {
        display: none;
    }
</style>
<script type="text/javascript">
function gotoContent(selector) {
    $(window).scrollTop($(selector).position().top);
}
$(function () {
    $('.news-ticker').inewsticker({
		speed: 5000,
		effect: 'fade',
		dir: 'ltr',
        delay_after: 2000					
	});
});
$(document).ready(function () {
    var itemsMainDiv = ('.MultiCarousel');
    var itemsDiv = ('.MultiCarousel-inner');
    var itemWidth = "";

    $('.leftLst, .rightLst').click(function () {
        var condition = $(this).hasClass("leftLst");
        if (condition)
            click(0, this);
        else
            click(1, this)
    });

    ResCarouselSize();

    $(window).resize(function () {
        ResCarouselSize();
    });

    //this function define the size of the items
    function ResCarouselSize() {
        var incno = 0;
        var dataItems = ("data-items");
        var itemClass = ('.item');
        var id = 0;
        var btnParentSb = '';
        var itemsSplit = '';
        var sampwidth = $(itemsMainDiv).width();
        var bodyWidth = $('body').width();
        $(itemsDiv).each(function () {
            id = id + 1;
            var itemNumbers = $(this).find(itemClass).length;
            btnParentSb = $(this).parent().attr(dataItems);
            itemsSplit = btnParentSb.split(',');
            $(this).parent().attr("id", "MultiCarousel" + id);


            if (bodyWidth >= 1200) {
                incno = itemsSplit[3];
                itemWidth = sampwidth / incno;
            }
            else if (bodyWidth >= 992) {
                incno = itemsSplit[2];
                itemWidth = sampwidth / incno;
            }
            else if (bodyWidth >= 768) {
                incno = itemsSplit[1];
                itemWidth = sampwidth / incno;
            }
            else {
                incno = itemsSplit[0];
                itemWidth = sampwidth / incno;
            }
            $(this).css({ 'transform': 'translateX(0px)', 'width': itemWidth * itemNumbers });
            $(this).find(itemClass).each(function () {
                $(this).outerWidth(itemWidth);
            });

            $(".leftLst").addClass("over");
            $(".rightLst").removeClass("over");

        });
    }

    //this function used to move the items
    function ResCarousel(e, el, s) {
        var leftBtn = ('.leftLst');
        var rightBtn = ('.rightLst');
        var translateXval = '';
        var divStyle = $(el + ' ' + itemsDiv).css('transform');
        var values = divStyle.match(/-?[\d\.]+/g);
        var xds = Math.abs(values[4]);
        if (e == 0) {
            translateXval = parseInt(xds) - parseInt(itemWidth * s);
            $(el + ' ' + rightBtn).removeClass("over");

            if (translateXval <= itemWidth / 2) {
                translateXval = 0;
                $(el + ' ' + leftBtn).addClass("over");
            }
        }
        else if (e == 1) {
            var itemsCondition = $(el).find(itemsDiv).width() - $(el).width();
            translateXval = parseInt(xds) + parseInt(itemWidth * s);
            $(el + ' ' + leftBtn).removeClass("over");

            if (translateXval >= itemsCondition - itemWidth / 2) {
                translateXval = itemsCondition;
                $(el + ' ' + rightBtn).addClass("over");
            }
        }
        $(el + ' ' + itemsDiv).css('transform', 'translateX(' + -translateXval + 'px)');
    }

    //It is used to get some elements from btn
    function click(ell, ee) {
        var Parent = "#" + $(ee).parent().attr("id");
        var slide = $(Parent).attr("data-slide");
        ResCarousel(ell, Parent, slide);
    }
});
</script>