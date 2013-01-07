<?php

namespace Avro\ImageBundle\Util;

use Imagine\Image\ImagineInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Image Manipulator
 *
 * @author Joris de Wit <joris.w.dewit@gmail.com>
 */
class ImageManipulator
{
    protected $imagine;
    protected $webRoot;
    protected $imageParameters;

    public function __construct(ImagineInterface $imagine, $webRoot, $imageParameters)
    {
        $this->imagine = $imagine;
        $this->webRoot = $webRoot;
        $this->imageParameters = $imageParameters;
    }

    public function process($form, $alias)
    {
        $image = $form[$alias]->getData();
        $tmp_path = $image->getRealPath();

        if (file_exists($tmp_path)) {
            $object = $form->getData();
            $parameters = $this->imageParameters[$alias];

            $this->reduce($tmp_path, $parameters['target_size']);

            $fileType = $this->getExtension($tmp_path);

            $id = sprintf('%s.%s',  $object->getId(), $fileType);

            move_uploaded_file($tmp_path, sprintf('%s/%s/%s', $this->webRoot, $parameters['image_dir'], $id));

            $method = 'set'.ucfirst($alias);
            $object->$method($id);

            return $object;
        }
    }

    public function reduce($path, $targetSize)
    {
        if (!$targetSize) {
            $targetSize = $this->targetSize;
        }

        $fileSize = filesize($path);

        if ($fileSize > 0) {
            $ratio = $targetSize / $fileSize;
            $quality = ceil($ratio * 100);
            if ($quality < 100) {
                $this->imagine->open($path)->save($path.'.jpg', array('quality' => $quality));
            }
        }

        return true;
    }

    public function getExtension($path) {
        $info = getimagesize($path);
        switch($info['mime']) {
            case 'image/jpeg':
                return 'jpg';
            break;
            case 'image/png':
                return 'png';
            break;
            case 'image/gif':
                return 'gif';
            break;
            default:
                throw new \Exception('Invalid image type.');
            break;
        }
    }
}
