<?php

namespace Xidea\Bundle\AccountBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Xidea\Bundle\BaseBundle\DependencyInjection\Helper\ConfigurationHelper;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /*
     * @var string
     */
    protected $alias;
    
    public function __construct($alias)
    {
        $this->alias = $alias;
    }
    
    public function getAlias()
    {
        return $this->alias;
    }
    
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root($this->getAlias());
        
        $this->addAccountSection($rootNode);
        
        $helper = new ConfigurationHelper($this->getAlias());
        $helper->addTemplateSection($rootNode);

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
                                        ->scalarNode('type')->defaultValue('Xidea\Bundle\AccountBundle\Form\Type\AccountType')->end()
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
