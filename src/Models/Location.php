<?php
namespace Signhost\Models;


class Location
{
    public $Search; // String
    public $Occurence; // Integer
    public $Top; // Integer
    public $Right; // Integer
    public $Bottom;

    /**
     * @return null
     */
    public function getSearch()
    {
        return $this->Search;
    }

    /**
     * @param null $Search
     * @return Location
     */
    public function setSearch($Search)
    {
        $this->Search = $Search;

        return $this;
    }

    /**
     * @return null
     */
    public function getOccurence()
    {
        return $this->Occurence;
    }

    /**
     * @param null $Occurence
     * @return Location
     */
    public function setOccurence($Occurence)
    {
        $this->Occurence = $Occurence;

        return $this;
    }

    /**
     * @return null
     */
    public function getTop()
    {
        return $this->Top;
    }

    /**
     * @param null $Top
     * @return Location
     */
    public function setTop($Top)
    {
        $this->Top = $Top;

        return $this;
    }

    /**
     * @return null
     */
    public function getRight()
    {
        return $this->Right;
    }

    /**
     * @param null $Right
     * @return Location
     */
    public function setRight($Right)
    {
        $this->Right = $Right;

        return $this;
    }

    /**
     * @return null
     */
    public function getBottom()
    {
        return $this->Bottom;
    }

    /**
     * @param null $Bottom
     * @return Location
     */
    public function setBottom($Bottom)
    {
        $this->Bottom = $Bottom;

        return $this;
    }

    /**
     * @return null
     */
    public function getLeft()
    {
        return $this->Left;
    }

    /**
     * @param null $Left
     * @return Location
     */
    public function setLeft($Left)
    {
        $this->Left = $Left;

        return $this;
    }

    /**
     * @return null
     */
    public function getWidth()
    {
        return $this->Width;
    }

    /**
     * @param null $Width
     * @return Location
     */
    public function setWidth($Width)
    {
        $this->Width = $Width;

        return $this;
    }

    /**
     * @return null
     */
    public function getHeight()
    {
        return $this->Height;
    }

    /**
     * @param null $Height
     * @return Location
     */
    public function setHeight($Height)
    {
        $this->Height = $Height;

        return $this;
    }

    /**
     * @return null
     */
    public function getPageNumber()
    {
        return $this->PageNumber;
    }

    /**
     * @param null $PageNumber
     * @return Location
     */
    public function setPageNumber($PageNumber)
    {
        $this->PageNumber = $PageNumber;

        return $this;
    } // Integer
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