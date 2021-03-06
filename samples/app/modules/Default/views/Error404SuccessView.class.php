    <?php

// +---------------------------------------------------------------------------+
// | This file is part of the Agavi package.                                   |
// | Copyright (c) 2005-2011 the Agavi Project.                                |
// |                                                                           |
// | For the full copyright and license information, please view the LICENSE   |
// | file that was distributed with this source code. You can also view the    |
// | LICENSE file online at http://www.agavi.org/LICENSE.txt                   |
// |   vi: set noexpandtab:                                                    |
// |   Local Variables:                                                        |
// |   indent-tabs-mode: t                                                     |
// |   End:                                                                    |
// +---------------------------------------------------------------------------+
    use Agavi\Request\RequestDataHolder;

    class Default_Error404SuccessView extends SampleAppDefaultBaseView
    {

        public function executeHtml(RequestDataHolder $rd)
        {
            $this->setupHtml($rd);

            // set the title
            $this->setAttribute('_title', $this->tm->_('404 Not Found', 'default.ErrorControllers'));

            $this->container->getResponse()->setHttpStatusCode('404');
        }

        public function executeXmlrpc(RequestDataHolder $rd)
        {
            return array(
            'faultCode' => -32601, // as per http://xmlrpc-epi.sourceforge.net/specs/rfc.fault_codes.php
            'faultString' => 'requested method not found',
            );
        }
    
        public function executeText(RequestDataHolder $rd)
        {
            return
            'Usage: console.php <command> [OPTION]...' . PHP_EOL .
            PHP_EOL .
            'Commands:' . PHP_EOL .
            '  viewproduct <id>' . PHP_EOL .
            '    Retrieves product details given a product ID.' . PHP_EOL .
            '  listproducts' . PHP_EOL .
            '    Lists all products in the application.' . PHP_EOL;
        }
    }
