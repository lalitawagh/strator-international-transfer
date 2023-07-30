<?php

namespace Kanexy\InternationalTransfer\Webhooks;

use Exception;
use Illuminate\Http\Request;
use Kanexy\InternationalTransfer\Strategies\CurrencyCloudAccountCreate;
use Kanexy\InternationalTransfer\Strategies\CurrencyCloudBeneficiaryCreate;
use Kanexy\InternationalTransfer\Strategies\CurrencyCloudPaymentCreate;
use Kanexy\PartnerFoundation\Core\Interfaces\WebhookHandler;

class FxmasterCcWebhook
{
    private array $strategyTypeMap = [
        'currency-cloud-payment-create' => CurrencyCloudPaymentCreate::class,
        'currency-cloud-beneficiary-create' => CurrencyCloudBeneficiaryCreate::class,
        'currency-cloud-account-create' => CurrencyCloudAccountCreate::class
    ];

    public function __invoke(Request $request)
    {
        $payload = $request->input('payload');
        $strategy = $this->getStrategyForType($type = $request->input('type'));
       
        $strategy->handle($payload, $type);
    }

    private function getStrategyForType(string $type): WebhookHandler
    {
        if (! isset($this->strategyTypeMap[$type])) {
            throw new Exception("No strategy exists for handling type [" . $type . "].");
        }

        return new $this->strategyTypeMap[$type]();
    }
}
