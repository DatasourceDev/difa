<?php

class ExecComponent extends CApplicationComponent {

    public $php = 'php';
    public $output;

    public function run($command, $params = array()) {
        $parameters = '';
        foreach ($params as $key => $value) {
            $parameters .= '--' . $key . '=' . $value . ' ';
        }
        $action = $this->php . ' ' . Yii::getPathOfAlias('webroot') . '/run.php' . ' ' . $command . ' ' . $parameters;

        Yii::log(str_replace('\\', '\\\\', $action), CLogger::LEVEL_WARNING);

        if (substr(php_uname(), 0, 7) == "Windows") {
            pclose(popen("start /B " . str_replace('\\', '\\\\', $action), "r"));
        } else {
            exec($action . " > /dev/null &");
        }
    }

    public function runAndWait($command, $params = array()) {
        $parameters = '';
        foreach ($params as $key => $value) {
            $parameters .= '--' . $key . '=' . $value . ' ';
        }
        $action = $this->php . ' ' . Yii::getPathOfAlias('webroot') . '/run.php' . ' ' . $command . ' ' . $parameters;

        if (substr(php_uname(), 0, 7) == "Windows") {
            pclose(popen("start " . $action, "r"));
        } else {
            exec($action, $this->output);
        }
    }

}

?>
