<?php

/**
 *  File Name: RedirectUrlProviderInterface.php
 *  Description: Redirect URL Interface
 *
 *  Copyright © Captcha.eu
 *  Licensed under the Open Software License version 3.0
 *  See LICENSE.txt for license details
 */

namespace CaptchaEU\Captcha\Model\Provider\Failure;

interface RedirectUrlProviderInterface
{
    /**
     * Get redirection URL
     *
     * @return string
     */
    public function execute();
}
