@extends('international-transfer::layouts.master')

@push('styles')
    <link rel="stylesheet" href="{{ asset('dist/css/money-transfer.css') }}">
    <link href='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css' rel='stylesheet' type='text/css'>
@endpush

@section('content')
    <div class="grid grid-cols-12 gap-0 mt-0">
        <div class="col-span-12 lg:col-span-12 xxl:col-span-12">
            <div class="grid grid-cols-12 gap-1 mt-0.5">
                <div class="intro-y col-span-12 lg:col-span-12">
                    <div class="tab-content">
                        <div id="RequestCard" class="tab-pane grid grid-cols-12 gap-3 mt-0 active" role="tabpanel"
                            aria-labelledby="RequestCard-tab">
                            <div class="intro-y col-span-12 md:col-span-12 mt-0">
                                <!-- BEGIN: Wizard Layout -->
                                <div class="intro-y box sm:py-10 sm:py-0 mt-0">
                                    <div class="flex items-center p-3 border-b border-gray-200 dark:border-dark-5">
                                        <h2 class="font-medium text-base mr-auto">
                                            Money Transfer
                                        </h2>
                                        <div class="ml-auto pos">
                                            <div class="pos__tabs nav nav-tabs justify-center" role="tablist">
                                                <a id="ticket-tab" data-toggle="tab" data-target="#ticket"
                                                    href="{{ route('dashboard.banking.payouts.index', ['workspace_id' => \Kanexy\PartnerFoundation\Core\Helper::activeWorkspaceId()]) }}"
                                                    class="flex-1 btn-secondary py-1 px-2 mr-2 rounded-md text-center "
                                                    role="tab" aria-controls="ticket" aria-selected="true">Local</a>
                                                <a id="details-tab" data-toggle="tab" data-target="#details"
                                                    href="{{ route('design.money-transfer') }}"
                                                    class="flex-1 btn-secondary py-1 px-2 mr-2 rounded-md text-center active"
                                                    role="tab" aria-controls="details"
                                                    aria-selected="false">International</a>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="wizard flex flex-col lg:flex-row justify-center px-5 pt-4 sm:px-20">
                                        <div class="intro-x lg:text-center flex items-center lg:block flex-1 z-10">
                                            <button class="w-10 h-10 rounded-full btn">1</button>
                                            <div class="lg:w-32 font-medium text-base lg:mt-3 ml-3 lg:mx-auto">Amount</div>
                                        </div>

                                        <div
                                            class="intro-x lg:text-center flex items-center mt-5 lg:mt-0 lg:block flex-1 z-10">
                                            <button class="w-10 h-10 rounded-full btn text-gray-600 dark:bg-dark-1">2</button>
                                            <div class="lg:w-32 text-base lg:mt-3 ml-3 lg:mx-auto text-gray-700 dark:text-gray-600">
                                                Beneficiary</div>
                                        </div>

                                        <div
                                            class="intro-x lg:text-center flex items-center mt-5 lg:mt-0 lg:block flex-1 z-10">
                                            <button class="w-10 h-10 rounded-full btn text-gray-600 bg-gray-200 dark:bg-dark-1">3</button>
                                            <div class="lg:w-32 text-base lg:mt-3 ml-3 lg:mx-auto text-gray-700 dark:text-gray-600">
                                                Payment</div>
                                        </div>

                                        <div
                                            class="intro-x lg:text-center flex items-center mt-5 lg:mt-0 lg:block flex-1 z-10">
                                            <button class="w-10 h-10 rounded-full btn text-gray-600 bg-gray-200 dark:bg-dark-1">4</button>
                                            <div class="lg:w-32 text-base lg:mt-3 ml-3 lg:mx-auto text-gray-700 dark:text-gray-600">
                                                Preview</div>
                                        </div>

                                        <div
                                            class="intro-x lg:text-center flex items-center mt-5 lg:mt-0 lg:block flex-1 z-10">
                                            <button class="w-10 h-10 rounded-full btn text-gray-600 bg-gray-200 dark:bg-dark-1"
                                                data-target="#copy-button-modal">5</button>
                                            <div class="lg:w-32 text-base lg:mt-3 ml-3 lg:mx-auto text-gray-700 dark:text-gray-600">
                                                Finish</div>
                                        </div>

                                        <div
                                            class="wizard__line hidden lg:block w-2/3 bg-gray-200 dark:bg-dark-1 absolute mt-5">
                                        </div>
                                    </div>

                                    @yield('money-transfer-content')

                                </div>
                                <!-- END: Wizard Layout -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- BEGIN: Large Slide Over Content -->
    <div id="large-slide-over-size-preview" class="modal modal-slide-over" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header p-5">
                    <h2 class="font-medium text-base mr-auto">
                        See how we compare with other providers
                    </h2>
                </div>
                <div class="modal-body">



                    <div class="grid grid-cols-12 gap-6 mt-5">
                        <div class="intro-y col-span-12 md:col-span-12">
                            <div class="flex flex-col lg:flex-row border-b border-gray-200 dark:border-dark-5 pb-5 -mx-5">
                                <div
                                    class="sm:flex flex-2 px-4 sm:px-5 items-center justify-center lg:justify-start align-self-center">
                                    <div>
                                        <div class="sm:input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1"
                                                    style="background-color:#fafdff">
                                                    <img src="https://staging.kanexy.com/flags/UK.png"
                                                        style="max-width: 23px;display: inline-block !important;float: left; margin-right:5px;">
                                                    GBP
                                                    <input type="hidden" name="country_code" id="country_code" value="GBP">
                                                </span>
                                                <select class="form-select mt-2 sm:mr-2"
                                                    aria-label="Default select example">
                                                    <option value="1">British pound</option>
                                                    <option value="2">British pound</option>
                                                    <option value="3">British pound</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-20 mt-6 lg:mt-0 px-5 pt-5 lg:pt-0 flex  align-self-center">
                                    <div class="w-10 col-span-1  align-self-center sm:pt-6"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" class="feather feather-repeat">
                                            <polyline points="17 1 21 5 17 9"></polyline>
                                            <path d="M3 11V9a4 4 0 0 1 4-4h14"></path>
                                            <polyline points="7 23 3 19 7 15"></polyline>
                                            <path d="M21 13v2a4 4 0 0 1-4 4H3"></path>
                                        </svg></div>
                                </div>
                                <div
                                    class=" align-self-center mt-6 lg:mt-0 flex-1 px-5 border-t lg:border-0 border-gray-200 dark:border-dark-5 pt-5 lg:pt-0">
                                    <div>
                                        <div class="sm:input-group mb-0">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1"
                                                    style="background-color:#fafdff">
                                                    <img src="https://staging.kanexy.com/flags/UK.png"
                                                        style="max-width: 23px; margin-right:5px;"> INR
                                                    <input type="hidden" name="country_code" id="country_code" value="INR">
                                                </span>
                                                <select class="form-select mt-2 sm:mr-2"
                                                    aria-label="Default select example">
                                                    <option value="1">Indian repee</option>
                                                    <option value="2">Indian repee</option>
                                                    <option value="3">Indian repee</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="intro-y col-span-12 md:col-span-6">
                            <div class="">
                                <div class="flex flex-col lg:flex-row items-center p-0">
                                    <div class="lg:ml-2 lg:mr-auto text-center lg:text-left mt-3 lg:mt-0">
                                        <h3 href="" class="text-theme-19 dark:text-gray-300 text-lg xl:text-xl font-bold">1
                                            GBP = 102.33 INR</h3>
                                        <div class="mt-0.5 text-gray-600 dark:text-gray-600">Mid-market exchange rate</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="intro-y col-span-12 md:col-span-6">
                            <div class="">
                                <div class="flex flex-col lg:flex-row items-center p-0">
                                    <div class="mb-2 relative" style="right:12px;">
                                        <input
                                            class="input border border-gray-400 appearance-none rounded w-full px-3 py-3 pt-5 pb-2 focus focus:border-indigo-600 focus:outline-none active:outline-none active:border-indigo-600"
                                            id="" placeholder="" type="text" autofocus>
                                        <label for=""
                                            class="label absolute mb-0 -mt-2 pt-4 pl-3 leading-tighter text-gray-400 text-base mt-2 cursor-text">You
                                            Send exaxtly</label>

                                        <div id="input-group-email"
                                            class="input-group-text form-inline cuntery-in send-exaxtly">
                                            <span id="tabcuntery-img-flag"><img src="{{ asset('flags/UK.png') }}"></span>
                                            <span>GBP</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- BEGIN: Weekly Top Products -->
                        <div class="intro-y col-span-12 md:col-span-12">
                            <div class="intro-y overflow-auto lg:overflow-visible mt-0 sm:mt-0">
                                <table class="table table-report sm:mt-0">
                                    <thead>
                                        <tr class="bg-gray-200 border-gray-200 pr-10 placeholder-theme-13">
                                            <th class="">Provider</th>
                                            <th class="">Exchange rate (1GBP-INR)</th>
                                            <th class="text-center whitespace-nowrap">Transfer Fee</th>
                                            <th class="text-center ">Recipient gets sending 1,000 GBP</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="intro-x">
                                            <td class="w-40">
                                                <div class="flex">
                                                    <div class="w-10 h-10 image-fit zoom-in">
                                                        <img alt="" class="tooltip rounded-full"
                                                            src="dist/images/preview-12.jpg"
                                                            title="Uploaded at 17 January 2021">
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p href="" class="font-medium whitespace-nowrap">1.15971 <span
                                                        class="notification notification--bullet pl-2"></span></p>
                                                <div class="text-gray-600 text-xs whitespace-nowrap mt-0.5">Mid-market rate
                                                    <sup>[?]</sup>
                                                </div>
                                            </td>
                                            <td class="text-center">20.00 GBP</td>
                                            <td class="w-40">
                                                <div class="flex items-center justify-center text-theme-9"> 102,332.22 INR
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="intro-x">
                                            <td class="w-40">
                                                <div class="flex">
                                                    <div class="w-10 h-10 image-fit zoom-in">
                                                        <img alt="" class="tooltip rounded-full"
                                                            src="dist/images/preview-12.jpg"
                                                            title="Uploaded at 17 January 2021">
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p href="" class="font-medium whitespace-nowrap">1.15971 <span
                                                        class="notification notification--bullet pl-2"></span></p>
                                                <div class="text-gray-600 text-xs whitespace-nowrap mt-0.5">Mid-market rate
                                                    <sup>[?]</sup>
                                                </div>
                                            </td>
                                            <td class="text-center">20.00 GBP</td>
                                            <td class="w-40">
                                                <div class="flex items-center justify-center text-theme-9"> 102,332.22 INR
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="intro-x">
                                            <td class="w-40">
                                                <div class="flex">
                                                    <div class="w-10 h-10 image-fit zoom-in">
                                                        <img alt="" class="tooltip rounded-full"
                                                            src="dist/images/preview-12.jpg"
                                                            title="Uploaded at 17 January 2021">
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p href="" class="font-medium whitespace-nowrap">1.15971 <span
                                                        class="notification notification--bullet pl-2"></span></p>
                                                <div class="text-gray-600 text-xs whitespace-nowrap mt-0.5">Mid-market rate
                                                    <sup>[?]</sup>
                                                </div>
                                            </td>
                                            <td class="text-center">20.00 GBP</td>
                                            <td class="w-40">
                                                <div class="flex items-center justify-center text-theme-9"> 102,332.22 INR
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="intro-x">
                                            <td class="w-40">
                                                <div class="flex">
                                                    <div class="w-10 h-10 image-fit zoom-in">
                                                        <img alt="" class="tooltip rounded-full"
                                                            src="dist/images/preview-12.jpg"
                                                            title="Uploaded at 17 January 2021">
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p href="" class="font-medium whitespace-nowrap">1.15971 <span
                                                        class="notification notification--bullet pl-2"></span></p>
                                                <div class="text-gray-600 text-xs whitespace-nowrap mt-0.5">Mid-market rate
                                                    <sup>[?]</sup>
                                                </div>
                                            </td>
                                            <td class="text-center">20.00 GBP</td>
                                            <td class="w-40">
                                                <div class="flex items-center justify-center text-theme-9"> 102,332.22 INR
                                                </div>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- END: Weekly Top Products -->
                    </div>





                </div>
            </div>
        </div>
    </div>
    <!-- END: Large Slide Over Content -->
    <!-- BEGIN: Myself Modal -->
    <div id="myself-modal" class="modal modal-slide-over" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header p-5">
                    <h2 class="font-medium text-base mr-auto">
                        Send to myself
                    </h2>
                    <div class="items-center justify-center mt-0">
                        {{-- <a data-toggle="modal" data-target="#review-transfer"
                            class="btn-sm bg-indigo-600 btn-primary text-white font-bold py-3 px-6 rounded">Confirm</a> --}}
                    </div>
                </div>
                <div class="modal-body">
                    <div class="p-0">
                        <form>
                          <div class="grid grid-cols-12 md:gap-10 mt-0 mb-3">
                            <div class="col-span-12 md:col-span-6 form-inline mt-2">
                              <label class="form-label sm:w-30">Contact Type <span class="text-theme-6">*</span></label>
                              <div class="sm:w-5/6 sm:pt-1">
                                <div class="flex sm:flex-row mt-2">
                                  <div class="form-check mr-6 mb-2">
                                    <input id="type-personal" class="form-check-input contact-type" type="radio" name="type" value="personal" checked="">
                                    <label class="form-check-label" for="type-personal">Personal</label>
                                  </div>
                                  <div class="form-check mr-2 mb-2 sm:mt-0">
                                    <input id="type-company" class="form-check-input contact-type" type="radio" name="type" value="company">
                                    <label class="form-check-label" for="type-company">Company</label>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="grid grid-cols-12 md:gap-10 mt-0">

                            <div class="col-span-12 md:col-span-6 mt-2">

                                <div class="col-span-12 md:col-span-6 mt-2">
                                    <div class="col-span-12 md:col-span-6 form-inline mt-2">
                                        <label for="bank_country" class="form-label sm:w-30"> Country <span class="text-theme-6">*</span></label>
                                        <div class="sm:w-5/6">
                                        <select name="" data-search="true" class="tail-select w-full " data-select-hidden="display" data-tail-select="tail-1">
                                            <option disabled=""></option>
                                            <option value="1" selected="selected">Andorra</option>
                                            <option value="2">United Arab Emirates</option>
                                            <option value="3">Afghanistan</option>
                                            <option value="4">Antigua and Barbuda</option>
                                            <option value="5">Anguilla</option>
                                            <option value="6">Albania</option>
                                            <option value="7">Armenia</option>
                                            <option value="8">Angola</option>
                                            <option value="9">Antarctica</option>
                                        </select>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-span-12 md:col-span-6 form-inline mt-2">
                                    <label for="first_name" class="form-label sm:w-30">First Name <span class="text-theme-6">*</span></label>
                                    <div class="sm:w-5/6">
                                    <input id="first_name" name="first_name" type="text" class="form-control " value="" required="required">
                                    </div>
                                </div>
                                <div class="col-span-12 md:col-span-6 form-inline mt-2">
                                    <label for="middle_name" class="form-label sm:w-30">Middle Name</label>
                                    <div class="sm:w-5/6">
                                    <input id="middle_name" name="middle_name" type="text" class="form-control " value="">
                                    </div>
                                </div>
                                <div class="col-span-12 md:col-span-6 form-inline mt-2 contact-personal visible">
                                    <label for="last_name" class="form-label sm:w-30">Last Name <span class="text-theme-6">*</span></label>
                                    <div class="sm:w-5/6">
                                    <input id="last_name" name="last_name" type="text" class="form-control " value="" required="required">
                                    </div>
                                </div>
                                <div class="col-span-12 md:col-span-6 form-inline mt-2">
                                    <label for="email" class="form-label sm:w-30">Email Address  </label>
                                    <div class="sm:w-5/6">
                                    <input id="email" name="email" type="email" class="form-control " value="">
                                    </div>
                                </div>
                                <div class="col-span-12 md:col-span-6 form-inline mt-2">
                                    <label for="mobile" class="form-label sm:w-30">Mobile No. </label>
                                    <div class="sm:w-5/6">
                                        <input id="mobile" name="mobile" type="text" class="form-control " value="">
                                    </div>
                                </div>
                                <div class="col-span-12 md:col-span-6 form-inline mt-2">
                                    <label for="mobile" class="form-label sm:w-30">Phone </label>
                                    <div class="sm:w-5/6">
                                        <input id="phone" name="phone" type="text" class="form-control " value="">
                                    </div>
                                </div>
                            </div>


                            <div class="col-span-12 md:col-span-6 mt-2">
                                <div class="col-span-12 md:col-span-6 form-inline mt-2">
                                    <label for="bank_account_name" class="form-label sm:w-30"> Account Name <span class="text-theme-6">*</span></label>
                                    <div class="sm:w-5/6">
                                      <input id="bank_account_name" name="" type="text" class="form-control " value="" required="">
                                    </div>
                                </div>
                                <div class="col-span-12 md:col-span-6 form-inline mt-2">
                                    <label for="middle_name" class="form-label sm:w-30">IFSC Code/IBAN <span class="text-theme-6">*</span></label>
                                    <div class="sm:w-5/6">
                                        <input id="middle_name" name="middle_name" type="text" class="form-control " value="" required="required">
                                    </div>
                                </div>
                                <div class="col-span-12 md:col-span-6 form-inline mt-2 contact-personal visible">
                                    <label for="last_name" class="form-label sm:w-30">Account No <span class="text-theme-6">*</span></label>
                                    <div class="sm:w-5/6">
                                      <input id="last_name" name="last_name" type="text" class="form-control " value="" required="required">
                                    </div>
                                </div>
                                <div class="col-span-12 md:col-span-6 form-inline mt-2 contact-company">
                                    <label for="company_name" class="form-label sm:w-30">SWIFT Code </label>
                                    <div class="sm:w-5/6">
                                      <input id="company_name" name="company_name" type="text" class="form-control " value="">
                                    </div>
                                </div>
                                <div class="col-span-12 md:col-span-6 form-inline mt-2" style="align-items: initial;">
                                    <label for="email" class="form-label sm:w-30">Notes  </label>
                                    <div class="sm:w-5/6">
                                      <textarea class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-span-12 md:col-span-6 form-inline mt-2">
                                    <label for="avatar" class="form-label sm:w-30">Avatar</label>
                                    <div class="sm:w-5/6">
                                      <input id="avatar" name="avatar" type="file" class="form-control " value="">
                                    </div>
                                </div>
                            </div>
                          </div>



                          <div class="text-right mt-5">
                            <a href="" class="btn btn-secondary w-24 inline-block mr-1">Cancel</a>
                            <button type="submit" class="btn btn-primary w-24">Create</button>
                          </div>
                        </form>


                      </div>




                </div>
            </div>
        </div>
    </div>
    <!-- END: Myself Modal -->
    <div id="review-transfer" class="modal modal-slide-over" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header p-5">
                    <h2 class="font-medium text-3xl text-base m-auto">
                        Review Your Transfer
                    </h2>
                </div>
                <div class="modal-body clearfix">
                    <div>
                        <button class="btn btn-outline-primary w-full btn-rounded block p-3 mb-3">40,000.43 INR will reach
                            john smith account</button>
                    </div>

                    <div class="intro-y grid grid-cols-12 gap-6 mt-5">
                        <div class="col-span-12 lg:col-span-12">
                            <div class="intro-y box mb-3">
                                <div
                                    class="flex flex-col sm:flex-row items-center p-2 border-b border-gray-200 dark:border-dark-5">
                                    <h2 class="font-medium text-base mr-auto">
                                        Sender Account Deetails
                                    </h2>
                                    <div class="w-full sm:w-auto flex items-center sm:ml-auto mt-3 sm:mt-0">
                                        <a href=""
                                            class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-check-square w-4 h-4 mr-1">
                                                <polyline points="9 11 12 14 22 4"></polyline>
                                                <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                                            </svg> Edit </a>
                                    </div>
                                </div>
                                <div class="grid grid-cols-12 gap-10 p-4 my-0">
                                    <div class="intro-y col-span-12 md:col-span-6">
                                        <div class="">
                                            <div class="flex flex-col lg:flex-row items-center p-0">
                                                <div class="lg:ml-2 lg:mr-auto text-center lg:text-left mt-3 lg:mt-0">
                                                    <h3 href=""
                                                        class="text-theme-19 dark:text-gray-300 text-lg xl:text-xl font-bold">
                                                        IFSC Code</h3>
                                                    <div class="mt-0.5 text-gray-600 dark:text-gray-600">SBIN000322</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="intro-y col-span-12 md:col-span-6">
                                        <div class="">
                                            <div class="flex flex-col lg:flex-row items-center p-0">
                                                <div class="lg:ml-2 lg:mr-auto text-center lg:text-left mt-3 lg:mt-0">
                                                    <h3 href=""
                                                        class="text-theme-19 dark:text-gray-300 text-lg xl:text-xl font-bold">
                                                        Account Number</h3>
                                                    <div class="mt-0.5 text-gray-600 dark:text-gray-600">43245234523443
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-span-12 lg:col-span-12 mb-5">
                        <div class="intro-y box mb-3">
                            <div
                                class="flex flex-col sm:flex-row items-center p-2 border-b border-gray-200 dark:border-dark-5">
                                <h2 class="font-medium text-base mr-auto">
                                    Receive Account Deetails
                                </h2>
                                <div class="w-full sm:w-auto flex items-center sm:ml-auto mt-3 sm:mt-0">
                                    <a href=""
                                        class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" class="feather feather-check-square w-4 h-4 mr-1">
                                            <polyline points="9 11 12 14 22 4"></polyline>
                                            <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                                        </svg> Edit </a>
                                </div>
                            </div>
                            <div class="grid grid-cols-12 gap-10 p-4 my-0">
                                <div class="intro-y col-span-12 md:col-span-6">
                                    <div class="">
                                        <div class="flex flex-col lg:flex-row items-center p-0">
                                            <div class="lg:ml-2 lg:mr-auto text-center lg:text-left mt-3 lg:mt-0">
                                                <h3 href=""
                                                    class="text-theme-19 dark:text-gray-300 text-lg xl:text-xl font-bold">
                                                    Your Sending</h3>
                                                <div class="mt-0.5 text-gray-600 dark:text-gray-600">500.00 GBP</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="intro-y col-span-12 md:col-span-6">
                                    <div class="">
                                        <div class="flex flex-col lg:flex-row items-center p-0">
                                            <div class="lg:ml-2 lg:mr-auto text-center lg:text-left mt-3 lg:mt-0">
                                                <h3 href=""
                                                    class="text-theme-19 dark:text-gray-300 text-lg xl:text-xl font-bold">
                                                    Receiver</h3>
                                                <div class="mt-0.5 text-gray-600 dark:text-gray-600">44,434 INR</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="intro-y col-span-12 md:col-span-6">
                                    <div class="">
                                        <div class="flex flex-col lg:flex-row items-center p-0">
                                            <div class="lg:ml-2 lg:mr-auto text-center lg:text-left mt-3 lg:mt-0">
                                                <h3 href=""
                                                    class="text-theme-19 dark:text-gray-300 text-lg xl:text-xl font-bold">
                                                    Rate Guaranted</h3>
                                                <div class="mt-0.5 text-gray-600 dark:text-gray-600">95.434</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="intro-y col-span-12 md:col-span-6">
                                    <div class="">
                                        <div class="flex flex-col lg:flex-row items-center p-0">
                                            <div class="lg:ml-2 lg:mr-auto text-center lg:text-left mt-3 lg:mt-0">
                                                <h3 href=""
                                                    class="text-theme-19 dark:text-gray-300 text-lg xl:text-xl font-bold">
                                                    Fee</h3>
                                                <div class="mt-0.5 text-gray-600 dark:text-gray-600">0.343 GBP</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-span-12 lg:col-span-12 mb-5">
                    <div class="intro-y box mb-3">
                        <div
                            class="flex flex-col sm:flex-row items-center p-2 border-b border-gray-200 dark:border-dark-5">
                            <h2 class="font-medium text-base m-auto">
                                Refrence For John Smith Payment
                            </h2>

                        </div>
                        <div class="clearfix"></div>
                        <!-- BEGIN: General Statistics -->
                        <div class="intro-y box col-span-12 xxl:col-span-6">
                            <div class="flex items-center px-5 py-5 sm:py-3 border-b border-gray-200 dark:border-dark-5">

                                <div class="dropdown m-auto">
                                    <a class="w-full dropdown-toggle w-5 h-5 block sm:hidden" href="javascript:;"
                                        aria-expanded="false"> <i data-feather="more-horizontal"
                                            class="w-5 h-5 text-gray-600 dark:text-gray-300"></i> </a>
                                    <button
                                        class="w-full dropdown-toggle btn btn-outline-secondary font-normal hidden sm:flex"
                                        aria-expanded="false"> Export <i data-feather="chevron-down"
                                            class="w-4 h-4 ml-2"></i> </button>
                                    <div class="dropdown-menu w-40">
                                        <div class="dropdown-menu__content box dark:bg-dark-1">
                                            <div class="px-4 py-2 border-b border-gray-200 dark:border-dark-5 font-medium">
                                                Export Tools</div>
                                            <div class="p-2">
                                                <a href=""
                                                    class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                                    <i data-feather="printer"
                                                        class="w-4 h-4 text-gray-700 dark:text-gray-300 mr-2"></i> Print
                                                </a>
                                                <a href=""
                                                    class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                                    <i data-feather="external-link"
                                                        class="w-4 h-4 text-gray-700 dark:text-gray-300 mr-2"></i> Excel
                                                </a>
                                                <a href=""
                                                    class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                                    <i data-feather="file-text"
                                                        class="w-4 h-4 text-gray-700 dark:text-gray-300 mr-2"></i> CSV </a>
                                                <a href=""
                                                    class="flex items-center block p-2 transition duration-300 ease-in-out bg-white dark:bg-dark-1 hover:bg-gray-200 dark:hover:bg-dark-2 rounded-md">
                                                    <i data-feather="archive"
                                                        class="w-4 h-4 text-gray-700 dark:text-gray-300 mr-2"></i> PDF </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- END: General Statistics -->

                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="items-center justify-center mt-5">
                    <button
                        class="w-full h-12 px-6 text-indigo-100 transition-colors duration-150 bg-indigo-700 rounded-lg focus:shadow-outline hover:bg-indigo-800">Continue</button>
                </div>
                <div class="clearfix"></div>

            </div>
        </div>
    </div>
    </div>
    <div id="superlarge-slide-over-size-preview" class="modal modal-slide-over" tabindex="-1" aria-hidden="true"
        style="padding-left: 0px;">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header py-1">
                    <h2 class="font-medium text-base mr-auto">
                        All activity
                    </h2>
                    <div class="text-right btn-sm mt-0 py-1 p-0">
                        <button class="btn btn-primary" >Cancel transfer</button>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="intro-y flex flex-col sm:flex-row items-center mt-0">
                        <h2 class="text-lg text-theme-1 dark:text-theme-10 font-medium mr-auto">
                            In Progress
                        </h2>
                        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                            <div class="ml-auto">
                                <div class="intro-x relative mr-0 sm:mr-0">
                                    <div class="search hidden sm:block">
                                        <input type="text"
                                            class="search__input form-control border-transparent placeholder-theme-13"
                                            placeholder="Search...">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round"
                                            class="feather feather-search search__icon dark:text-gray-300">
                                            <circle cx="11" cy="11" r="8"></circle>
                                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="intro-y col-span-12 md:col-span-12 mt-3">
                        <div class="box bg-gray-300">
                            <div class="flex flex-col lg:flex-row items-center p-5">
                                <div class="w-12 h-12 lg:w-12 lg:h-12 image-fit lg:mr-1">
                                    <a href="http://localhost:8000/workspaces/profile"
                                        class="bg-gray-200 p-3 rounded-full text-theme-1 flex items-center block p-2 transition duration-300 ease-in-out hover:bg-theme-1 dark:hover:bg-dark-3 rounded-md">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" class="feather feather-send w-6 h-6">
                                            <line x1="22" y1="2" x2="11" y2="13"></line>
                                            <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                                        </svg>
                                    </a>

                                </div>
                                <div class="lg:ml-2 lg:mr-auto text-center lg:text-left mt-3 lg:mt-0">
                                    <a href="" class="font-medium">To Andra Tyler</a>
                                    <div class="text-gray-600 text-xs mt-0.5">Sending</div>
                                </div>

                                <div class="lg:ml-2 lg:ml-auto text-center lg:text-right mt-3 lg:mt-0">
                                    <a href="" class="font-medium">1,00000 INR</a>
                                    <div class="text-gray-600 text-xs mt-0.5">900 USD</div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="intro-y col-span-12 md:col-span-12 mt-3">
                        <div class="box">
                            <div class="flex flex-col lg:flex-row items-center p-5">
                                <table class="relative ttt">
                                    <tr>
                                        <td><span>Today at 5:33 pm </span></td>
                                        <td class="list-dot"></td>
                                        <td style="padding-left: 60px;">
                                            <p>
                                                You set up your transfer
                                                Your money on its way to us
                                                Your bank might take up to <strong>9 hours</strong> to get it us. we'll let
                                                you know when it arrives
                                                <br><span
                                                    class="border-2 border-dashed shadow-sm border-gray-200 dark:border-dark-5 rounded-md py-2 px-4 mt-3 inline-block">I've
                                                    not paid</span>
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span>Tomorrow at 2:30 am </span></td>
                                        <td class="list-dot"></td>
                                        <td style="padding-left: 60px;">
                                            <p>
                                                We receive your GBP
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span>Tomorrow at 2:30 am </span></td>
                                        <td class="list-dot"></td>
                                        <td style="padding-left: 60px;">
                                            <p>
                                                We pay out your INR
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span>Tomorrow at 2:30 am </span></td>
                                        <td class="list-dot"></td>
                                        <td style="padding-left: 60px;">
                                            <p>
                                                Recever receives your INR
                                            </p>
                                        </td>
                                    </tr>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

