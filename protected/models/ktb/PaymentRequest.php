<?php

/**
 * @soap-indicator sequence
 */
class PaymentRequest {

    /**
     * @var string {minOccurs=0, maxOccurs=1}
     * @soap
     */
    public $User;

    /**
     * @var string {minOccurs=0, maxOccurs=1}
     * @soap
     */
    public $Password;

    /**
     * @var string {minOccurs=0, maxOccurs=1}
     * @soap
     */
    public $ComCode;

    /**
     * @var string {minOccurs=0, maxOccurs=1}
     * @soap
     */
    public $ProdCode;

    /**
     * @var string {minOccurs=0, maxOccurs=1}
     * @soap
     */
    public $Command;

    /**
     * @var int {minOccurs=0, maxOccurs=1}
     * @soap
     */
    public $BankCode;

    /**
     * @var string {minOccurs=1, maxOccurs=1}
     * @soap
     */
    public $BankRef;

    /**
     * @var string {minOccurs=0, maxOccurs=1}
     * @soap
     */
    public $DateTime;

    /**
     * @var string {minOccurs=0, maxOccurs=1}
     * @soap
     */
    public $TranxId;

    /**
     * @var string {minOccurs=0, maxOccurs=1}
     * @soap
     */
    public $EffDate;

    /**
     * @var string {minOccurs=0, maxOccurs=1}
     * @soap
     */
    public $Channel;

    /**
     * @var float {minOccurs=0, maxOccurs=1}
     * @soap
     */
    public $Amount;

    /**
     * @var string {minOccurs=1, maxOccurs=1}
     * @soap
     */
    public $CusName;

    /**
     * @var string {minOccurs=0, maxOccurs=1}
     * @soap
     */
    public $Ref1;

    /**
     * @var string {minOccurs=0, maxOccurs=1}
     * @soap
     */
    public $Ref2;

    /**
     * @var string {minOccurs=0, maxOccurs=1}
     * @soap
     */
    public $Ref3;

    /**
     * @var string {minOccurs=0, maxOccurs=1}
     * @soap
     */
    public $Ref4;

}
