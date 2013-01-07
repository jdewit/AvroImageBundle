AvroImageBundle
-----------------
Symfony2 Image Bundle. 

Easily attach images to any object and display 
them as a gallery, carousel, or lightbox.

Status
------
- A work in progress
- Currently only works with MongoDB and stores images in GridFS

Requirements
------------
- <a href="http://github.com/liip/ImagineBundle">LiipImagineBundle</a>
- <a href="https://github.com/doctrine/DoctrineMongoDBBundle">DoctrineMongodbBundle</a>

Installation
------------
### Download AvroImageBundle using composer

Add AvroImageBundle in your composer.json:

```js
{
    "require": {
        "avro/image-bundle": "*"
    }
}
```
Now tell composer to download the bundle by running the command:

``` bash
$ php composer.phar update avro/image-bundle
```

### Enable the bundle in the kernel:

``` php
// app/AppKernel.php
new Avro\ImageBundle\AvroImageBundle
```

### Add Routing
//app/config/routing

``` yaml
avro_image:
    resource: "@AvroImageBundle/Resources/config/routing/routing.xml"
```

### Add Resources
Add CSS
``` html
{% stylesheets output='css/compiled/app.css' filter='cssrewrite, less, ?yui_css'
...
    'bundles/avroimage/css/avro-image.css'
...
%}
<link rel="stylesheet" href="{{ asset_url }}" type="text/css" media="screen" />
{% endstylesheets %}
```
Add JS
``` html
{% javascripts output='js/compiled/app.js' filter='?yui_js'
...
    'bundles/avroimage/js/avro-image.js'
...
%}
    <script type="text/javascript" src="{{ asset_url }}"></script>
{% endjavascripts %}

```

Dump your assets and watch
``` bash
$ php app/console assets:install --symlink=true

$ php app/console assetic:dump --watch --force 
```

Add Mapping
-----------

Add the image reference to the object you want to rate

``` php
<?php
// src/Acme/ProductBundle/Document/Product.php

namespace Acme\ProductBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Avro\ImageBundle\Model\ImageObjectInterface;

/**
 * @ODM\Document
 */
class Product implements ImageObjectInterface
{
    ...

    public function __construct()
    {
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
    }
    /**
     * @ODM\ReferenceMany(targetDocument="Avro\ImageBundle\Document\Image", cascade={"all"}, sort={"position"="asc"})
     */
    protected $images;

    /**
     * Set images
     *
     * @param ArrayCollection $images
     * @return Product
     */
    public function setImages(\Doctrine\Common\Collections\ArrayCollection $images)
    {
        $this->images = $images;
        return $this;
    }

    /**
     * Get images
     *
     * @return MongoCursor $images
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Add images
     *
     * @param Avro\ImageBundle\Document\Image $image
     */
    public function addImage(\Avro\ImageBundle\Document\Image $image)
    {
        $this->images[] = $image;
        return $this;
    }

    /**
     * Remove image
     *
     * @param Avro\ImageBundle\Document\Image $image
     */
    public function removeImage(\Avro\ImageBundle\Document\Image $image)
    {
        $this->images->removeElement($image);
        return $this;
    }

    /**
     * Get the documents name
     */
    public function getDocumentName()
    {
        return 'product';
    }
   
    ...
}
```
Configuration Reference
-----------------------
``` yaml
    avro_image:
        db_driver: mongodb 
        carousels:
            my_carousel:
                style=twitter
                width: 300
                height: 300
                slide: true
            my_custom_carousel:
                style: custom
                template: AcmeDemoBundle:Carousel:my_carousel.html.twig
```

Showing Images
--------------

Render images in twitter bootstrap carousel

``` html
{{ carousel_render('twitter', product.images) }}
```

And that's it!

Contributing
------------

Send in your custom templates!



