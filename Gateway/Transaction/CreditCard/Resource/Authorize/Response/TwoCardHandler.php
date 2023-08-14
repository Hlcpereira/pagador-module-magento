<?php

namespace Braspag\BraspagPagador\Gateway\Transaction\CreditCard\Resource\Authorize\Response;

use Magento\Payment\Gateway\Response\HandlerInterface;
use Braspag\Braspag\Pagador\Transaction\Api\CreditCard\Send\ResponseInterface;
use Braspag\BraspagPagador\Gateway\Transaction\CreditCard\Resource\Authorize\Response\AbstractHandler;
use Braspag\BraspagPagador\Model\Request\CardTwo;

class TwoCardHandler extends AbstractHandler implements HandlerInterface
{

    protected $cardTwo;

    public function __construct(
        CardTwo $cardTwo
    ) {
        $this->cardTwo = $cardTwo;
    }

    protected function _handle($payment, $response)
    {
        $responseTwoCard =  $this->cardTwo->getData('response');

        if (isset($responseTwoCard)) {

            if (isset($responseTwoCard->getPayment()['CreditCard']['CardNumber'])) 
                $payment->setAdditionalInformation('two_card_crypt', $responseTwoCard->getPayment()['CreditCard']['CardNumber']);
            
            
            $payment->setAdditionalInformation('two_card_paymentId', $responseTwoCard->getPaymentPaymentId());
            $payment->setAdditionalInformation('two_card_last_4', $this->cardTwo->getData('cc_last_4'));        
            $payment->setAdditionalInformation('two_card_total_amount', $this->cardTwo->getData('total_amount'));
            $payment->setAdditionalInformation('two_card_cc_installments', $this->cardTwo->getData('cc_installments'));
            $payment->setAdditionalInformation('two_card_type', $this->cardTwo->getData('cc_type'));
            $payment->setAdditionalInformation('two_card_cc_owner', $this->cardTwo->getData('cc_owner'));
            $payment->setAdditionalInformation('two_card2_taxvat', $this->cardTwo->getData('taxvat_card2'));
            $payment->setAdditionalInformation('two_card_taxvat', $this->cardTwo->getData('taxvat_card'));
            $payment->setAdditionalInformation('two_card_taxvat', $this->cardTwo->getData('taxvat_card'));
            $payment->setAdditionalInformation('two_card_proof_of_sale', $responseTwoCard->getPaymentProofOfSale());
            $payment->setAdditionalInformation('card_cc_token_card2', $this->cardTwo->getData('cc_token'));
        }

        return $this;
    }
}
