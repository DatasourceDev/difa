<?php

class CodeskFormatter extends CFormatter {

    public function formatMoney($val) {
        return number_format($val, 2, '.', ',');
    }

}
