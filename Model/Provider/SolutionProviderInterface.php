<?php

/**
 *  File Name: SolutionProviderInterface.php
 *  Description: Solution Provider Interface
 *
 *  Copyright © Captcha.eu
 *  Licensed under the Open Software License version 3.0
 *  See LICENSE.txt for license details
 */

namespace CaptchaEU\Captcha\Model\Provider;

interface SolutionProviderInterface
{
    /**
     * Get Captcha solution from request
     *
     * @return string
     */
    public function execute(): string;
}
