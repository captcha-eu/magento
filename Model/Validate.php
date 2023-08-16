<?php

/**
 *  File Name: Validate.php
 *  Description: Provides Captcha.eu validation function
 *
 *  Copyright © Captcha.eu
 *  Licensed under the Open Software License version 3.0
 *  See LICENSE.txt for license details
 */

declare(strict_types=1);

namespace CaptchaEU\Captcha\Model;

use CaptchaEU\Captcha\Api\ValidateInterface;
use Magento\Framework\HTTP\Client\Curl;
use Magento\Framework\HTTP\Client\CurlFactory;
use Magento\Framework\Serialize\Serializer\Json;
use Psr\Log\LoggerInterface;

class Validate implements ValidateInterface
{
    public const PARAMETER_SOLUTION = 'captcha_at_solution';
    private const PARAMETER_KEY_REST = 'rest_key';
    private const PARAMETER_KEY_PUBLIC = 'public_key';

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var Config
     */
    private $config;

    /**
     * @var CurlFactory
     */
    private $curl;

    /**
     * @var Json
     */
    private $serializer;

    /**
     * Validate constructor
     *
     * @param LoggerInterface $logger
     * @param Config $config
     * @param CurlFactory $curl
     * @param Json $serializer
     */
    public function __construct(LoggerInterface $logger, Config $config, CurlFactory $curl, Json $serializer)
    {
        $this->logger = $logger;
        $this->config = $config;
        $this->curl = $curl;
        $this->serializer = $serializer;
    }

    /**
     * Validate the given solution
     *
     * @param string $solution
     *
     * @return bool
     */
    public function validate(string $solution): bool
    {
        // initiate curl
        $curl = $this->curl->create();

        // set additional request headers
        $curl->addHeader('Content-Type', 'application/json');
        $curl->addHeader('Rest-Key', $this->config->getKeyRest());

        try {
            // set validation endpoint
            $validateURL = $this->config->getValidateURL();

            // post data to validation endpoint
            $curl->post($validateURL, $solution);

            // get response body from validation endpoint
            $curlBody = $curl->getBody();

            // unserialize response body
            $response = $this->serializer->unserialize($curlBody);

            // if request succeeded
            $status = $curl->getStatus();
            $statusOK = $status === 200;

            // any status other than 200
            if (!$statusOK) {
                $this->logger->error('Error validating captcha solution (Status ' . $status . ')', [
                    'response' => var_export($response, true)
                ]);

                return false;
            }

            // decode json body
            $bodyJSON = json_decode($curlBody);

            // check if json_decode succeeded
            if (!$bodyJSON) {
                $this->logger->error('Error validating captcha solution (Invalid JSON)', [
                    'response' => var_export($response, true)
                ]);

                return false;
            }

            // check if validation succeeded
            if (!$bodyJSON->success) {
                $this->logger->error('Error validating captcha solution (Status ' . $status . ')', [
                    'response' => var_export($response, true),
                    'json' => $bodyJSON
                ]);

                return false;
            }

        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage(), ['exception' => $e]);

            return false;
        }

        return true;
    }
}
