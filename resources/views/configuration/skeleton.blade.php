@extends('international-transfer::layouts.master')

@push('styles')
    <link rel="stylesheet" href="{{ asset('dist/css/config.css') }}">
@endpush

@section('content')
    <div class="sm:flex w-full gap-3 mt-5">
        <div class="intro-y box sm:w-1/4 configuration-nav configuration-layout-sidebar">
            <div class="configuration-nav configuration-layout-sidebar" x-data="toggleConfigurationSidebarMenu()">
                <div class="items-center p-0">
                    <div class="breadcrumb mr-auto p-3">
                        <a id="Configuration" href="" class="">Configuration</a>
                    </div>
                    <div class="side-nav pt-3 p-0 border-t border-gray-200 dark:border-dark-5">
                        <ul>
                            @can(\Kanexy\InternationalTransfer\Policies\TransferTypeFeePolicy::VIEW,
                                \Kanexy\InternationalTransfer\Contracts\TransferTypeFeeConfiguration::class)
                                <li>
                                    <a id="TransferTypeFee"href="{{ route('dashboard.international-transfer.transfer-type-fee.index') }}"
                                        class="side-menu">
                                        <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                                        <div class="side-menu__title">Transfer Type Fee </div>
                                    </a>
                                </li>
                            @endcan
                            @can(\Kanexy\InternationalTransfer\Policies\FeePolicy::VIEW,
                                \Kanexy\InternationalTransfer\Contracts\FeeConfiguration::class)
                                <li>
                                    <a id="FeeSetup" href="{{ route('dashboard.international-transfer.fee.index') }}"
                                        class="side-menu">
                                        <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                                        <div class="side-menu__title"> Fee Setup </div>
                                    </a>
                                </li>
                            @endcan
                            @can(\Kanexy\InternationalTransfer\Policies\TransferReasonPolicy::VIEW,
                                \Kanexy\InternationalTransfer\Contracts\TransferReasonConfiguration::class)
                                <li>
                                    <a id="TransferReason"
                                        href="{{ route('dashboard.international-transfer.transfer-reason.index') }}"
                                        class="side-menu">
                                        <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                                        <div class="side-menu__title"> Transfer Reason </div>
                                    </a>
                                </li>
                            @endcan
                            @can(\Kanexy\InternationalTransfer\Policies\MasterAccountPolicy::VIEW,
                                \Kanexy\InternationalTransfer\Contracts\MasterAccountConfiguration::class)
                                <li>
                                    <a id="MTCAccount"
                                        href="{{ route('dashboard.international-transfer.master-account.index') }}"
                                        class="side-menu">
                                        <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                                        <div class="side-menu__title"> MTC Account </div>
                                    </a>
                                </li>
                            @endcan
                            <li>
                                <a id="Notifications" href="javascript:void(0);" class="side-menu">
                                    <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                                    <div class="side-menu__title"> Notifications </div>
                                </a>
                            </li>
                            @if (config('services.risk_management') == true)
                                <li>
                                    <a id="RiskManagement"
                                        href="{{ route('dashboard.international-transfer.riskManagement') }}"
                                        class="side-menu">
                                        <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                                        <div class="side-menu__title"> Risk Management </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('dashboard.international-transfer.risk-management-questions.index') }}"
                                        class="side-menu">
                                        <div class="side-menu__icon"> <i data-lucide="activity"></i> </div>
                                        <div class="side-menu__title"> Risk Management Questions</div>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>

                <div class="configarrow-toggle">
                    <span id="ArrowLeft" x-on:click="toggle" class="w-5 h-5 block" href="javascript:;"
                        aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-arrow-left block mx-auto block mx-auto">
                            <line x1="19" y1="12" x2="5" y2="12"></line>
                            <polyline points="12 19 5 12 12 5"></polyline>
                        </svg>
                    </span>
                </div>
            </div>

        </div>
        <div class="configuration-container w-screen">
            <div class="grid grid-cols-12 gap-6">
                <div class="intro-y box col-span-12 xxl:col-span-12">
                    @include('international-transfer::configuration.breadcrumb')
                    @yield('config-content')
                </div>
            </div>
        </div>
    </div>
    @livewire('confirmation-modal')
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
    </script>
@endpush
