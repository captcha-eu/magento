<?php

/**
 *  File Name: IsCheckRequiredInterface.php
 *  Description: IsCheckRequiredInterface
 *
 *  Copyright © Captcha.eu
 *  Licensed under the Open Software License version 3.0
 *  See LICENSE.txt for license details
 */

namespace CaptchaEU\Captcha\Model;

interface IsCheckRequiredInterface
{
    /**
     * Return true if check is required
     *
     * @return bool
     */
    public function execute(): bool;
}
