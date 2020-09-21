<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/js/vendor/slick-1.8.1/slick/slick.css'); ?>
<?php Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/js/vendor/slick-1.8.1/slick/slick-theme.css'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/vendor/slick-1.8.1/slick/slick.min.js', CClientScript::POS_END); ?>
<?php
$arr =  WebSlider::getSilderIndexArray();
?>
<div class="slideshow slideshow-main" id="slideshow-main">
   <?php for ($index = 1; $index <= 20; $index++):?>
   <?php $i =array_shift($arr); ?>
   <?php if(WebSlider::hasData($i) && WebSlider::showSlider($i)): ?>
   <?php if(WebSlider::isImage($i)): ?>
   <div class="slideshow-item">
      <div class="image-slideshow-container" data-url="<?php echo Configuration::getKey('web_slider_url' . $i); ?>">
         <?php echo CHtml::image(WebSlider::getAssetUrl($i) . '?_=' . time()); ?>
      </div><!-- .slideshow-container -->
   </div><!-- .slideshow-item -->
   <?php else: ?>
   <div class="slideshow-item">
      <div class="image-slideshow-container">
         <video class="slide-video slide-media" controls muted id="video<?php echo $i; ?>" onended="video_onended()">
            <source src="<?php echo WebSlider::getAssetUrl($i) ?>">
         </video>
      </div><!-- .slideshow-container -->
   </div><!-- .slideshow-item -->
   <?php endif ?>
   <?php endif ?>
   <?php endfor ?>
</div>
<script type="text/javascript">

   var sliderurl = '';
   var dragging = false;
   var video;

   $(document).ready(function () {

      var slider = $('#slideshow-main').slick({
         arrows: true,
         autoplay: true,
         autoplaySpeed: 5000,
         dots: true,
      });

      $(".image-slideshow-container").on("mousedown", function (e) {
         sliderurl = $(this).attr('data-url');
         var x = e.screenX;
         var y = e.screenY;
         dragging = false;
         $(".image-slideshow-container").on("mousemove", function (e) {
            if (Math.abs(x - e.screenX) > 5 || Math.abs(y - e.screenY) > 5) {
               dragging = true;
            }
         });
      });
      $(".image-slideshow-container").on("mouseup", function (e) {
         $(".image-slideshow-container").off("mousemove");
         if (dragging == false && sliderurl != null && sliderurl != '') {
            window.open(sliderurl);
            sliderurl = '';
         }
      });

      var index = parseInt(1);
      if ($('#video' + index).get(0) != null) {
         slider.slick('slickPause');
         video = $('#video' + index)[0];
         video.load();
         video.play();
      }

      $('#slideshow-main').on('afterChange', function (event, slick, currentSlide, nextSlide) {
         if (video != null) {
            video.pause();
         }
         var index = parseInt(currentSlide) + 1;
         if ($('#video' + index).get(0) != null) {
            slider.slick('slickPause');
            video = $('#video' + index)[0];
            video.load();
            video.play();
         }

      });
   });
   function video_onended() {
      $('#slideshow-main').slick('slickPlay');
   }
