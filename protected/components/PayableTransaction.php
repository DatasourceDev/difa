<?php

interface PayableTransaction {

    public function getIsPaid();

    public function getIsExpired();

    public function findByRef($ref1, $ref2);

    public function validatePaymentAmount($amount);

    public function doPaid();

    public function getScheduleOnDateRange();
}
