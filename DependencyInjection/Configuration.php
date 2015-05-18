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

        return $treeBuilder;
    }
    
    public function getDefaultTemplateNamespace()
    {
        return 'XideaAccountBundle';
    }
    
    protected function addAccountSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('account')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('class')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('configuration')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('factory')->defaultValue('xidea_account.account.factory.default')->end()
                        ->scalarNode('manager')->defaultValue('xidea_account.account.manager.default')->end()
                        ->scalarNode('loader')->defaultValue('xidea_account.account.loader.default')->end()
                        ->arrayNode('form')
                            ->addDefaultsIfNotSet()
                            ->canBeUnset()
                            ->children()
                                ->arrayNode('create')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('factory')->defaultValue('xidea_account.account.form.create.factory.default')->end()
                                        ->scalarNode('handler')->defaultValue('xidea_account.account.form.create.handler.default')->end()
                                        ->scalarNode('type')->defaultValue('xidea_account_create')->end()
                                        ->scalarNode('name')->defaultValue('xidea_account_create_form')->end()
                                        ->arrayNode('validation_groups')
                                            ->prototype('scalar')->end()
                                            ->defaultValue(array())
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                        ->append($this->addTemplateNode($this->getDefaultTemplateNamespace(), $this->getDefaultTemplateEngine(), array(
                            'list' => array(
                                'path' => 'Account\List:list'
                            ),
                            'show' => array(
                                'path' => 'Account\Show:show'
                            ),
                            'create' => array(
                                'path' => 'Account\Create:create'
                            ),
                            'create_form' => array(
                                'path' => 'Account\Create:create_form'
                            )
                        )))
                    ->end()
                ->end()
            ->end();
    }

}
