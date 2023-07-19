<div id="cc-account-settings" class="tab-pane grid grid-cols-12 gap-3 @if(session('tab') == 'cc-account-settings') active @endif" role="tabpanel" aria-labelledby="wrappex-settings-tab">
    <div class="col-span-12">
        <div class="box">
           
            <div class="px-5 pb-3">
                <form action="{{ route('dashboard.international-transfer.cc-account-settings.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @if (Session::has('error'))
                        <span class="block text-theme-6 pt-5">{{ Session::get('error') }}</span>
                    @endif
                    <div class="grid grid-cols-12 md:gap-3 lg:gap-3 xl:gap-8 mt-0">
                        <div class="col-span-12 md:col-span-12 lg:col-span-6 form-inline mt-2">
                            <label for="client_id" class="form-label sm:w-64">CC Acccount Client Id <span
                                    class="text-theme-6">*</span></label>
                            <div class="sm:w-5/6">
                                <input id="cc_account_client_id" name="cc_account_client_id" type="text"
                                    class="form-control @error('cc_account_client_id') border-theme-6 @enderror"
                                    placeholder=""
                                    value="{{ old('cc_account_client_id', @$settings['cc_account_client_id']) }}" required>

                                @error('cc_account_client_id')
                                    <span class="block text-theme-6 mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-span-12 md:col-span-12 lg:col-span-6 form-inline mt-2">
                            <label for="cc_account_client_secret" class="form-label sm:w-64">CC Acccount Client Secret <span
                                    class="text-theme-6">*</span></label>
                            <div class="sm:w-5/6">
                                <input id="cc_account_client_secret" name="cc_account_client_secret" type="password"
                                    class="form-control @error('cc_account_client_secret') border-theme-6 @enderror"
                                    placeholder=""
                                    value="{{ old('cc_account_client_secret', @$settings['cc_account_client_secret']) }}"
                                    required>

                                @error('cc_account_client_secret')
                                    <span class="block text-theme-6 mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-12 md:gap-3 lg:gap-3 xl:gap-8 mt-0">
                        <div class="col-span-12 md:col-span-12 lg:col-span-6 form-inline mt-2">
                            <label for="cc_account_email" class="form-label sm:w-64">CC Acccount Email <span
                                    class="text-theme-6">*</span></label>
                            <div class="sm:w-5/6">
                                <input id="cc_account_email" name="cc_account_email" type="text"
                                    class="form-control @error('cc_account_email') border-theme-6 @enderror" placeholder=""
                                    value="{{ old('cc_account_email', @$settings['cc_account_email']) }}" required>

                                @error('cc_account_email')
                                    <span class="block text-theme-6 mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-span-12 md:col-span-12 lg:col-span-6 form-inline mt-2">
                            <label for="cc_account_password" class="form-label sm:w-64">CC Acccount Password <span
                                    class="text-theme-6">*</span></label>
                            <div class="sm:w-5/6">
                                <input id="cc_account_password" name="cc_account_password" type="password"
                                    class="form-control @error('cc_account_password') border-theme-6 @enderror"
                                    placeholder="" value="{{ old('cc_account_password', @$settings['cc_account_password']) }}"
                                    required>

                                @error('cc_account_password')
                                    <span class="block text-theme-6 mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-12 md:gap-3 lg:gap-3 xl:gap-8 mt-0">
                        <div class="col-span-12 md:col-span-12 lg:col-span-6 form-inline mt-2">
                            <label for="cc_account_environment" class="form-label sm:w-64">CC Acccount Environment <span
                                    class="text-theme-6">*</span></label>
                            <div class="sm:w-5/6 tillselect-marging">
                                <select id="cc_account_environment" name="cc_account_environment" data-search="true"
                                    class="w-full @error('cc_account_environment') border-theme-6 @enderror">
                                    <option value="production" @if ('production' == old('cc_account_environment', @$settings['cc_account_environment'])) selected @endif>
                                        Production</option>
                                    <option value="testing" @if ('testing' == old('cc_account_environment', @$settings['cc_account_environment'])) selected @endif>Testing
                                    </option>
                                </select>

                                @error('cc_account_environment')
                                    <span class="block text-theme-6 mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                    </div>


                    <div class="text-right mt-5">
                        <button id="GeneralSbumit" type="submit" class="btn btn-primary w-24">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
