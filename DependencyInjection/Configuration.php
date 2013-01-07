<?php

namespace Avro\ImageBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree.
     *
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('avro_image');

        $rootNode
            ->children()
                ->scalarNode('db_driver')->defaultValue('mongodb')->cannotBeEmpty()->end()
                ->scalarNode('web_root')->isRequired()->cannotBeEmpty()->end()
                ->arrayNode('images')
                    ->useAttributeAsKey('image')->prototype('array')
                        ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('image_dir')->isRequired()->cannotBeEmpty()->end()
                            ->scalarNode('default_image')->isRequired()->end()
                            ->scalarNode('target_size')->defaultValue('200000')->cannotBeEmpty()->end()
                            ->scalarNode('css')->cannotBeEmpty()->end()
                        ->end()
                    ->end()
                ->end()
//                ->scalarNode('edit_template')->defaultValue('AvroImageBundle:Twitter:edit.html.twig')->cannotBeEmpty()->end()
                ->arrayNode('carousels')
                    ->useAttributeAsKey('carousel')->prototype('array')
                        ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('style')->defaultValue('twitter')->end()
                            ->scalarNode('template')->end()
                            ->scalarNode('height')->defaultValue(300)->cannotBeEmpty()->end()
                            ->scalarNode('width')->defaultValue(300)->end()
                            ->booleanNode('slide')->defaultTrue()->end()
                        ->end()
                    ->end()
                ->end()
                //->arrayNode('objects')
                    //->useAttributeAsKey('object')->prototype('array')
                        //->children()
                            //->scalarNode('class')->cannotBeEmpty()->end()
                            //->scalarNode('redirect_route')->cannotBeEmpty()->end()
                            //->booleanNode('by_slug')->defaultFalse()->end()
                            //->scalarNode('max')->defaultValue(100)->end()
                            //->scalarNode('default_image')->end()
                        //->end()
                    //->end()
                //->end()
             ->end();

        return $treeBuilder;

    }
}
