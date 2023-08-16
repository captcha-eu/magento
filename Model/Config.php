<?php

/**
 *  File Name: Config.php
 *  Description: Provides config paths, validation URL, settings array & enabled checks
 *
 *  Copyright © Captcha.eu
 *  Licensed under the Open Software License version 3.0
 *  See LICENSE.txt for license details
 */

declare(strict_types=1);

namespace CaptchaEU\Captcha\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Phrase;
use Magento\Store\Model\ScopeInterface;

class Config
{
    // General Config
    public const CFG_KEY_REST = 'captchaeu_captcha/general/rest_key';
    public const CFG_KEY_PUBLIC = 'captchaeu_captcha/general/public_key';
    public const CFG_HOST = 'captchaeu_captcha/general/host';

    // Frontend Config
    public const CFG_ENABLED_FRONTEND = 'captchaeu_captcha/frontend/enabled';
    public const CFG_ENABLED_FRONTEND_CONTACT = 'captchaeu_captcha/frontend/enabled_contact';
    public const CFG_ENABLED_FRONTEND_CREATE = 'captchaeu_captcha/frontend/enabled_create';
    public const CFG_ENABLED_FRONTEND_FORGOT = 'captchaeu_captcha/frontend/enabled_forgot';
    public const CFG_ENABLED_FRONTEND_LOGIN = 'captchaeu_captcha/frontend/enabled_login';
    public const CFG_ENABLED_FRONTEND_NEWSLETTER = 'captchaeu_captcha/frontend/enabled_newsletter';
    public const CFG_ENABLED_FRONTEND_SENDFRIEND = 'captchaeu_captcha/frontend/enabled_sendfriend';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Get translated error message
     *
     * @return Phrase
     */
    public function getErrorMessage(): Phrase
    {
        return __('Captcha.eu validation failed!');
    }

    /**
     * Return captcha config for frontend
     *
     * @return array
     */
    public function getCaptchaSettings(): array
    {
        return [
            'public_key'        => trim($this->getKeyPublic()),
            'enabled' => [
                'contact'       => $this->isEnabled(static::CFG_ENABLED_FRONTEND_CONTACT),
                'create'        => $this->isEnabled(static::CFG_ENABLED_FRONTEND_CREATE),
                'forgot'        => $this->isEnabled(static::CFG_ENABLED_FRONTEND_FORGOT),
                'login'         => $this->isEnabled(static::CFG_ENABLED_FRONTEND_LOGIN),
                'newsletter'    => $this->isEnabled(static::CFG_ENABLED_FRONTEND_NEWSLETTER),
                'sendfriend'    => $this->isEnabled(static::CFG_ENABLED_FRONTEND_SENDFRIEND),
            ]
        ];
    }

    /**
     * Return true if enabled on frontend - if either public or rest key is missing, nothing will be enabled
     *
     * @return bool
     */
    public function isEnabledFrontend(): bool
    {
        // check if keys are set
        if (!$this->getKeyRest() || !$this->getKeyPublic()) {
            return false;
        }

        return (bool) $this->scopeConfig->getValue(static::CFG_ENABLED_FRONTEND, ScopeInterface::SCOPE_WEBSITE);
    }

    /**
     * Get enabled state by config key
     *
     * @param String $key
     *
     * @return bool
     */
    private function isEnabled($key): bool
    {
        // no keys set => do not enable
        if (!$this->isEnabledFrontend()) {
            return false;
        }

        return (bool) $this->scopeConfig->getValue($key, ScopeInterface::SCOPE_WEBSITE);
    }

    /**
     * Get Public-Key
     *
     * @return string
     */
    public function getKeyPublic(): string
    {
        return trim((string) $this->scopeConfig->getValue(
            static::CFG_KEY_PUBLIC,
            ScopeInterface::SCOPE_WEBSITE
        ));
    }

    /**
     * Get REST-Key
     *
     * @return string
     */
    public function getKeyRest(): string
    {
        return trim((string) $this->scopeConfig->getValue(static::CFG_KEY_REST, ScopeInterface::SCOPE_WEBSITE));
    }

    /**
     * Get Captcha Host
     *
     * @return string
     */
    public function getCaptchaHost(): string
    {
        return trim((string) $this->scopeConfig->getValue(static::CFG_HOST, ScopeInterface::SCOPE_WEBSITE));
    }

    /**
     * Return validation URL
     *
     * @return string
     */
    public function getValidateURL(): string
    {
        return $this->getCaptchaHost() . '/validate';
    }
}
