<?php

class WebContactUs extends CFormModel {

    public $map_src;
    public $address;
    public $tel;
    public $fax;
    public $data_json;
    public $original_src;
    public $googlemap;

    public function init() {
        parent::init();
        $this->data_json = Configuration::getKey('web_contact_us');
        $decode_json = json_decode($this->data_json, true);
        if (isset($decode_json)) {
            foreach ($decode_json as $key => $val) {
                $this->{$key} = $val;
            }
            $this->original_src = $this->map_src;
        }
    }

    public function attributeLabels() {
        return array(
            'map_src' => 'แผนที่รูปแบบ PDF',
            'address' => 'ที่อยู่',
            'tel' => 'โทร',
            'fax' => 'Fax',
            'googlemap' => 'Google Map',
        );
    }

    public function rules() {
        return array(
            array('map_src', 'file', 'allowEmpty' => true, 'types' => array('pdf')),
            array('address', 'length', 'min' => 0, 'max' => 500),
            array('tel', 'length', 'min' => 0, 'max' => 20),
            array('fax', 'length', 'min' => 0, 'max' => 20),
        );
    }

    private function createJsonFromData() {
        return json_encode(array(
            'map_src' => $this->map_src,
            'address' => $this->address,
            'tel' => $this->tel,
            'fax' => $this->fax,
            'googlemap' => $this->googlemap,
        ));
    }

    private function uploadFile() {
        $file = CUploadedFile::getInstance($this, 'map_src');
        if (isset($file)) {
            $filename = '/uploads/web/web_contact_us.' . strtolower($file->getExtensionName());
            $this->map_src = $filename;
            if ($file->saveAs(Yii::getPathOfAlias('webroot') . $filename)) {
            }
        } else {
            $this->map_src = $this->original_src;
        }
    }

    public function doDownload() {
        Yii::app()->request->sendFile(basename($this->map_src), file_get_contents(Yii::getPathOfAlias('webroot') . $this->map_src));
    }
    public function save() {
        if ($this->validate()) {
            $this->uploadFile();
            Configuration::setKey('web_contact_us', $this->createJsonFromData());
            return true;
        }
    }

    public function removeImage() {
        $fileName = $this->map_src;
        $this->map_src = null;
        if (isset($fileName)) {
         unlink(Yii::getPathOfAlias('webroot')  .  $fileName);
        }
        Configuration::setKey('web_contact_us', $this->createJsonFromData());
        return $fileName;
    }

}
