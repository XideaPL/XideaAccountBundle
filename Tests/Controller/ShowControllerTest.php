<?php

/* 
 * (c) Xidea Artur Pszczółka <biuro@xidea.pl>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xidea\Bundle\AccountBundle\Tests\Controller;

use Xidea\Bundle\AccountBundle\Tests\Controller\ControllerTestCase;

class ShowControllerTest extends ControllerTestCase
{
    public function testShowAction()
    {
        //$client = $this->logIn();
        $client = $this->createClient();
        $account = $client->getContainer()->get('xidea_account.account.loader')->loadOneBy(array('name'=>'Acme'));
        
        $crawler = $client->request('GET', $client->getContainer()->get('router')->generate('xidea_account_show', array('id'=>$account->getId())));

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Acme")')->count()
        );
    }
}

