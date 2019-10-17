<?php

class GetController extends Controller {

    public function accessRules() {
        return array(
            array(
                'allow',
                'users' => array('*'),
            ),
        );
    }

    public function actionDownloadDocument($id) {
        $model = WebDownload::model()->findByPk($id);
        try {
            $model->doDownload();
        } catch (CException $e) {
            Yii::app()->user->setFlash('success', Helper::MSG_ERROR);
            $this->redirect(Yii::app()->homeUrl);
        }
    }
    public function actionDownloadMap() {
        $model = new WebContactUs;
        try {
            $model->doDownload();
        }
        catch (CException $e) {
            Yii::app()->user->setFlash('success', Helper::MSG_ERROR);
            $this->redirect(Yii::app()->homeUrl);
        }
    }
    public function actionDownloadSelfExample() {
        Yii::app()->request->sendFile('self-approve.pdf', file_get_contents(Yii::getPathOfAlias('application.data.template.pdf') . '/self-approve-latest.pdf'));
    }

    public function actionDownloadTermOfRegister() {
        Yii::app()->request->sendFile('term-registration.pdf', file_get_contents(Yii::getPathOfAlias('application.data.template.pdf') . '/term-register.pdf'));
    }

    public function actionDownloadExampleOfTest() {
        Yii::app()->request->sendFile('usage-of-example.pdf', file_get_contents(Yii::getPathOfAlias('application.data.template.pdf') . '/example-of-test.pdf'));
    }

    public function actionQr($code) {
        Yii::import('application.vendors.phpqrcode.qrlib', true);
        QRcode::png($code, false, QR_ECLEVEL_L, 2);
    }

    public function actionBarcode($code) {
        require Yii::getPathOfAlias('application.vendors.barcodegen.class') . '/BCGFontFile.php';
        require Yii::getPathOfAlias('application.vendors.barcodegen.class') . '/BCGColor.php';
        require Yii::getPathOfAlias('application.vendors.barcodegen.class') . '/BCGDrawing.php';
        require Yii::getPathOfAlias('application.vendors.barcodegen.class') . '/BCGcode128.barcode.php';
        $font = new BCGFontFile(Yii::getPathOfAlias('application.vendors.barcodegen') . '/font/Arial.ttf', 18);

        $color_black = new BCGColor(0, 0, 0);
        $color_white = new BCGColor(255, 255, 255);

        $drawException = null;
        try {
            $barcode = new BCGcode128();
            $barcode->setScale(2); // Resolution
            $barcode->setThickness(30); // Thickness
            $barcode->setForegroundColor($color_black); // Color of bars
            $barcode->setBackgroundColor($color_white); // Color of spaces
            $barcode->setFont($font); // Font (or 0)
            $barcode->parse($code); // Text
        } catch (Exception $exception) {
            $drawException = $exception;
        }

        $drawing = new BCGDrawing('', $color_white);
        if ($drawException) {
            $drawing->drawException($drawException);
        } else {
            $drawing->setBarcode($barcode);
            $drawing->draw();
        }
        header('Content-Type: image/png');
        header('Content-Disposition: inline; filename="barcode.png"');
        $drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
    }

}
