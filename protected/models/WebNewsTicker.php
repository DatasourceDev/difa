<?php

class WebNewsTicker extends CFormModel {

    const NOT_USE = 0;
    const USE_TICKER = 1;

    public $web_news_ticker;
    public $custom_content1;
    public $custom_content2;
    public $custom_content3;
    public $custom_new1;
    public $custom_new2;
    public $custom_new3;
    public $web_news_ticker1;
    public $web_news_ticker2;
    public $web_news_ticker3;

    public $custom_date_from1;
    public $custom_date_from2;
    public $custom_date_from3;

    public $custom_date_to1;
    public $custom_date_to2;
    public $custom_date_to3;

    public function init() {
        parent::init();
        $this->web_news_ticker = Configuration::getKey('web_news_ticker');
        $this->custom_content1 = Configuration::getKey('custom_content1');
        $this->custom_content2 = Configuration::getKey('custom_content2');
        $this->custom_content3 = Configuration::getKey('custom_content3');
        $this->custom_new1 = Configuration::getKey('custom_new1');
        $this->custom_new2 = Configuration::getKey('custom_new2');
        $this->custom_new3 = Configuration::getKey('custom_new3');
        $this->web_news_ticker1 = Configuration::getKey('web_news_ticker1');
        $this->web_news_ticker2 = Configuration::getKey('web_news_ticker2');
        $this->web_news_ticker3 = Configuration::getKey('web_news_ticker3');
        $this->custom_date_from1 = Configuration::getKey('custom_date_from1');
        $this->custom_date_from2 = Configuration::getKey('custom_date_from2');
        $this->custom_date_from3 = Configuration::getKey('custom_date_from3');
        $this->custom_date_to1 = Configuration::getKey('custom_date_to1');
        $this->custom_date_to2 = Configuration::getKey('custom_date_to2');
        $this->custom_date_to3 = Configuration::getKey('custom_date_to3');
    }

    public function attributeLabels() {
        return array(
            'web_news_ticker' => 'รูปแบบ',
            'custom_content1' => '',
            'custom_content2' => '',
            'custom_content3' => '',
            'web_news_ticker1' => '1',
            'web_news_ticker2' => '2',
            'web_news_ticker3' => '3',
            'custom_date_from1' => '',
            'custom_date_from2' => '',
            'custom_date_from3' => '',
            'custom_date_to1' => '',
            'custom_date_to2' => '',
            'custom_date_to3' => '',
        );
    }

    public function rules() {
        return array(
            array('custom_content1', 'length', 'min' => 0, 'max' => 250),
            array('custom_content2', 'length', 'min' => 0, 'max' => 250),
            array('custom_content3', 'length', 'min' => 0, 'max' => 250),
        );
    }

    public static function useNewsTickerOptions() {
        return Configuration::getKey('web_news_ticker', 0) == 0 ? false : true;
    }

	public static function useNewsTicker1Options() {
        return Configuration::getKey('web_news_ticker1', 0) == 0 ? false : true;
    }

	public static function useNewsTicker2Options() {
        return Configuration::getKey('web_news_ticker2', 0) == 0 ? false : true;
    }

	public static function useNewsTicker3Options() {
        return Configuration::getKey('web_news_ticker3', 0) == 0 ? false : true;
    }

    public static function getUseNewsTickerOptions($code = null) {
        $ret = array(
            self::NOT_USE => 'News & Activities ล่าสุด 3 รายการ',
            self::USE_TICKER => 'กำหนดเอง',
        );
        return isset($code) ? $ret[$code] : $ret;
    }

    public static function getUseNewsTickerCustomOptions($code = null) {
        $ret = array(
            self::NOT_USE => 'News & Activities',
            self::USE_TICKER => 'กำหนดเอง',
        );
        return isset($code) ? $ret[$code] : $ret;
    }

    public function save() {
        if ($this->validate()) {
            Configuration::setKey('web_news_ticker', $this->web_news_ticker);
            Configuration::setKey('custom_content1', $this->custom_content1);
            Configuration::setKey('custom_content2', $this->custom_content2);
            Configuration::setKey('custom_content3', $this->custom_content3);
            Configuration::setKey('custom_new1', $this->custom_new1);
            Configuration::setKey('custom_new2', $this->custom_new2);
            Configuration::setKey('custom_new3', $this->custom_new3);
            Configuration::setKey('web_news_ticker1', $this->web_news_ticker1);
            Configuration::setKey('web_news_ticker2', $this->web_news_ticker2);
            Configuration::setKey('web_news_ticker3', $this->web_news_ticker3);

            Configuration::setKey('custom_date_from1', $this->custom_date_from1);
            Configuration::setKey('custom_date_from2', $this->custom_date_from2);
            Configuration::setKey('custom_date_from3', $this->custom_date_from3);
            Configuration::setKey('custom_date_to1', $this->custom_date_to1);
            Configuration::setKey('custom_date_to2', $this->custom_date_to2);
            Configuration::setKey('custom_date_to3', $this->custom_date_to3);
            return true;
        }
    }

}
