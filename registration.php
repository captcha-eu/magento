<?php

/**
 *  File Name: registration.php
 *  Description: Registers the module
 *
 *  Copyright © Captcha.eu
 *  Licensed under the Open Software License version 3.0
 *  See LICENSE.txt for license details
 */

\Magento\Framework\Component\ComponentRegistrar::register(
    \Magento\Framework\Component\ComponentRegistrar::MODULE,
    'CaptchaEU_Captcha',
    __DIR__
);
