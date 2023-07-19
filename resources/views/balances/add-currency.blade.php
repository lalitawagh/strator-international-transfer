@extends('international-transfer::layouts.master')

@section('content')
    <div class="grid grid-cols-12 gap-6">

        <div class="col-span-12">
            <div class="box">
                <div id="1" class="tab-pane grid grid-cols-12 gap-3 pt-0 active" role="tabpanel"
                    aria-labelledby="1-tab">
                    <div class="active col-span-12 mt-0 w-full" role="tabpanel" id="k-wallet" aria-labelledby="k-wallet-tab">
                        <div class="flex items-center px-3 py-2 border-b border-gray-200 dark:border-dark-5">
                            <h2 class="text-lg font-medium truncate mr-auto">
                                Add Currency
                            </h2>
                        </div>
                        @livewire('balance-add-currency-component')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
