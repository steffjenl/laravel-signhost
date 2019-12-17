<?php
namespace Signhost\Models;


class FileMetadata
{
    public $DisplayName; // String
    public $DisplayOrder; // Integer
    public $Description; // String
    public $Signers; // Map of <String,FormSets>
    public $FormSets; // Map of <String,Map of <String,FormSetField>>
    public $SetParaph; // Boolean

    function __construct(
        $displayName = null,
        $displayOrder = null,
        $description = null,
        $signers = null,
        $formSets = null,
        $SetParaph = False) {
        $this->DisplayName = $displayName;
        $this->DisplayOrder = $displayOrder;
        $this->Description = $description;
        $this->Signers = $signers;
        $this->FormSets = $formSets;
        $this->SetParaph = $SetParaph;
    }

    /**
     * @return null
     */
    public function getDisplayName()
    {
        return $this->DisplayName;
    }

    /**
     * @param null $DisplayName
     * @return FileMetadata
     */
    public function setDisplayName($DisplayName)
    {
        $this->DisplayName = $DisplayName;

        return $this;
    }

    /**
     * @return null
     */
    public function getDisplayOrder()
    {
        return $this->DisplayOrder;
    }

    /**
     * @param null $DisplayOrder
     * @return FileMetadata
     */
    public function setDisplayOrder($DisplayOrder)
    {
        $this->DisplayOrder = $DisplayOrder;

        return $this;
    }

    /**
     * @return null
     */
    public function getDescription()
    {
        return $this->Description;
    }

    /**
     * @param null $Description
     * @return FileMetadata
     */
    public function setDescription($Description)
    {
        $this->Description = $Description;

        return $this;
    }

    /**
     * @return null
     */
    public function getSigners()
    {
        return $this->Signers;
    }

    /**
     * @param null $Signers
     * @return FileMetadata
     */
    public function setSigners($Signers)
    {
        $this->Signers = $Signers;

        return $this;
    }

    /**
     * @return null
     */
    public function getFormSets()
    {
        return $this->FormSets;
    }

    /**
     * @param null $FormSets
     * @return FileMetadata
     */
    public function setFormSets($FormSets)
    {
        $this->FormSets = $FormSets;

        return $this;
    }
    
    /**
     * @return null
     */
    public function getSetParaph()
    {
        return $this->SetParaph;
    }

    /**
     * @param false $SetParaph
     * @return FileMetadata
     */
    public function setFormSets($SetParaph)
    {
        $this->SetParaph = $SetParaph;

        return $this;
    }
}
