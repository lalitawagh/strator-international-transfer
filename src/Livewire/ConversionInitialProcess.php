<?php

namespace Kanexy\InternationalTransfer\Livewire;

use Carbon\Carbon;
use Kanexy\Cms\I18N\Models\Country;
use Kanexy\Cms\Setting\Models\Setting;
use Kanexy\CurrencyCloud\Dtos\RateDetailedExchangeDto;
use Kanexy\CurrencyCloud\Services\CurrencyCloudApiService;
use Kanexy\InternationalTransfer\Enums\Status;
use Kanexy\InternationalTransfer\Http\Helper;
use Kanexy\InternationalTransfer\Models\CcExchangeRate;
use Kanexy\PartnerFoundation\Core\Enums\ExchangeCurrencyEnum;
use Kanexy\PartnerFoundation\Workspace\Models\WorkspaceMeta;
use Livewire\Component;

use function PHPUnit\Framework\isEmpty;

class ConversionInitialProcess extends Component
{
    public $countries;

    public $defaultCountry;

    public string $currency_from;

    public string $currency_to;

    public string $recipient_amount;

    public string $guaranteed_rate;

    public string $from;

    public string $to;

    public $fees;

    public string $fee_charge;

    public string $fee_deduction_amount;

    public string $actual_amount;

    public  $amount;

    public  $initial_fee;

    public $feeMethod;

    public $countryCurrency;

    public $sendingCurrency;

    public $receivingCurrency;

    public $sendingcountriesinfo;

    public $receivingcountriesinfo;

    protected $listeners = [
        'changeToMethod',
    ];

    public function mount($countries, $defaultCountry)
    {
        $this->countries = $countries;

        $this->defaultCountry = $defaultCountry;

        $this->currency_from = $defaultCountry->id;

        $from = @Setting::getValue('international-transfer_sending_currency',[])[0] ? @Setting::getValue('international-transfer_sending_currency',[])[0] :  231;
        $to = @Setting::getValue('international-transfer_receiving_currency',[])[0] ? @Setting::getValue('international-transfer_receiving_currency',[])[0] : 105;

        $this->currency_from = Country::whereId($from)->first()?->id;

        $this->currency_to =  Country::whereId($to)->first()?->id;

        $this->countryCurrency = Country::whereIn('currency',['AUD','CAD','CZK','DKK','EUR','GBP','USD','HUF','INR','NOK','RON','SEK'])->get();

        $this->sendingCurrency = Setting::getValue('international_transfer_balance_country',[]);

        $this->receivingCurrency = Setting::getValue('international_transfer_balance_country',[]);

        $this->sendingcountriesinfo = Country::whereIn('id',$this->sendingCurrency)->get();

        $this->receivingcountriesinfo = Country::whereIn('id',$this->receivingCurrency)->get();

        // $this->getDetails();

    }

    // public function hydrate()
    // {
    //     $this->dispatchBrowserEvent('transfer-on-process');
    // }


    // public function dehydrate()
    // {
    //     $this->dispatchBrowserEvent('can-transfer');
    // }
    public function changeFromCurrency($value)
    {
        $this->currency_from = $value;

        $this->dispatchBrowserEvent('UpdateLivewireSelect');

    }

    public function changeToCurrency($value)
    {
        $this->currency_to = $value;

        // $this->getDetails();

        $this->dispatchBrowserEvent('UpdateLivewireSelect');
    }



    public function render()
    {
        return view('international-transfer::livewire.conversion-initial-process');
    }

}
