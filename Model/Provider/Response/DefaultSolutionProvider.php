<?php

/**
 *  File Name: DefaultSolutionProvider.php
 *  Description: Provides Captcha.eu solution from request
 *
 *  Copyright © Captcha.eu
 *  Licensed under the Open Software License version 3.0
 *  See LICENSE.txt for license details
 */

namespace CaptchaEU\Captcha\Model\Provider\Response;

use Magento\Framework\App\RequestInterface;
use CaptchaEU\Captcha\Api\ValidateInterface;
use CaptchaEU\Captcha\Model\Provider\SolutionProviderInterface;

class DefaultSolutionProvider implements SolutionProviderInterface
{
    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * DefaultResponseProvider constructor
     *
     * @param RequestInterface $request
     */
    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }

    /**
     * Get solution from request
     *
     * @return string
     */
    public function execute(): string
    {
        return (string) $this->request->getParam(ValidateInterface::PARAMETER_SOLUTION);
    }
}
