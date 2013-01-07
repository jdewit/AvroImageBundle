<?php
namespace Avro\ImageBundle\Document;

/**
 * ImageInterface
 */
interface ImageInterface
{
    public function getId();

    public function setLabel($label);

    public function getLabel();

    public function setCaption($caption);

    public function getCaption();

    public function getPosition();

    public function setPosition($position);

    public function setFile($file);

    public function getFile();
}
