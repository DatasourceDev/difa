<?php

class QzTrayDownloadAction extends CAction {

    public function run() {
        Yii::app()->request->sendFile('qz-tray-1.9.5.exe', file_get_contents(dirname(__FILE__) . '/../data/qz-dist/qz-tray-1.9.5.exe'));
    }

}
