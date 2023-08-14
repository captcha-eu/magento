<?php

/**
 *  File Name: BeforeAuthUrlProvider.php
 *  Description: Provides URLs depending on session
 *
 *  Copyright © Captcha.eu
 *  Licensed under the Open Software License version 3.0
 *  See LICENSE.txt for license details
 */

namespace CaptchaEU\Captcha\Model\Provider\Failure\RedirectUrl;

use CaptchaEU\Captcha\Model\Provider\Failure\RedirectUrlProviderInterface;
use Magento\Customer\Model\Url;
use Magento\Framework\Session\SessionManagerInterface;

class BeforeAuthUrlProvider implements RedirectUrlProviderInterface
{
    /**
     * @var SessionManagerInterface
     */
    private $sessionManager;

    /**
     * @var Url
     */
    private $url;

    /**
     * BeforeAuthUrlProvider constructor
     * @param SessionManagerInterface $sessionManager
     * @param Url $url
     */
    public function __construct(SessionManagerInterface $sessionManager, Url $url)
    {
        $this->sessionManager = $sessionManager;
        $this->url = $url;
    }

    /**
     * Get redirection URL
     *
     * @return string
     */
    public function execute()
    {
        $url = $this->sessionManager->getBeforeAuthUrl();

        // return url / fall back to login url
        return $url ?: $this->url->getLoginUrl();
    }
}
