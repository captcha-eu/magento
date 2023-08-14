<?php

/**
 *  File Name: FailureProviderInterface.php
 *  Description: Failure Provider Interface
 *
 *  Copyright © Captcha.eu
 *  Licensed under the Open Software License version 3.0
 *  See LICENSE.txt for license details
 */

namespace CaptchaEU\Captcha\Model\Provider;

use Magento\Framework\App\ResponseInterface;

interface FailureProviderInterface
{
    /**
     * Handle Captcha failure
     *
     * @param ResponseInterface|null $response
     *
     * @return void
     */
    public function execute(ResponseInterface $response = null);
}
