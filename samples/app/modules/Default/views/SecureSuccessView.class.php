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

class Default_SecureSuccessView extends SampleAppDefaultBaseView
{
    public function executeHtml(RequestDataHolder $rd)
    {
        $this->setupHtml($rd);

        // set the title
        $this->setAttribute('_title', $this->tm->_('Permission Denied', 'default.ErrorControllers'));
        
        $this->getResponse()->setHttpStatusCode('403');
    }
}
