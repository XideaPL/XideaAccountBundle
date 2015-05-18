<?php

namespace Xidea\Bundle\AccountBundle;

use Xidea\Bundle\BaseBundle\AbstractBundle;

class XideaAccountBundle extends AbstractBundle
{
    protected function getModelNamespace()
    {
        return 'Xidea\Component\Account\Model';
    }
}
