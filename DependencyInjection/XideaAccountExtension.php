<?php

namespace Xidea\Bundle\AccountBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

use Xidea\Bundle\BaseBundle\DependencyInjection\Helper\ExtensionHelper;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class XideaAccountExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration($this->getAlias());
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        
        $loader->load('account.yml');
        $loader->load('account_orm.yml');
        
        $this->loadAccountSection($config['account'], $container, $loader);
        
        $helper = new ExtensionHelper($this->getAlias());
        $helper->loadTemplateSection($config, $this->getDefaultTemplates(), $container, $loader);
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
    
    protected function getDefaultTemplates()
    {
        return [
            'account_main' => ['path' => '@XideaAccount/main'],
            'account_list' => ['path' => '@XideaAccount/Account/List/list'],
            'account_show' => ['path' => '@XideaAccount/Account/Show/show'],
            'account_create' => ['path' => '@XideaAccount/Account/Create/create'],
            'account_form' => ['path' => '@XideaAccount/Account/Form/form'],
            'account_form_fields' => ['path' => '@XideaAccount/Account/Form/fields']
        ];
    }
}