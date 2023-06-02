<?php

namespace Kanexy\InternationalTransfer\Http\Controllers;

use Kanexy\Cms\Controllers\Controller;
use Kanexy\Cms\I18N\Models\Country;
use Kanexy\InternationalTransfer\Http\Requests\StoreExchangeRateRequest;
use Kanexy\InternationalTransfer\Model\CcExchangeRate;
use Kanexy\InternationalTransfer\Policies\ExchangeRatePolicy;
use Kanexy\InternationalTransfer\Contracts\ExchangeRateConfiguration;

class ExchangeRateController extends Controller
{
    public function index()
    {

        $this->authorize(ExchangeRatePolicy::VIEW, ExchangeRateConfiguration::class);

        //$exchange_rates = ExchangeRate::with('ledger')->orderBy('id', 'desc')->paginate(7);
        return view("international-transfer::configuration.exchange-rate.index");
    }

    public function create()
    {
        $this->authorize(ExchangeRatePolicy::CREATE, ExchangeRateConfiguration::class);

        $countries = Country::orderBy("name")->pluck("name", "id");

        return view("international-transfer::configuration.exchange-rate.create",compact('countries'));
    }

    public function store(StoreExchangeRateRequest $request)
    {
        $data = $request->validated();
        $data['id'] = now()->format('dmYHis');
       // $ExchangeRate = collect(cc_exchange_rate::getValue('exchange_from','exchange_to','rate_type','customized_rate','plus_mins','percentage',[]));
        //cc_exchange_rate::updateOrCreate(['key' => 'money_transfer_type_fees'], ['value' => $ExchangeRate]);

            $ExchangeRate= New CcExchangeRate();
            $ExchangeRate->fill($request->post())->save();

            return redirect()->route('dashboard.international-transfer.exchange-rate.index')->with([
                'status' => 'success',
                'message' => 'Exchange Rate created successfully.',
            ]);

    }

    public function edit($value)
    {
        //dd($value);
        $ExchangeRate = CcExchangeRate::where('id',$value)->first();
        //dd($ExchangeRate);

        $countries = Country::orderBy("name")->pluck("name", "id");
        //dd($countries);
        //$this->authorize(ExchangeRatePolicy::EDIT, ExchangeRateConfiguration::class);
        // $statuses = Status::toArray();
        // $transfer_type_fee = collect(CcExchangeRate::getValue('money_transfer_type_fees',[]))->firstWhere('id', $id);
        // $countries = Country::get();
        //$fee_types = Fee::toArray();

        return view("international-transfer::configuration.exchange-rate.edit",compact('countries','ExchangeRate'));

    }

    public function update(StoreExchangeRateRequest $request, $exchange_rate_id)
    {
        $exchange_rate = CcExchangeRate::findOrFail($exchange_rate_id);
        $validated_data = $request->validated();
        $exchange_rate->fill($validated_data)->save();

        // $data['amount'] = ($data['fee_type'] == 'amount') ? $data['amount'] : 0;
        // $data['percentage'] = ($data['fee_type'] == 'percentage') ? $data['percentage'] : 0;
        // $settings = collect(Setting::getValue('money_transfer_type_fees'))->map(function ($item) use ($id,$data) {
        //     if ($item['id'] == $id) {
        //         return $data;
        //     }

        //     return $item;
        // });
        return redirect()->route("dashboard.international-transfer.exchange-rate.index")->with([
            'status' => 'success',
            'message' => 'Exchange Rate updated successfully.',
        ]);
    }

   public function destroy($id)
   {
        // $exchange_rate = collect(CcExchangeRate::where('id', $request->id)->get())->filter(function ($item) use ($id) {

        //     if ($item['id'] != $id) {
        //         return true;
        //     }
        //     return false;
        // });
        // $exchange_rate->each(function ($item) use ($id) {
        //     $item->delete();
        // });

        $Exchange_Rate = CcExchangeRate::find($id);
        $Exchange_Rate->delete();

        return redirect()->route("dashboard.international-transfer.exchange-rate.index")->with([
            'status' => 'success',
            'message' => 'Exchange rate deleted successfully.',
        ]);

  }

}
