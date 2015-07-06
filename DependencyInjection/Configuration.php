<?php

namespace Xidea\Bundle\AccountBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

use Xidea\Bundle\BaseBundle\DependencyInjection\AbstractConfiguration;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration extends AbstractConfiguration
{
    public function __construct($alias)
    {
        parent::__construct($alias);
    }
    
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = parent::getConfigTreeBuilder();
        $rootNode = $treeBuilder->root($this->alias);
        
        $this->addAccountSection($rootNode);
        $this->addTemplateSection($rootNode);

        return $treeBuilder;
    }
    
    protected function addAccountSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('account')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('code')->defaultValue('xidea_account')->end()
                        ->scalarNode('class')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('configuration')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('factory')->defaultValue('xidea_account.account.factory.default')->end()
                        ->scalarNode('manager')->defaultValue('xidea_account.account.manager.default')->end()
                        ->scalarNode('loader')->defaultValue('xidea_account.account.loader.default')->end()
                        ->arrayNode('form')
                            ->addDefaultsIfNotSet()
                            ->canBeUnset()
                            ->children()
                                ->arrayNode('account')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('factory')->defaultValue('xidea_account.account.form.factory.default')->end()
                                        ->scalarNode('handler')->defaultValue('xidea_account.account.form.handler.default')->end()
                                        ->scalarNode('type')->defaultValue('xidea_account')->end()
                                        ->scalarNode('name')->defaultValue('account')->end()
                                        ->arrayNode('validation_groups')
                                            ->prototype('scalar')->end()
                                            ->defaultValue(array())
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}
