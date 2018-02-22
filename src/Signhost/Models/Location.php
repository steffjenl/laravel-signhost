<?php
namespace Signhost\Models;


class Location
{
    public $Search; // String
    public $Occurence; // Integer
    public $Top; // Integer
    public $Right; // Integer
    public $Bottom; // Integer
    public $Left; // Integer
    public $Width; // Integer
    public $Height; // Integer
    public $PageNumber; // Integer

    function __construct(
        $search = null,
        $occurence = null,
        $top = null,
        $right = null,
        $bottom = null,
        $left = null,
        $width = null,
        $height = null,
        $pageNumber = null) {
        $this->Search = $search;
        $this->Occurence = $occurence;
        $this->Top = $top;
        $this->Right = $right;
        $this->Bottom = $bottom;
        $this->Left = $left;
        $this->Width = $width;
        $this->Height = $height;
        $this->PageNumber = $pageNumber;
    }
}