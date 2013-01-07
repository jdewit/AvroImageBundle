<?php
namespace Avro\ImageBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * File
 *
 * @ODM\Document
 */
class File
{
    /**
     * @ODM\Id(strategy="auto")
     */
    public $id;

    /**
     * @ODM\File
     */
    private $file;

    /**
     * @ODM\String
     */
    private $uploadDate;

    /**
     * @ODM\String
     */
    private $length;

    /**
     * @ODM\String
     */
    private $chunkSize;

    /**
     * @ODM\String
     */
    private $md5;

    public function getId()
    {
        return $this->id;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * Set uploadDate
     *
     * @param string $uploadDate
     * @return Image
     */
    public function setUploadDate($uploadDate)
    {
        $this->uploadDate = $uploadDate;
        return $this;
    }

    /**
     * Get uploadDate
     *
     * @return string $uploadDate
     */
    public function getUploadDate()
    {
        return $this->uploadDate;
    }

    /**
     * Set length
     *
     * @param string $length
     * @return Image
     */
    public function setLength($length)
    {
        $this->length = $length;
        return $this;
    }

    /**
     * Get length
     *
     * @return string $length
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * Set chunkSize
     *
     * @param string $chunkSize
     * @return Image
     */
    public function setChunkSize($chunkSize)
    {
        $this->chunkSize = $chunkSize;
        return $this;
    }

    /**
     * Get chunkSize
     *
     * @return string $chunkSize
     */
    public function getChunkSize()
    {
        return $this->chunkSize;
    }

    /**
     * Set md5
     *
     * @param string $md5
     * @return Image
     */
    public function setMd5($md5)
    {
        $this->md5 = $md5;
        return $this;
    }

    /**
     * Get md5
     *
     * @return string $md5
     */
    public function getMd5()
    {
        return $this->md5;
    }
}
