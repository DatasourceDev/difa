<?php

Yii::import('booster.widgets.TbActiveForm');

class CodeskActiveForm extends TbActiveForm {

    public $formSize = 'default';

    public function labelEx($model, $attribute, $htmlOptions = array()) {
        return Helper::activeLabelEx($model, $attribute, $htmlOptions);
    }

    protected function horizontalGroup(&$fieldData, &$model, &$attribute, &$options) {

        $groupOptions = isset($options['groupOptions']) ? $options['groupOptions'] : array(); // array('class' => 'form-group');
        self::addCssClass($groupOptions, 'form-group');

        if ($model->hasErrors($attribute))
            self::addCssClass($groupOptions, 'has-error');

        echo CHtml::openTag('div', $groupOptions);

        switch ($this->formSize) {
            case 'small':
                self::addCssClass($options['labelOptions'], 'col-sm-4 control-label');
                break;
            default:
                self::addCssClass($options['labelOptions'], 'col-sm-3 control-label');
                break;
        }
        if (isset($options['label'])) {
            if (!empty($options['label'])) {
                echo CHtml::label($options['label'], CHtml::activeId($model, $attribute), $options['labelOptions']);
            } else {
                switch ($this->formSize) {
                    case 'small':
                        echo '<span class="col-sm-3"></span>';
                        break;
                    default:
                        echo '<span class="col-sm-4"></span>';
                        break;
                }
            }
        } else {
            echo $this->labelEx($model, $attribute, $options['labelOptions']);
        }

        // TODO: is this good to be applied in vertical and inline?
        if (isset($options['wrapperHtmlOptions']) && !empty($options['wrapperHtmlOptions']))
            $wrapperHtmlOptions = $options['wrapperHtmlOptions'];
        else
            $wrapperHtmlOptions = $options['wrapperHtmlOptions'] = array();
        switch ($this->formSize) {
            case 'small':
                $this->addCssClass($wrapperHtmlOptions, 'col-sm-8');
                break;
            default:
                $this->addCssClass($wrapperHtmlOptions, 'col-sm-9');
                break;
        }
        echo CHtml::openTag('div', $wrapperHtmlOptions);

        if (!empty($options['prepend']) || !empty($options['append'])) {
            $this->renderAddOnBegin($options['prepend'], $options['append'], $options['prependOptions']);
        }

        if (is_array($fieldData)) {
            echo call_user_func_array($fieldData[0], $fieldData[1]);
        } else {
            echo $fieldData;
        }

        if (!empty($options['prepend']) || !empty($options['append'])) {
            $this->renderAddOnEnd($options['append'], $options['appendOptions']);
        }

        if ($this->showErrors && $options['errorOptions'] !== false) {
            echo $this->error($model, $attribute, $options['errorOptions'], $options['enableAjaxValidation'], $options['enableClientValidation']);
        }

        if (isset($options['hint'])) {
            self::addCssClass($options['hintOptions'], $this->hintCssClass);
            echo CHtml::tag($this->hintTag, $options['hintOptions'], $options['hint']);
        }

        echo '</div></div>'; // controls, form-group
    }

}
