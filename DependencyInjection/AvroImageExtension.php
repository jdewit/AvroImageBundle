<?php
namespace Avro\ImageBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Alias;

class AvroImageExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container) {

        $processor = new Processor();
        $configuration = new Configuration();

        $config = $processor->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        $loader->load('twig.xml');
        $loader->load('manipulator.xml');

//        $loader->load(sprintf('%s.xml', $config['db_driver']));

        $container->setParameter('avro_image.web_root', $config['web_root']);

        $container->setParameter('avro_image.images', $config['images']);
        $container->setParameter('avro_image.carousels', $config['carousels']);

        //foreach ($config['objects'] as $key => $val) {
            //$container->setParameter(sprintf('avro_image.%s', $key), $val);
        //}
//        $container->setParameter('avro_image.edit_template', $config['edit_template']);
        //$carousels = array(
            //'twitter' => array(
                //'template' => 'AvroImageBundle:Twitter:carousel.html.twig',
                //'imagine_filter' => 'thumbnail',
                //'height' => 300,
                //'width' => 300,
                //'slide' => true
            //)
        //);

        ////set default options if extending a supported style
        //foreach ($config['carousels'] as $key => $val) {
            //if (array_key_exists($val['style'], $carousels)) {
                //$val = array_merge($carousels[$val['style']], $val);
            //}
            //$carousels[$key] = $val;
        //}

    }
}
