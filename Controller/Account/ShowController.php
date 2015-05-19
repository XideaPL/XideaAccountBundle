<?php

/*
 * (c) Xidea Artur Pszczółka <biuro@xidea.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xidea\Bundle\AccountBundle\Controller\Account;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Xidea\Component\Account\Loader\AccountLoaderInterface;
use Xidea\Bundle\BaseBundle\ConfigurationInterface,
    Xidea\Bundle\BaseBundle\Controller\AbstractShowController;
use Xidea\Component\Account\Model\AccountInterface;

/**
 * @author Artur Pszczółka <a.pszczolka@xidea.pl>
 */
class ShowController extends AbstractShowController
{
    /*
     * @var AccountLoaderInterface
     */
    protected $accountLoader;

    public function __construct(ConfigurationInterface $configuration, AccountLoaderInterface $accountLoader)
    {
        parent::__construct($configuration);

        $this->accountLoader = $accountLoader;
    }

    protected function loadModel($id)
    {
        $account = $this->accountLoader->load($id);

        if (!$account instanceof AccountInterface) {
            throw new NotFoundHttpException('account.not_found');
        }

        return $account;
    }

    protected function onPreShow($model, Request $request)
    {
        return;
    }
}