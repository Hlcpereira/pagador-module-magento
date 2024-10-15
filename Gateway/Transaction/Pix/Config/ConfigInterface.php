<?php

namespace Braspag\BraspagPagador\Gateway\Transaction\Pix\Config;

/*
 * Copyright (C) 2021 Signativa/FGP Desenvolvimento de Software
 *
 * SPDX-License-Identifier: Apache-2.0
 */
interface ConfigInterface extends \Braspag\BraspagPagador\Gateway\Transaction\Base\Config\ConfigInterface
{
    const CONFIG_XML_BRASPAG_PAGADOR_PIX_DEMONSTRATIVE = 'payment/braspag_pagador_pix/demonstrative';
    const CONFIG_XML_BRASPAG_PAGADOR_PIX_INSTRUCTIONS = 'payment/braspag_pagador_pix/instructions';
    const CONFIG_XML_BRASPAG_PAGADOR_PIX_IDENTIFICATION = 'payment/braspag_pagador_pix/identification';
    const CONFIG_XML_BRASPAG_PAGADOR_PIX_ASSIGNOR = 'payment/braspag_pagador_pix/assignor';
    const CONFIG_XML_BRASPAG_PAGADOR_PIX_ASSIGNOR_ADDRESS = 'payment/braspag_pagador_pix/assignor_address';
    const CONFIG_XML_BRASPAG_PAGADOR_PIX_EXPIRATION_DATE = 'payment/braspag_pagador_pix/expiration_time';
    const CONFIG_XML_BRASPAG_PAGADOR_PIX_PROVIDER = 'payment/braspag_pagador_pix/types';
    const CONFIG_XML_BRASPAG_PAGADOR_PIX_BANK = 'payment/braspag_pagador_pix/bank';
    const CONFIG_XML_BRASPAG_PAGADOR_CUSTOMER_ADDRESS_STREET_ATTRIBUTE = 'payment/braspag_pagador_customer_address/street_attribute';
    const CONFIG_XML_BRASPAG_PAGADOR_CUSTOMER_ADDRESS_NUMBER_ATTRIBUTE = 'payment/braspag_pagador_customer_address/number_attribute';
    const CONFIG_XML_BRASPAG_PAGADOR_CUSTOMER_ADDRESS_COMPLEMENT_ATTRIBUTE = 'payment/braspag_pagador_customer_address/complement_attribute';
    const CONFIG_XML_BRASPAG_PAGADOR_CUSTOMER_ADDRESS_DISTRICT_ATTRIBUTE = 'payment/braspag_pagador_customer_address/district_attribute';
    const CONFIG_XML_BRASPAG_PAGADOR_PIX_PAYMENTSPLIT = 'payment/braspag_pagador_pix/paymentsplit';
    const CONFIG_XML_BRASPAG_PAGADOR_PIX_PAYMENTSPLIT_TYPE = 'payment/braspag_pagador_pix/paymentsplit_type';
    const CONFIG_XML_BRASPAG_PAGADOR_PIX_PAYMENTSPLIT_TRANSACTIONAL_POST_SEND_REQUEST_AUTOMATICALLY = 'payment/braspag_pagador_pix/paymentsplit_transactional_post_send_request_automatically';
    const CONFIG_XML_BRASPAG_PAGADOR_PIX_PAYMENTSPLIT_TRANSACTIONAL_POST_SEND_REQUEST_AUTOMATICALLY_AFTER_X_DAYS = 'payment/braspag_pagador_pix/paymentsplit_transactional_post_send_request_automatically_after_x_hours';
    const CONFIG_XML_BRASPAG_PAGADOR_PIX_PAYMENTSPLIT_DEFAULT_MDR = 'payment/braspag_pagador_pix/paymentsplit_mdr';
    const CONFIG_XML_BRASPAG_PAGADOR_PIX_PAYMENTSPLIT_DEFAULT_FEE = 'payment/braspag_pagador_pix/paymentsplit_fee';
    const DAY_FORMAT = '+%s day';

    public function getPaymentDemonstrative();

    public function getPaymentInstructions();

    public function getPaymentIdentification();

    public function getPaymentAssignor();

    public function getPaymentAssignorAddress();

    public function getExpirationDate();

    public function getPaymentProvider();

    public function getPaymentBank();

    public function getCustomerStreetAttribute();

    public function getCustomerNumberAttribute();

    public function getCustomerComplementAttribute();

    public function getCustomerDistrictAttribute();

    public function isPaymentSplitActive();

    public function getPaymentSplitType();

    public function getPaymentSplitTransactionalPostSendRequestAutomatically();

    public function getPaymentSplitTransactionalPostSendRequestAutomaticallyAfterXHours();

    public function getPaymentSplitDefaultMrd();

    public function getPaymentSplitDefaultFee();
}