</script>
<style>
   .slideshow-main {
      font-family: "Cloud", sans-serif;
      text-align: center;
      margin-bottom: 60px !important;
      max-width: 350px;
   }

   .slick-prev {
      left: -40px;
      display: none !important;
   }

   .slick-next {
      display: none !important;
   }

   .slick-prev:before {
      color: #428bca;
      font-size: 35px;
   }

   .slick-next:before {
      color: #428bca;
      font-size: 35px;
   }

   .slideshow-main h1,
   .slideshow-main h2,
   .slideshow-main h3,
   .slideshow-main h4,
   .slideshow-main h5,
   .slideshow-main h6,
   .slideshow-main p {
      margin: 0;
      padding: 0;
   }

   .slideshow-main img, video {
      display: inline;
      height: 200px;
      width: 100%;
   }

   .slideshow-item {
      background-color: #fff;
   }

   .slideshow-container {
      padding-top: 100px;
      padding-bottom: 40px;
   }

   .slideshow-button-container {
      margin-top: 2em;
   }

      .slideshow-button-container .button {
         margin-left: 1em;
         margin-bottom: 0;
         display: inline-block;
         width: auto;
      }

         .slideshow-button-container .button:first-child {
            margin-left: 0;
         }

   .slideshow-image-container {
      padding: 1em;
      text-align: center;
   }

   .slideshow-main .slick-dots {
      position: absolute;
      bottom: -30px;
      left: 0;
      right: 0;
      list-style: none;
      margin: 0;
      padding: 0 1em;
      text-align: center;
      height: 30px;
   }

      .slideshow-main .slick-dots li {
         display: inline-block;
         margin: 0 5px;
      }

         .slideshow-main .slick-dots li button {
            cursor: pointer;
            background: #fff;
            border: 0 none;
            -webkit-box-shadow: 1px 3px 10px rgba(0, 0, 0, 0.5);
            -moz-box-shadow: 1px 3px 10px rgba(0, 0, 0, 0.5);
            box-shadow: 1px 3px 10px rgba(0, 0, 0, 0.5);
            color: #fff;
            -webkit-border-radius: 50%;
            -moz-border-radius: 50%;
            border-radius: 50%;
            overflow: hidden;
            width: 10px;
            height: 10px;
            padding: 0;
         }

      .slideshow-main .slick-dots .slick-active button {
         background: #428bca;
         color: #428bca;
      }

   .slick-dots li button:before {
      display: none;
   }

   @media (min-width: 768px) {
      .slideshow-main {
         font-size: 1.25em;
         max-width: 100%;
      }

         .slideshow-main img, video {
            width: 100%;
            height: 100%;
         }

      .slick-prev {
         display: block !important;
      }

      .slick-next {
         display: block !important;
      }
   }

   .slick-slide video {
      display: none !important;
   }

   .slick-slide.slick-current.slick-active video {
      display: block !important;
   }

   @media (min-width: 992px) {
      .slideshow-main {
         text-align: left;
         font-size: 1.5em;
         max-width: 100%;
      }

         .slideshow-main img {
            width: 100%;
            height: 100%;
         }

         .slideshow-main video {
            width: 100%;
            height: 100%;
         }

      .slideshow-button-container {
         margin-top: 3em;
      }

      .slideshow-container {
         padding-top: 100px;
         padding-bottom: 40px;
         display: -webkit-box;
         display: -webkit-flex;
         display: -moz-box;
         display: -ms-flexbox;
         display: flex;
         -webkit-flex-wrap: wrap;
         -ms-flex-wrap: wrap;
         flex-wrap: wrap;
         -webkit-box-orient: horizontal;
         -webkit-box-direction: normal;
         -webkit-flex-direction: row;
         -moz-box-orient: horizontal;
         -moz-box-direction: normal;
         -ms-flex-direction: row;
         flex-direction: row;
         -webkit-box-pack: center;
         -webkit-justify-content: center;
         -moz-box-pack: center;
         -ms-flex-pack: center;
         justify-content: center;
      }

      .slideshow-reverse-container {
         -webkit-box-orient: horizontal;
         -webkit-box-direction: reverse;
         -webkit-flex-direction: row-reverse;
         -moz-box-orient: horizontal;
         -moz-box-direction: reverse;
         -ms-flex-direction: row-reverse;
         flex-direction: row-reverse;
      }

      .slideshow-left-container,
      .slideshow-right-container {
         -webkit-flex-basis: 50%;
         -ms-flex-preferred-size: 50%;
         flex-basis: 50%;
         display: -webkit-box;
         display: -webkit-flex;
         display: -moz-box;
         display: -ms-flexbox;
         display: flex;
         -webkit-box-orient: vertical;
         -webkit-box-direction: normal;
         -webkit-flex-direction: column;
         -moz-box-orient: vertical;
         -moz-box-direction: normal;
         -ms-flex-direction: column;
         flex-direction: column;
         -webkit-box-pack: center;
         -webkit-justify-content: center;
         -moz-box-pack: center;
         -ms-flex-pack: center;
         justify-content: center;
      }

         .slideshow-right-container .slideshow-image-container {
            padding: 0 0 0 1em;
         }

         .slideshow-left-container .slideshow-image-container {
            padding: 0 1em 0 0;
         }
   }

   .image-slideshow-full {
      display: block !important;
   }

   .image-slideshow-mobile {
      display: none !important;
   }

   .image-slidetop-full {
      display: inline !important;
      height: 350px;
   }

   .image-slidetop-mobile {
      display: none !important;
      height: 180px;
   }

   @media (max-width: 992px) {
      .slideshow-container {
         padding-bottom: 0px;
         padding-top: 20px;
      }

      .image-slidetop-full {
         height: 250px;
      }
   }

   @media (max-width: 640px) and (min-width: 320px) {
      .image-slideshow-full {
         display: none !important;
      }

      .image-slideshow-mobile {
         display: block !important;
      }

      .image-slidetop-full {
         display: none !important;
         height: 350px;
      }

      .image-slidetop-mobile {
         display: inline !important;
         height: 180px;
      }

      .slideshow-container {
         padding-bottom: 0px;
         padding-top: 20px;
      }
   }
</style>

