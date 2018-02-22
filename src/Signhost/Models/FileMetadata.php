<?php
namespace Signhost\Models;


class FileMetadata
{
    public $DisplayName; // String
    public $DisplayOrder; // Integer
    public $Description; // String
    public $Signers; // Map of <String,FormSets>
    public $FormSets; // Map of <String,Map of <String,FormSetField>>

    function __construct(
        $displayName = null,
        $displayOrder = null,
        $description = null,
        $signers = null,
        $formSets = null) {
        $this->DisplayName = $displayName;
        $this->DisplayOrder = $displayOrder;
        $this->Description = $description;
        $this->Signers = $signers;
        $this->FormSets = $formSets;
    }
}