<?php

/**
 *  File Name: IsCheckRequired.php
 *  Description: Provides enabled-checks
 *
 *  Copyright © Captcha.eu
 *  Licensed under the Open Software License version 3.0
 *  See LICENSE.txt for license details
 */

namespace CaptchaEU\Captcha\Model;

use Magento\Framework\App\Area;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\RequestInterface;

class IsCheckRequired implements IsCheckRequiredInterface
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var Config
     */
    private $config;

    /**
     * @var string
     */
    private $area;

    /**
     * @var string
     */
    private $enableConfigFlag;

    /**
     * @var bool
     */
    private $requireRequestParam;

    /**
     * IsCheckRequired constructor
     *
     * @param ScopeConfigInterface $scopeConfig
     * @param RequestInterface $request
     * @param Config $config
     * @param string $area
     * @param string $enableConfigFlag
     * @param bool $requireRequestParam
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        RequestInterface $request,
        Config $config,
        $area = null,
        $enableConfigFlag = null,
        $requireRequestParam = null
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->request = $request;
        $this->config = $config;
        $this->area = $area;
        $this->enableConfigFlag = $enableConfigFlag;
        $this->requireRequestParam = $requireRequestParam;

        // make sure current area is either frontend or backend/adminhtml
        if (!in_array($this->area, [Area::AREA_FRONTEND, Area::AREA_ADMINHTML], true)) {
            throw new \InvalidArgumentException('Area parameter must be one of frontend or adminhtml');
        }
    }

    /**
     * Return true if area is configured to be active
     *
     * @return bool
     */
    private function isAreaEnabled(): bool
    {
        return ($this->area === Area::AREA_FRONTEND) && $this->config->isEnabledFrontend();
    }

    /**
     * Return true if current zone is enabled
     *
     * @return bool
     */
    private function isZoneEnabled(): bool
    {
        return !$this->enableConfigFlag || $this->scopeConfig->getValue($this->enableConfigFlag);
    }

    /**
     * Return true if request if valid
     *
     * @return bool
     */
    private function isRequestValid(): bool
    {
        return !$this->requireRequestParam || $this->request->getParam($this->requireRequestParam);
    }

    /**
     * @inheritDoc
     */
    public function execute(): bool
    {
        return $this->isAreaEnabled() && $this->isZoneEnabled() && $this->isRequestValid();
    }
}
