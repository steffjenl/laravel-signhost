<?php
namespace Signhost\Models;


class iDEALVerification
{
    public $Iban;

    /**
     * @return null
     */
    public function getIban()
    {
        return $this->Iban;
    }

    /**
     * @param null $Iban
     * @return iDEALVerification
     */
    public function setIban($Iban)
    {
        $this->Iban = $Iban;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAccountHolderName()
    {
        return $this->AccountHolderName;
    }

    /**
     * @param mixed $AccountHolderName
     * @return iDEALVerification
     */
    public function setAccountHolderName($AccountHolderName)
    {
        $this->AccountHolderName = $AccountHolderName;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAccountHolderCity()
    {
        return $this->AccountHolderCity;
    }

    /**
     * @param mixed $AccountHolderCity
     * @return iDEALVerification
     */
    public function setAccountHolderCity($AccountHolderCity)
    {
        $this->AccountHolderCity = $AccountHolderCity;

        return $this;
    } // String
    public $AccountHolderName; // String
    public $AccountHolderCity; // String

    function __construct($type, $iban = null) {
        parent::__construct($type);
        $this->Iban = $iban;
    }
}