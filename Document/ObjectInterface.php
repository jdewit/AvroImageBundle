<?php

/*
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Avro\ImageBundle\Document;

/**
 * @author Joris de Wit <joris.w.dewit@gmail.com>
 */
interface ObjectInterface
{
    public function getImages();
    public function setImages($images);
    public function addImage(\Avro\ImageBundle\Document\Image $image);
    public function removeImage(\Avro\ImageBundle\Document\Image $image);
    public function __alias();
}
