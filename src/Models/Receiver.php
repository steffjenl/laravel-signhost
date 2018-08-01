<?php
namespace Signhost\Models;


class Receiver
{
    public $Name;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->Name;
    }

    /**
     * @param mixed $Name
     * @return Receiver
     */
    public function setName($Name)
    {
        $this->Name = $Name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->Email;
    }

    /**
     * @param mixed $Email
     * @return Receiver
     */
    public function setEmail($Email)
    {
        $this->Email = $Email;

        return $this;
    }

    /**
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->Language;
    }

    /**
     * @param string $Language
     * @return Receiver
     */
    public function setLanguage(string $Language): Receiver
    {
        $this->Language = $Language;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->Message;
    }

    /**
     * @param mixed $Message
     * @return Receiver
     */
    public function setMessage($Message)
    {
        $this->Message = $Message;

        return $this;
    }

    /**
     * @return null
     */
    public function getReference()
    {
        return $this->Reference;
    }

    /**
     * @param null $Reference
     * @return Receiver
     */
    public function setReference($Reference)
    {
        $this->Reference = $Reference;

        return $this;
    }

    /**
     * @return null
     */
    public function getContext()
    {
        return $this->Context;
    }

    /**
     * @param null $Context
     * @return Receiver
     */
    public function setContext($Context)
    {
        $this->Context = $Context;

        return $this;
    } // String
    public $Email; // String
    public $Language; // String (enum)
    public $Message; // String
    public $Reference; // String
    public $Context; // Any object

    function __construct(
        $name,
        $email,
        $message,
        $language = "nl-NL",
        $reference = null,
        $context = null) {
        $this->Name = $name;
        $this->Email = $email;
        $this->Language = $language;
        $this->Message = $message;
        $this->Reference = $reference;
        $this->Context = $context;
    }
}