<?php

namespace Braspag\BraspagPagador\Gateway\Transaction\Pix\Resource\Send\Response;

use Magento\Payment\Gateway\Validator\ValidatorInterface;
use Magento\Payment\Gateway\Validator\Result;
use Braspag\Braspag\Pagador\Transaction\Api\Pix\Send\ResponseInterface;
use Braspag\BraspagPagador\Gateway\Transaction\Pix\Config\ConfigInterface as PixConfigInterface;

/**
 * Validator
 *
 * @author      Webjump Core Team <dev@webjump.com>
 * @copyright   2019 Webjump (http://www.webjump.com.br)
 * @license     http://www.webjump.com.br  Copyright
 *
 * @link        http://www.webjump.com.br
 */
class Validator implements ValidatorInterface
{
    const NOTFINISHED = 0;
    const AUTHORIZED = 1;
    const PAYMENTCONFIRMED = 2;
    const DENIED = 3;
    const VOIDED = 10;
    const REFUNDED = 11;
    const PENDING = 12;
    const ABORTED = 13;
    const SCHEDULED = 20;

    protected $statusDenied;
    protected $pixConfigInterface;

    public function __construct(
        PixConfigInterface $pixConfigInterface
    ) {
        $this->pixConfigInterface = $pixConfigInterface;
    }

    public function validate(array $validationSubject)
    {
        if (!isset($validationSubject['response']) || !$validationSubject['response'] instanceof ResponseInterface) {
            throw new \InvalidArgumentException('Braspag Pix Authorize Response object should be provided');
        }

        $response = $validationSubject['response'];
        $status = true;
        $message = [];

        if (in_array($response->getPaymentStatus(), $this->getStatusDenied($response))) {
            $status = false;
            $message = $response->getPaymentProviderReturnMessage();
            if (empty($message)) {
                $message = "Pix Payment Failure. #BP{$response->getPaymentStatus()}";
            }
        }

        return new Result($status, [$message]);
    }

    /**
     * @param ResponseInterface $response
     * @return array
     */
    protected function getStatusDenied(ResponseInterface $response)
    {
        if (! $this->statusDenied) {
            $this->statusDenied = [self::DENIED, self::NOTFINISHED, self::ABORTED];
        }

        return $this->statusDenied;
    }
}