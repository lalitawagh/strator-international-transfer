<?php

namespace Kanexy\InternationalTransfer\Strategies;

use Kanexy\PartnerFoundation\Core\Interfaces\WebhookHandler;
use Kanexy\PartnerFoundation\Core\Models\Transaction;

class CurrencyCloudPaymentCreate implements WebhookHandler
{
    public function handle(array $body, string $type)
    {
        
        /** @var Transaction $transaction */
        $transaction = Transaction::where('id',$body['meta']['partner_transaction_id'])->first();
    
        $meta = array_merge($transaction->meta, $body['meta']);

        $transaction->meta = $meta;
        $transaction->update();
    }

}
