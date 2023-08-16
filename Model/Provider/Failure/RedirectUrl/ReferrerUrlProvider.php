<?php

/**
 *  File Name: DefaultSolutionProvider.php
 *  Description: Provides the referrer URL
 *
 *  Copyright © Captcha.eu
 *  Licensed under the Open Software License version 3.0
 *  See LICENSE.txt for license details
 */

namespace CaptchaEU\Captcha\Model\Provider\Failure\RedirectUrl;

use CaptchaEU\Captcha\Model\Provider\Failure\RedirectUrlProviderInterface;
use Magento\Framework\App\Response\RedirectInterface;

class ReferrerUrlProvider implements RedirectUrlProviderInterface
{

    /**
     * @var RedirectInterface
     */
    private $redirect;

    /**
     * ReferrerUrlProvider constructor
     *
     * @param RedirectInterface $redirect
     */
    public function __construct(RedirectInterface $redirect)
    {
        $this->redirect = $redirect;
    }

    /**
     * Get redirection URL
     *
     * @return string
     */
    public function execute()
    {
        return $this->redirect->getRefererUrl();
    }
}
