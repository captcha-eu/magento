<?php

/**
 *  File Name: SimpleUrlProvider.php
 *  Description: Provides URL with params
 *
 *  Copyright © Captcha.eu
 *  Licensed under the Open Software License version 3.0
 *  See LICENSE.txt for license details
 */

namespace CaptchaEU\Captcha\Model\Provider\Failure\RedirectUrl;

use Magento\Framework\UrlInterface;
use CaptchaEU\Captcha\Model\Provider\Failure\RedirectUrlProviderInterface;

class SimpleUrlProvider implements RedirectUrlProviderInterface
{
    /**
     * @var UrlInterface
     */
    private $url;

    /**
     * @var string
     */
    private $urlPath;

    /**
     * @var array
     */
    private $urlParams;

    /**
     * SimpleUrlProvider constructor
     *
     * @param UrlInterface $url
     * @param String $urlPath
     * @param Array $urlParams
     */
    public function __construct(UrlInterface $url, $urlPath, $urlParams = null)
    {
        $this->url = $url;
        $this->urlPath = $urlPath;
        $this->urlParams = $urlParams;
    }

    /**
     * Get redirection URL
     *
     * @return string
     */
    public function execute()
    {
        return $this->url->getUrl($this->urlPath, $this->urlParams);
    }
}
