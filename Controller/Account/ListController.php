<?php

/*
 * (c) Xidea Artur Pszczółka <biuro@xidea.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xidea\Bundle\AccountBundle\Controller\Account;

use Symfony\Component\HttpFoundation\Request;
use Xidea\Component\Account\Loader\AccountLoaderInterface;
use Xidea\Bundle\BaseBundle\ConfigurationInterface,
    Xidea\Bundle\BaseBundle\Controller\AbstractListController;

/**
 * @author Artur Pszczółka <a.pszczolka@xidea.pl>
 */
class ListController extends AbstractListController
{
    /*
     * @var AccountLoaderInterface
     */
    protected $loader;

    /**
     * 
     * @param ConfigurationInterface $configuration
     * @param AccountLoaderInterface $loader
     */
    public function __construct(ConfigurationInterface $configuration, AccountLoaderInterface $loader)
    {
        parent::__construct($configuration);
        
        $this->loader = $loader;
        $this->listTemplate = 'account_list';
    }
    
    /**
     * {@inheritdoc}
     */
    protected function loadModels(Request $request)
    {
        return $this->loader->loadByPage(
            $request->query->get($this->configuration->getPaginationParameterName(), 1),
            $this->configuration->getPaginationLimit()
        );
    }
    
    /**
     * {@inheritdoc}
     */
    protected function onPreList($models, Request $request)
    {
        return;
    }
}
