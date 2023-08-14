<?php

/**
 *  File Name: Captcha.php
 *  Description: Template block & helper functions
 *
 *  Copyright © Captcha.eu
 *  Licensed under the Open Software License version 3.0
 *  See LICENSE.txt for license details
 */

namespace CaptchaEU\Captcha\Block\Frontend;

use CaptchaEU\Captcha\Model\Config;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Locale\ResolverInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\Data\Form\FormKey;
use Magento\Framework\Escaper;

use Zend\Json\Json;

class Captcha extends Template
{
    /**
     * @var Config
     */
    public $config;

    /**
     * @var ResolverInterface
     */
    private $localeResolver;

    /**
     * @param Template\Context $context
     * @param FormKey $formKey
     * @param ResolverInterface $localeResolver
     * @param Escaper $escaper
     * @param array $data
     * @param Config|null $config
     */
    public function __construct(
        Template\Context $context,
        FormKey $formKey,
        ResolverInterface $localeResolver,
        Escaper $escaper,
        array $data = [],
        Config $config = null,
    ) {
        parent::__construct($context, $data);
        $this->config = $config ?: ObjectManager::getInstance()->get(Config::class);
        $this->localeResolver = $localeResolver;
        $this->formKey = $formKey;
        $this->escaper = $escaper;
    }

    /**
     * Get FormKey
     *
     * @return string
     */
    public function getFormKey(): string
    {
        return $this->formKey->getFormKey();
    }

    /**
     * Get Public Key
     *
     * @return string
     */
    public function getKeyPublic(): string
    {
        return $this->config->getKeyPublic();
    }

    /**
     * Get Captcha Host
     *
     * @return string
     */
    public function getCaptchaHost(): string
    {
        return $this->config->getCaptchaHost();
    }

    /**
     * Get current language
     *
     * @return string
     */
    public function getLang(): string
    {
        $locale = locale_parse($this->localeResolver->getLocale());
        return $locale['language'];
    }

    /**
     * Get Widget ID
     *
     * @return string
     */
    public function getWidgetId(): string
    {
        if (!$this->hasData('widget_id')) {
            $this->setData('widget_id', hash('sha256', $this->getNameInLayout()));
        }

        return $this->getData('widget_id');
    }

    /**
     * Return content or empty
     *
     * @return string
     */
    public function toHtml()
    {
        // frontend disabled => do not output
        if (!$this->config->isEnabledFrontend()) {
            return '';
        }

        return parent::toHtml();
    }
}
