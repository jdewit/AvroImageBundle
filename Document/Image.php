<?php
namespace Avro\ImageBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ODM\EmbeddedDocument
 */
class Image implements ImageInterface
{
    /**
     * @ODM\Id(strategy="auto")
     */
    private $id;

    /**
     * @ODM\String
     */
    private $label;

    /**
     * @ODM\String
     */
    private $caption;

    /**
     * @ODM\String
     */
    private $position;

    /**
     * @ODM\ReferenceOne(targetDocument="File", cascade={"all"}, simple=true)
     */
    private $file;

    public function getId()
    {
        return $this->id;
    }

    public function setLabel($label)
    {
        $this->label = $label;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function setCaption($caption)
    {
        $this->caption = $caption;
    }

    public function getCaption()
    {
        return $this->caption;
    }

    public function getPosition()
    {
        return $this->position;
    }

    public function setPosition($position)
    {
        $this->position = $position;
        return $this;
    }

    public function setFile($file)
    {
        $this->file = $file;
        return $this;
    }
    public function getFile()
    {
        return $this->file;
    }
}
