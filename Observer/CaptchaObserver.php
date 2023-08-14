<?php

/**
 *  File Name: CaptchaObserver.php
 *  Description: Provides checks if validation is required; executes validation
 *
 *  Copyright © Captcha.eu
 *  Licensed under the Open Software License version 3.0
 *  See LICENSE.txt for license details
 */

namespace CaptchaEU\Captcha\Observer;

use CaptchaEU\Captcha\Api\ValidateInterface;
use CaptchaEU\Captcha\Model\IsCheckRequiredInterface;
use CaptchaEU\Captcha\Model\Provider\FailureProviderInterface;
use CaptchaEU\Captcha\Model\Provider\SolutionProviderInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class CaptchaObserver implements ObserverInterface
{

    /**
     * @var FailureProviderInterface
     */
    private $failureProvider;

    /**
     * @var ValidateInterface
     */
    private $validate;

    /**
     * @var SolutionProviderInterface
     */
    private $responseProvider;

    /**
     * @var IsCheckRequiredInterface
     */
    private $isCheckRequired;

    /**
     * @param SolutionProviderInterface $responseProvider
     * @param ValidateInterface $validate
     * @param FailureProviderInterface $failureProvider
     * @param IsCheckRequiredInterface $isCheckRequired
     */
    public function __construct(
        SolutionProviderInterface $responseProvider,
        ValidateInterface $validate,
        FailureProviderInterface $failureProvider,
        IsCheckRequiredInterface $isCheckRequired
    ) {
        $this->responseProvider = $responseProvider;
        $this->validate = $validate;
        $this->failureProvider = $failureProvider;
        $this->isCheckRequired = $isCheckRequired;
    }

    /**
     * Execute Validation
     *
     * @param Observer $observer
     *
     * @return void
     */
    public function execute(Observer $observer): void
    {
        // make sure check is required for the current resource
        if ($this->isCheckRequired->execute()) {

            // obtain response
            $response = $this->responseProvider->execute();

            // validate solution
            $valid = $this->validate->validate($response);
            if (!$valid) {

                /** @var Action $controller */
                $controller = $observer->getControllerAction();

                $this->failureProvider->execute($controller ? $controller->getResponse() : null);
            }
        }
    }
}
