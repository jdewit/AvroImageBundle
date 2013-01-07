<?php

namespace Avro\ImageBundle\Doctrine;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Common\Persistence\ObjectManager;
use Imagine\Image\ImagineInterface;
use Avro\ImageBundle\Document\ImageInterface;
use Avro\ImageBundle\Document\ObjectInterface;

/**
 * Object Manipulator
 *
 * @author Joris de Wit <joris.w.dewit@gmail.com>
 */
class ObjectManipulator
{
    protected $om;
    protected $imagine;
    protected $targetSize;

    public function __construct(ObjectManager $om, ImagineInterface $imagine, $targetSize)
    {
        $this->om = $om;
        $this->imagine = $imagine;
        $this->targetSize = $targetSize;
    }

    /*
     * Update an object
     *
     * @param $object
     */
    public function update(ObjectInterface $object)
    {
        $images = array();
        foreach ($object->getImages() as $image) {
            if ($image instanceof ImageInterface) {
                $file = $image->getFile();
                if ($file) {
                    if ($file->getFile() instanceof UploadedFile) {
                        $path = $file->getFile()->getRealPath();

                        $fileSize = filesize($path);
                        if ($fileSize > 5000000) {
                            //:TODO get form validation to do this
                            throw new \Exception('Your file is too large');
                        }
                        $ratio = $this->targetSize / $fileSize;
                        $quality = ceil($ratio * 100);
                        if ($quality < 100) {
                            $info = getimagesize($path);
                            if ($info['mime'] == 'image/jpeg') {
                                $this->imagine->open($path)->save($path.'.jpg', array('quality' => $quality));
                                $path = $path.'.jpg';
                            } elseif ($info['mime'] == 'image/gif') {
                                $this->imagine->open($path)->save($path.'.gif', array('quality' => $quality));
                                $path = $path.'.gif';
                            } elseif ($info['mime'] == 'image/png') {
                                $this->imagine->open($path)->save($path.'.png', array('quality' => $quality));
                                $path = $path.'.png';
                            }
                        }
                        $file->setFile($path);
                    }
                }
                $images[] = $image;
            }
        }
        $object->setImages($images);

        $this->om->flush();

        return true;
    }

    /*
     * find one object
     *
     * @param string $class
     * @param string $id
     */
    public function find($class, $id)
    {
        $object = $this->om
            ->getRepository($class)
            ->find($id);

        if (!$object) {
            throw new \Exception('No object found');
        }

        return $object;
    }
}
