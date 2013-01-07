<?php

namespace Avro\ImageBundle\Twig\Extension;

/*
 *
 */
class ImageExtension extends \Twig_Extension
{
    private $environment;
    private $parameters;

    /**
     * @param \Twig_Environment $environment
     * @param CacheManager $cachManager
     * @param array $carouselParameters
     */
    public function __construct(\Twig_Environment $environment, $webRoot, $parameters)
    {
        $this->environment = $environment;
        $this->webRoot = $webRoot;
        $this->parameters = $parameters;
    }

    public function getFunctions()
    {
        return array(
            'carousel_render' => new \Twig_Function_Method($this, 'renderCarousel', array('is_safe' => array('html'))),
            'img_src' => new \Twig_Function_Method($this, 'renderImage', array('is_safe' => array('html'))),
            'img' => new \Twig_Function_Method($this, 'showImage', array('is_safe' => array('html'))),
        );
    }

    /**
     * Renders a carousel with the specified renderer.
     *
     * @param string $name
     * @param Document $object
     * @param array $options
     *
     * @return string
     */
    public function renderCarousel($name, $object, array $options = array())
    {
        $options = array_merge($this->carouselParameters[$name], $options);

        $template = $options['template'];

        if (!$template instanceof \Twig_Template) {
            $template = $this->environment->loadTemplate($template);
        }

        $html = $template->renderBlock('root', array('object' => $object, 'options' => $options));

        return $html;
    }

    /**
     * Renders an image with the specified renderer.
     *
     * @param Document $object
     * @param string $filter
     * @param array $options
     *
     * @return string
     */
    public function renderImage($image, $filter, array $options = array())
    {
        $options['filter'] = $filter;
        // render image if it exists otherwise render a default image
        if (!is_object($image)) {
            $options['path'] = $image;
            if (file_exists($image)) {
                $options['path'] = $image;
            } else {
                if (array_key_exists('default_image', $options)) {
                    $options['path'] = $options['default_image'];
                } else {
                    $options['path'] = $this->defaultImagePath;
                }
            }
            //if (array_key_exists('alias', $options)) {
                //$options = array_merge($this->carouselParameters['documents'][$options['alias']], $options);
            //}

            $template = 'AvroImageBundle:Image:image.html.twig';

            if (!$template instanceof \Twig_Template) {
                $template = $this->environment->loadTemplate($template);
            }

            return $template->renderBlock('image_src', $options);
        } else if ($filter) {
            return $this->cacheManager->getBrowserPath($image->getFile()->getId(), $filter, false);
        } else {

            //todo:
        }
    }

    public function showImage($fileName, $alias, array $options = array())
    {
        $options = array_merge($this->parameters[$alias], $options);
        $path = sprintf('%s/%s/%s', $this->webRoot, $options['image_dir'], $fileName);
        if (is_file($path)) {
            $options['path'] = sprintf('%s/%s', $options['image_dir'], $fileName);
        } else {
            $options['path'] = sprintf('%s/%s', $options['image_dir'], $options['default_image']);
        }

        $template = 'AvroImageBundle:Image:image.html.twig';

        if (!$template instanceof \Twig_Template) {
            $template = $this->environment->loadTemplate($template);
        }

        return $template->renderBlock('image', $options);

    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'avro_image';
    }
}
