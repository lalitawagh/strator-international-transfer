@extends('ledger-foundation::layouts.master')



@section('content')
    <div class="md:flex w-full gap-3 mt-0">
        <div class="flex lg:block flex-col-reverse configuration-nav configuration-layout-sidebar">
            <div class="intro-y box mt-0 lg:mt-0" x-data="toggleConfigurationSidebarMenu()">
                <div class="relative flex items-center p-3">
                    <div class="breadcrumb mr-auto hidden sm:flex">
                        <a href="">MoneyTransfer</a><svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-chevron-right breadcrumb__icon breadcrumb__icon">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                        <a href="" class="">Configuration</a>
                    </div>
                </div>
                <div class="side-nav p-5 border-t border-gray-200 dark:border-dark-5">
                    <ul>
                        <li>
                            <a href="#" class="side-menu">
                                <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                                <div class="side-menu__title"> General </div>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.wallet.ledger.index') }}"
                                class="side-menu @if (Route::current()->getName() == 'dashboard.wallet.ledger.index' || Route::current()->getName() == 'dashboard.wallet.ledger.create' || Route::current()->getName() == 'dashboard.wallet.ledger.edit') side-menu--active @endif">
                                <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                                <div class="side-menu__title"> Ledgers </div>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;.html"
                                class="side-menu
                                @if (Route::current()->getName() == 'dashboard.wallet.asset-type.index' || Route::current()->getName() == 'dashboard.wallet.asset-type.create' || Route::current()->getName() == 'dashboard.wallet.asset-type.edit' || Route::current()->getName() == 'dashboard.wallet.asset-class.index' || Route::current()->getName() == 'dashboard.wallet.asset-class.create' || Route::current()->getName() == 'dashboard.wallet.asset-class.edit' || Route::current()->getName() == 'dashboard.wallet.commodity-type.index' || Route::current()->getName() == 'dashboard.wallet.commodity-type.create' || Route::current()->getName() == 'dashboard.wallet.commodity-type.edit')
                                    side-menu--active side-menu--open
                                @endif">
                                <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                                <div class="side-menu__title">
                                    Config Fields
                                    <div class="side-menu__sub-icon"> <i data-feather="chevron-down"></i> </div>
                                </div>
                            </a>
                            @if (Route::current()->getName() == 'dashboard.wallet.asset-type.index' || Route::current()->getName() == 'dashboard.wallet.asset-type.create' || Route::current()->getName() == 'dashboard.wallet.asset-type.edit' || Route::current()->getName() == 'dashboard.wallet.asset-class.index' || Route::current()->getName() == 'dashboard.wallet.asset-class.create' || Route::current()->getName() == 'dashboard.wallet.asset-class.edit' || Route::current()->getName() == 'dashboard.wallet.commodity-type.index' || Route::current()->getName() == 'dashboard.wallet.commodity-type.create' || Route::current()->getName() == 'dashboard.wallet.commodity-type.edit')
                                <ul class="xl:pl-6 sm:pl-6 side-menu__sub-open" style="display: block;">
                                @else
                                    <ul class="xl:pl-6 sm:pl-6">
                            @endif
                        <li>
                            <a href="{{ route('dashboard.wallet.asset-type.index') }}"
                                class="side-menu  @if (Route::current()->getName() == 'dashboard.wallet.asset-type.index' || Route::current()->getName() == 'dashboard.wallet.asset-type.create' || Route::current()->getName() == 'dashboard.wallet.asset-type.edit')
                                         side-menu--active @endif">
                                <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                                <div class="side-menu__title"> Asset Type </div>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.wallet.asset-class.index') }}"
                                class="side-menu
                                    @if (Route::current()->getName() == 'dashboard.wallet.asset-class.index' || Route::current()->getName() == 'dashboard.wallet.asset-class.create' || Route::current()->getName() == 'dashboard.wallet.asset-class.edit')
                                         side-menu--active @endif">
                                <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                                <div class="side-menu__title"> Asset Class </div>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.wallet.commodity-type.index') }}"
                                class="side-menu @if (Route::current()->getName() == 'dashboard.wallet.commodity-type.index' || Route::current()->getName() == 'dashboard.wallet.commodity-type.create' || Route::current()->getName() == 'dashboard.wallet.commodity-type.edit')  side-menu--active @endif">
                                <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                                <div class="side-menu__title"> Commodity Type </div>
                            </a>
                        </li>
                    </ul>
                    </li>
                    <li>
                        <a href="{{ route('dashboard.wallet.exchange-rate.index') }}"
                            class="side-menu @if (Route::current()->getName() == 'dashboard.wallet.exchange-rate.index' || Route::current()->getName() == 'dashboard.wallet.exchange-rate.create' || Route::current()->getName() == 'dashboard.wallet.exchange-rate.edit') side-menu--active @endif">
                            <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="side-menu__title"> Exchange Rate </div>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="side-menu">
                            <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="side-menu__title"> Notifications </div>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="side-menu">
                            <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="side-menu__title"> ForEx </div>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="side-menu">
                            <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="side-menu__title"> Fees Setup </div>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="side-menu">
                            <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="side-menu__title"> Payment Methods </div>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="side-menu">
                            <div class="side-menu__icon"> <i data-feather="activity"></i> </div>
                            <div class="side-menu__title"> Preferences </div>
                        </a>
                    </li>
                    </ul>
                </div>
                <div class="configarrow-toggle">
                    <span x-on:click="toggle" class="w-5 h-5 block" href="javascript:;" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-arrow-left block mx-auto block mx-auto">
                            <line x1="19" y1="12" x2="5" y2="12"></line>
                            <polyline points="12 19 5 12 12 5"></polyline>
                        </svg>
                    </span>
                </div>
            </div>

        </div>
        @yield('config-content')
    </div>
@endsection

@push('scripts')
    <script>
        function toggleConfigurationSidebarMenu() {
            return {
                toggle() {
                    $(".configuration-layout-sidebar").toggleClass("side-nav--simple");
                    $(".configuration-container").toggleClass("active");
                }
            }
        }

        function toggleHardStop(the) {
            var value = $(the).val();
            if($(the).prop("checked"))
            {
                $(".valid_date").removeClass("hidden");
                $(".valid_date").toggleClass("valid_date_show");
            }else{
                $(".valid_date").removeClass("valid_date_show");
                $(".valid_date").toggleClass("hidden");
            }

        }
    </script>
@endpush
