<?php

namespace Kanexy\InternationalTransfer\Transfer;

use Illuminate\Support\Facades\Auth;
use Kanexy\Cms\Components\Contracts\Component;

class BankingProcessSelectionTransferComponent extends Component
{
    public function render()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        return view("international-transfer::widget.transfer-button-component", compact("user"));
    }
}
