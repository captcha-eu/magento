<?php

/**
 *  File Name: ObserverRedirectFailure.php
 *  Description: Provides redirect & error messages
 *
 *  Copyright © Captcha.eu
 *  Licensed under the Open Software License version 3.0
 *  See LICENSE.txt for license details
 */

namespace CaptchaEU\Captcha\Model\Provider\Failure;

use Magento\Framework\App\ActionFlag;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Message\ManagerInterface as MessageManagerInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\UrlInterface;
use CaptchaEU\Captcha\Model\Config;
use CaptchaEU\Captcha\Model\Provider\FailureProviderInterface;

class ObserverRedirectFailure implements FailureProviderInterface
{
    /**
     * @var MessageManagerInterface
     */
    private $messageManager;

    /**
     * @var ActionFlag
     */
    private $actionFlag;

    /**
     * @var Config
     */
    private $config;

    /**
     * @var UrlInterface
     */
    private $url;

    /**
     * @var RedirectUrlProviderInterface
     */
    private $redirectUrlProvider;

    /**
     * RedirectFailure constructor
     * @param MessageManagerInterface $messageManager
     * @param ActionFlag $actionFlag
     * @param Config $config
     * @param UrlInterface $url
     * @param RedirectUrlProviderInterface|null $redirectUrlProvider
     */
    public function __construct(
        MessageManagerInterface $messageManager,
        ActionFlag $actionFlag,
        Config $config,
        UrlInterface $url,
        RedirectUrlProviderInterface $redirectUrlProvider = null
    ) {
        $this->messageManager = $messageManager;
        $this->actionFlag = $actionFlag;
        $this->config = $config;
        $this->url = $url;
        $this->redirectUrlProvider = $redirectUrlProvider;
    }

    /**
     * Get redirect URL
     *
     * @return string
     */
    private function getUrl()
    {
        return $this->redirectUrlProvider->execute();
    }

    /**
     * Handle Captcha failure
     *
     * @param ResponseInterface $response
     *
     * @return void
     */
    public function execute(ResponseInterface $response = null)
    {
        // add error message
        $this->messageManager->addErrorMessage($this->config->getErrorMessage());

        // no dispatch
        $this->actionFlag->set('', Action::FLAG_NO_DISPATCH, true);

        // set redirect url
        $response->setRedirect($this->getUrl());
    }
}
