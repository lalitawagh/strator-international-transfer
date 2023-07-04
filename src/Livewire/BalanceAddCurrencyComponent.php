<?php

namespace Kanexy\InternationalTransfer\Livewire;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Kanexy\Cms\I18N\Models\Country;
use Kanexy\Cms\Setting\Models\Setting;
use Kanexy\CurrencyCloud\Dtos\RateDetailedExchangeDto;
use Kanexy\CurrencyCloud\Services\CurrencyCloudApiService;
use Kanexy\InternationalTransfer\Enums\Status;
use Kanexy\InternationalTransfer\Http\Helper;
use Kanexy\InternationalTransfer\Models\CcCurrencyConversion;
use Kanexy\InternationalTransfer\Models\CcExchangeRate;
use Kanexy\PartnerFoundation\Core\Enums\ExchangeCurrencyEnum;
use Kanexy\PartnerFoundation\Workspace\Models\WorkspaceMeta;
use Livewire\Component;

use function PHPUnit\Framework\isEmpty;

class BalanceAddCurrencyComponent extends Component
{
    public $currencyList;

    public $balanceCurrency;

    public function mount()
    {
        $this->currencyList = ['AED','AUD','BGN','BHD','CAD','CHF','CNY','CZK','DKK','EUR','GBP','HKD','HRK','HUF','IDR','ILS','INR',
        'JPY','KES','KWD','MXN','MYR','NOK','NZD','OMR','PHP','PLN','QAR','RON','SAR','SEK','SGD','THB','TRY','UGX','USD','ZAR'];
        $this->balanceCurrency = Country::whereIn('currency',$this->currencyList)->get();
    }

    public function addCurrency($id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $workspace = $user->workspaces()->first();

        $country = Country::where('id',$id)->first();
        $addCuurency = CcCurrencyConversion::create([
            'holder_type' => $workspace->getMorphClass(),
            'holder_id'   => $workspace->getKey(),
            'currency'    => $country->currency,
            'meta'  => [
                'country_id' => $country->id,
                'code' => $country->code,
                'name' => $country->name,
                'flag' => $country->flag,
            ]
        ]);

        return redirect()->route('dashboard.international-transfer.balance.index', ['filter' => ['workspace_id' => app('activeWorkspaceId')]])->with(['status' => 'success', 'message' => 'Currency Added Successfully']);
    }

    public function render()
    {
        return view('international-transfer::livewire.balance-add-currency-component');
    }

}
