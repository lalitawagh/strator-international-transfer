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
        $ExchangeRate= New CcExchangeRate();
        $ExchangeRate->fill($request->post())->save();
        return redirect()->route('dashboard.international-transfer.exchange-rate.index')->with([
            'status' => 'success',
            'message' => 'Exchange Rate created successfully.',
        ]);

    }

    public function edit($value)
    {

        $ExchangeRate = CcExchangeRate::where('id',$value)->first();
        $countries = Country::orderBy("name")->pluck("name", "id");

        $this->authorize(ExchangeRatePolicy::EDIT, ExchangeRateConfiguration::class);

        return view("international-transfer::configuration.exchange-rate.edit",compact('countries','ExchangeRate'));

    }

    public function update(StoreExchangeRateRequest $request, $exchange_rate_id)
    {
        $exchange_rate = CcExchangeRate::findOrFail($exchange_rate_id);
        $validated_data = $request->validated();
        $exchange_rate->fill($validated_data)->save();

        return redirect()->route("dashboard.international-transfer.exchange-rate.index")->with([
            'status' => 'success',
            'message' => 'Exchange Rate updated successfully.',
        ]);
    }

   public function destroy($id)
   {

        $Exchange_Rate = CcExchangeRate::find($id);
        $Exchange_Rate->delete();

        return redirect()->route("dashboard.international-transfer.exchange-rate.index")->with([
            'status' => 'success',
            'message' => 'Exchange rate deleted successfully.',
        ]);

  }

}
