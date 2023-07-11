<?php

namespace Kanexy\InternationalTransfer\Strategies;

use Kanexy\PartnerFoundation\Core\Interfaces\WebhookHandler;
use Kanexy\PartnerFoundation\Cxrm\Models\Contact;

class CurrencyCloudBeneficiaryCreate implements WebhookHandler
{
    public function handle(array $body, string $type)
    {
      
        /** @var Contact $contact */
        $account = Contact::where('id',$body['meta']['partner_ref_id'])->first();
       
        $meta = array_merge($account->meta, $body['meta']);
      
        $account->meta = $meta;
        $account->update();
    }

}
