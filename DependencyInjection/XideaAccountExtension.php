<?php

namespace Xidea\Bundle\AccountBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;

use Xidea\Bundle\BaseBundle\DependencyInjection\AbstractExtension;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class XideaAccountExtension extends AbstractExtension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        list($config, $loader) = $this->setUp($configs, new Configuration($this->getAlias()), $container);

        $loader->load('account.yml');
        $loader->load('account_orm.yml');
        $loader->load('controller.yml');
        $loader->load('form.yml');
        $loader->load('template.yml');

        $this->loadAccountSection($config['account'], $container, $loader);
        
        if (isset($config['template'])) {
            $this->loadTemplateSection($this->getAlias(), $config['template'], $container, $loader);
        }
    }
    
    protected function loadAccountSection(array $config, ContainerBuilder $container, Loader\YamlFileLoader $loader)
    {
        $container->setParameter('xidea_account.account.code', $config['code']);
        $container->setParameter('xidea_account.account.class', $config['class']);
        $container->setAlias('xidea_account.account.configuration', $config['configuration']);
        $container->setAlias('xidea_account.account.factory', $config['factory']);
        $container->setAlias('xidea_account.account.manager', $config['manager']);
        $container->setAlias('xidea_account.account.loader', $config['loader']);
        
        if (!empty($config['form'])) {
            $this->loadAccountFormSection($config['form'], $container, $loader);
        }
    }
    
    protected function loadAccountFormSection(array $config, ContainerBuilder $container, Loader\YamlFileLoader $loader)
    {
        $container->setAlias('xidea_account.account.form.factory', $config['account']['factory']);
        $container->setAlias('xidea_account.account.form.handler', $config['account']['handler']);
        
        $container->setParameter('xidea_account.account.form.type', $config['account']['type']);
        $container->setParameter('xidea_account.account.form.name', $config['account']['name']);
        $container->setParameter('xidea_account.account.form.validation_groups', $config['account']['validation_groups']);
    }
    
    protected function getConfigurationDirectory()
    {
        return __DIR__.'/../Resources/config';
    }
    
    protected function getDefaultTemplates()
    {
        return [
            'main' => ['namespace' => '', 'path' => 'main'],
            'account_main' => ['path' => 'main'],
            'account_list' => ['path' => 'Account/List/list'],
            'account_show' => ['path' => 'Account/Show/show'],
            'account_create' => ['path' => 'Account/Create/create'],
            'account_form' => ['path' => 'Account/Form/form'],
            'account_form_fields' => ['path' => 'Account/Form/fields']
        ];
    }
}