<?php

/*
 * (c) Xidea Artur Pszczółka <biuro@xidea.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xidea\Bundle\AccountBundle\Controller\Account;

use Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpFoundation\Response;
use Xidea\Component\Base\Factory\ModelFactoryInterface;
use Xidea\Component\Account\Manager\AccountManagerInterface;
use Xidea\Bundle\BaseBundle\ConfigurationInterface,
    Xidea\Bundle\BaseBundle\Controller\AbstractCreateController,
    Xidea\Bundle\BaseBundle\Form\Handler\FormHandlerInterface;
use Xidea\Bundle\AccountBundle\AccountEvents,
    Xidea\Bundle\AccountBundle\Event\GetAccountResponseEvent,
    Xidea\Bundle\AccountBundle\Event\FilterAccountResponseEvent;

/**
 * @author Artur Pszczółka <a.pszczolka@xidea.pl>
 */
class CreateController extends AbstractCreateController
{
    /*
     * @var ModelFactoryInterface
     */

    protected $accountFactory;

    /*
     * @var AccountManagerInterface
     */
    protected $accountManager;

    public function __construct(ConfigurationInterface $configuration, ModelFactoryInterface $accountFactory, AccountManagerInterface $modelManager, FormHandlerInterface $formHandler)
    {
        parent::__construct($configuration, $modelManager, $formHandler);

        $this->createTemplate = 'account_create';
        $this->createFormTemplate = 'account_create_form';
        $this->accountFactory = $accountFactory;
    }

    protected function createModel()
    {
        return $this->accountFactory->create();
    }

    protected function onPreCreate($model, Request $request)
    {
        $this->dispatch(AccountEvents::PRE_CREATE, $event = new GetAccountResponseEvent($model, $request));

        return $event->getResponse();
    }

    protected function onCreateSuccess($model, Request $request)
    {
        $this->dispatch(AccountEvents::CREATE_SUCCESS, $event = new GetAccountResponseEvent($model, $request));

        if (null === $response = $event->getResponse()) {
            $response = $this->redirectToRoute('xidea_account_show', array(
                'id' => $model->getId()
            ));
        }

        return $response;
    }

    protected function onCreateCompleted($model, Request $request, Response $response)
    {
        $this->dispatch(AccountEvents::CREATE_COMPLETED, new FilterAccountResponseEvent($model, $request, $response));
    }
}
