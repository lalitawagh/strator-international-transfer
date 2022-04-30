<div>
    <div class="p-0" x-data="{ selectedDiv: 'personal' }">
        <form>
          <div class="grid grid-cols-12 md:gap-10 mt-0 mb-3">
            <div class="col-span-12 md:col-span-6 form-inline mt-2">
              <label class="form-label sm:w-30">Contact Type <span class="text-theme-6">*</span></label>
              <div class="sm:w-5/6 sm:pt-1">
                <div class="flex sm:flex-row mt-2">
                  <div class="form-check mr-6 mb-2">
                    <input id="type-personal" class="form-check-input contact-type" wire:model.defer="type" x-on:click="selectedDiv = 'personal'"  type="radio" name="type" value="personal" checked="">
                    <label class="form-check-label" for="type-personal">Personal</label>
                  </div>
                  <div class="form-check mr-2 mb-2 sm:mt-0">
                    <input id="type-company" class="form-check-input contact-type" wire:model.defer="type" x-on:click="selectedDiv = 'business'" type="radio" name="type" value="company">
                    <label class="form-check-label" for="type-company">Company</label>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="grid grid-cols-12 md:gap-10 mt-0">

            <div class="col-span-12 md:col-span-6 mt-2">

                <div class="col-span-12 md:col-span-6 mt-2" >
                    <div class="col-span-12 md:col-span-6 form-inline mt-2">
                        <label for="bank_country" class="form-label sm:w-30"> Country <span class="text-theme-6">*</span></label>
                        <div class="sm:w-5/6">
                        <select name="country" data-search="true" wire:model.defer="country" class="tail-select w-full " data-select-hidden="display" data-tail-select="tail-1">
                            @foreach ($countries as $country)
                                <option value="{{ $country->id }}" @if($country->id == $user->country_id) selected @endif>{{ $country->name }}</option>
                            @endforeach
                        </select>

                        </div>
                    </div>
                </div>
                <div class="col-span-12 md:col-span-6 form-inline mt-2" x-show="selectedDiv !== 'business'">
                    <label for="first_name" class="form-label sm:w-30">First Name <span class="text-theme-6">*</span></label>
                    <div class="sm:w-5/6">
                    <input id="first_name" wire:model.defer="first_name" name="first_name" type="text" class="form-control" value="{{ $user->first_name }}" required="required">
                    </div>
                </div>
                <div class="col-span-12 md:col-span-6 form-inline mt-2"  x-show="selectedDiv !== 'business'">
                    <label for="middle_name" class="form-label sm:w-30">Middle Name</label>
                    <div class="sm:w-5/6">
                    <input id="middle_name" wire:model.defer="middle_name" name="middle_name" type="text" class="form-control" value="{{ $user->middle_name }}">
                    </div>
                </div>
                <div class="col-span-12 md:col-span-6 form-inline mt-2 contact-personal visible"  x-show="selectedDiv !== 'business'">
                    <label for="last_name" class="form-label sm:w-30">Last Name <span class="text-theme-6">*</span></label>
                    <div class="sm:w-5/6">
                    <input id="last_name" wire:model.defer="last_name" name="last_name" type="text" class="form-control" value="{{ $user->last_name }}" required="required">
                    </div>
                </div>
                <div class="col-span-12 md:col-span-6 form-inline mt-2 contact-personal visible"  x-show="selectedDiv !== 'personal'">
                    <label for="company_name" class="form-label sm:w-30">Company Name <span class="text-theme-6">*</span></label>
                    <div class="sm:w-5/6">
                    <input id="company_name"  wire:model.defer="company_name" name="company_name" type="text" class="form-control"  required="required">
                    </div>
                </div>
                <div class="col-span-12 md:col-span-6 form-inline mt-2">
                    <label for="email" class="form-label sm:w-30">Email Address  </label>
                    <div class="sm:w-5/6">
                    <input id="email" wire:model.defer="email" name="email" type="email" class="form-control" value="{{ $user->email }}">
                    </div>
                </div>
                <div class="col-span-12 md:col-span-6 form-inline mt-2">
                    <label for="mobile" class="form-label sm:w-30">Mobile No. </label>
                    <div class="sm:w-5/6">
                        <input id="mobile" wire:model.defer="mobile" name="mobile" type="text" class="form-control" value="{{ $user->phone }}">
                    </div>
                </div>
                <div class="col-span-12 md:col-span-6 form-inline mt-2">
                    <label for="mobile" class="form-label sm:w-30">Phone </label>
                    <div class="sm:w-5/6">
                        <input id="phone" wire:model.defer="phone" name="phone" type="text" class="form-control" value="">
                    </div>
                </div>
            </div>


            <div class="col-span-12 md:col-span-6 mt-2">
                <div class="col-span-12 md:col-span-6 form-inline mt-2">
                    <label for="bank_account_name" class="form-label sm:w-30"> Account Name <span class="text-theme-6">*</span></label>
                    <div class="sm:w-5/6">
                      <input id="bank_account_name" wire:model.defer="bank_account_name" name="bank_account_name" type="text" class="form-control" value="{{ $account->name }}" required="">
                    </div>
                </div>
                <div class="col-span-12 md:col-span-6 form-inline mt-2">
                    <label for="iban_number" class="form-label sm:w-30">IBAN <span class="text-theme-6">*</span></label>
                    <div class="sm:w-5/6">
                        <input id="iban_number" wire:model.defer="iban_number" name="iban_number" type="text" class="form-control" value="{{ $account->iban_number }}" required="required">
                    </div>
                </div>
                <div class="col-span-12 md:col-span-6 form-inline mt-2 contact-personal visible">
                    <label for="account_number" class="form-label sm:w-30">Account No <span class="text-theme-6">*</span></label>
                    <div class="sm:w-5/6">
                      <input id="account_number" wire:model.defer="account_number" name="account_number" type="text" class="form-control" value="{{ $account->account_number }}" required="required">
                    </div>
                </div>
                <div class="col-span-12 md:col-span-6 form-inline mt-2 contact-company">
                    <label for="swift_code" class="form-label sm:w-30">SWIFT Code /IFSC Code </label>
                    <div class="sm:w-5/6">
                      <input id="swift_code" wire:model.defer="swift_code" name="swift_code" type="text" class="form-control" value="{{ $account->bank_code }}">
                    </div>
                </div>
                <div class="col-span-12 md:col-span-6 form-inline mt-2" style="align-items: initial;">
                    <label for="note" class="form-label sm:w-30">Notes  </label>
                    <div class="sm:w-5/6">
                      <textarea class="form-control" wire:model.defer="note" name="note"></textarea>
                    </div>
                </div>
                <div class="col-span-12 md:col-span-6 form-inline mt-2">
                    <label for="avatar" class="form-label sm:w-30">Avatar</label>
                    <div class="sm:w-5/6">
                      <input id="avatar" wire:model="avatar" name="avatar" type="file" class="form-control " value="">
                    </div>
                </div>
            </div>
          </div>



          <div class="text-right mt-5">
            <a href="" class="btn btn-secondary w-24 inline-block mr-1">Cancel</a>
            <button wire:click="createBeneficiary" type="button" class="btn btn-primary w-24">Create</button>
          </div>
        </form>
    </div>
</div>
