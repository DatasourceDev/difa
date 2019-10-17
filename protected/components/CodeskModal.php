<?php

Yii::import('booster.widgets.TbModal');

class CodeskModal extends TbModal {

    public function init() {

        if (!isset($this->htmlOptions['id'])) {
            $this->htmlOptions['id'] = $this->getId();
        }

        if ($this->autoOpen === false && !isset($this->options['show'])) {
            $this->options['show'] = false;
        }

        $classes = array('modal');

        if ($this->fade === true) {
            $classes[] = 'fade';
        }

        if (!empty($classes)) {
            $classes = implode(' ', $classes);
            if (isset($this->htmlOptions['class'])) {
                $this->htmlOptions['class'] .= ' ' . $classes;
            } else {
                $this->htmlOptions['class'] = $classes;
            }
        }
        echo CHtml::openTag('div', $this->htmlOptions);
        echo '<div class="modal-dialog modal-lg"><div class="modal-content">';
    }

}
