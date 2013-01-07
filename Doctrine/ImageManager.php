<?php
namespace Avro\ImageBundle\Doctrine;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * ImageManager
 *
 * @author Joris de Wit <joris.w.dewit@gmail.com>
 */
class ImageManager
{
    protected $filesystem;
    protected $webDir;
    protected $cachePrefix;

    public function __construct($filesystem, $webDir, $cachePrefix)
    {
        $this->filesystem = $filesystem;
        $this->webDir = $webDir;
        $this->cachePrefix = $cachePrefix;
    }


    /*
     * Update a single image
     *
     *
     */
    public function update($image, array $directories = array())
    {
        $file = $image->getFile();
        if ($file) {
            if ($file->getFile() instanceof UploadedFile) {
                foreach ($directories as $directory)
                {
                    $path = sprintf('%s%s/%s/%s', $this->webDir, $this->cachePrefix, $directory, $file->getId());
                    if (file_exists($path)) {
                        @unlink($path);
                    }
                }
                $path = $file->getFile()->getRealPath();
                $file->setFile($path);
                $image->setFile($file);
            }
        }

        return $image;
    }
}



