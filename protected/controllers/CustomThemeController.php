<?php

class CustomThemeController extends Controller {

   public function init()
   {
      $this->layout = false;
   }

   public function accessRules() {
      return array(
          array(
              'allow',
              'users' => array('*'),
          ),
      );
   }

   private function getThemeConfigurations($theme) {
      return array(
          'header_bgColor' => Configuration::getKey($theme. '_header_bgColor'),
          'subMenu_bgColor' => Configuration::getKey($theme.'_submenu_bgColor'),
          'menu_bgColor' => Configuration::getKey($theme.'_menu_bgColor'),
          'body_bgColor' => Configuration::getKey($theme.'_body_bgColor'),
          'header_bgSrc' => Configuration::getKey($theme.'_header_bgSrc'),
          'menu_bgSrc' => Configuration::getKey($theme.'_menu_bgSrc'),
          'body_bgSrc' => Configuration::getKey($theme.'_body_bgSrc'),
          'subMenu_bgSrc' => Configuration::getKey($theme.'_submenu_bgSrc'),
          // 'base_fontSize' => Configuration::getKey($theme.'_base_fontSize'),
          'menu_fontSize' => Configuration::getKey($theme.'_menu_fontSize'),
          'subMenu_fontSize' => Configuration::getKey($theme.'_submenu_fontSize'),
          // 'heading_fontSize' => Configuration::getKey($theme.'_heading_fontSize'),
          // 'content_fontSize' => Configuration::getKey($theme.'_content_fontSize'),
          // 'base_fontColor' => Configuration::getKey($theme.'_base_fontColor'),
          'menu_fontColor' => Configuration::getKey($theme.'_menu_fontColor'),
          'menuLink_fontColor' => Configuration::getKey($theme.'_menuLink_fontColor'),
          // 'menuALink_fontColor' => Configuration::getKey($theme.'_menuALink_fontColor'),
          'menuHLink_fontColor' => Configuration::getKey($theme.'_menuHLink_fontColor'),
          'menuALink_bgColor' => Configuration::getKey($theme.'_menuALink_bgColor'),
          'subMenu_fontColor' => Configuration::getKey($theme.'_submenu_fontColor'),
          'heading_fontColor' => Configuration::getKey($theme.'_heading_fontColor'),
          // 'content_fontColor' => Configuration::getKey($theme.'_content_fontColor'),
      );
   }

   /**
    * This is the default 'index' action that is invoked
    * when an action is not explicitly requested by users.
    */
   public function actionIndex() {
      $theme = Configuration::getKey('web_template');
      $configurations = $this->getThemeConfigurations($theme);
      $this->render('index', array(
          'configurations' => $configurations,
      ));
   }
}
