<?php

/**
 *  File Name: ValidateInterface.php
 *  Description: Validation interface
 *
 *  Copyright © Captcha.eu
 *  Licensed under the Open Software License version 3.0
 *  See LICENSE.txt for license details
 */

namespace CaptchaEU\Captcha\Api;

interface ValidateInterface
{
    public const PARAMETER_SOLUTION = 'captcha_at_solution';

    /**
     * Validate solution
     *
     * @param string $solution
     *
     * @return bool
     */
    public function validate(string $solution): bool;
}
