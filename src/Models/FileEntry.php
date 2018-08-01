<?php
namespace Signhost\Models;

class FileEntry
{
    public $Links; // Array of Link
    public $DisplayName;

    /**
     * @return mixed
     */
    public function getLinks()
    {
        return $this->Links;
    }

    /**
     * @param mixed $Links
     * @return FileEntry
     */
    public function setLinks($Links)
    {
        $this->Links = $Links;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDisplayName()
    {
        return $this->DisplayName;
    }

    /**
     * @param mixed $DisplayName
     * @return FileEntry
     */
    public function setDisplayName($DisplayName)
    {
        $this->DisplayName = $DisplayName;

        return $this;
    } // String
}