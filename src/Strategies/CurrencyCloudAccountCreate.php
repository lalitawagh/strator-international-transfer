<?php

namespace Kanexy\InternationalTransfer\Strategies;

use App\Models\User;
use Kanexy\InternationalTransfer\Models\CcAccount;
use Kanexy\PartnerFoundation\Core\Interfaces\WebhookHandler;
use Kanexy\PartnerFoundation\Cxrm\Models\Contact;
use Kanexy\PartnerFoundation\Registration\Notifications\SubAccountDetailsNotification;
use Kanexy\PartnerFoundation\Workspace\Models\Workspace;

class CurrencyCloudAccountCreate implements WebhookHandler
{
    public function handle(array $body, string $type)
    {

        $existAccount = Contact::where(
            [
                'meta->workspace_id' =>  $body['account']['meta']['workspace_id'],
                'holder_type' => 'Kanexy\PartnerFoundation\Workspace\Models\Workspace',
                'holder_id' => $body['account']['meta']['workspace_id']

            ]
        )->first();

        if(is_null($existAccount))
        {
            /** @var CcAccount $account */
            $account = CcAccount::create($body['account']);
        }
        
        $existContact = Contact::where('workspace_id',  $body['contactinfo']['workspace_id'])->whereJsonContains('classification', 'cc_contacts')->first();
       
        if(is_null($existContact))
        {
           
            /** @var Contact $contact */
            $contact = Contact::create($body['contactinfo']);
        }

        $subAccountInfo = CcAccount::where(['holder_id' => $body['account']['meta']['workspace_id']])->first();
        $workspace = Workspace::find($body['account']['meta']['workspace_id']);
        $user = User::find($workspace->admin_id);

        $user->notify(new SubAccountDetailsNotification($user,$workspace,$subAccountInfo));
        
    }

}
