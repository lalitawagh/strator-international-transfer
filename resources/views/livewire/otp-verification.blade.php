<div>
    <div class="p-0">
        <div class="grid grid-cols-12 md:gap-10 mt-0">
            <div class="col-span-12 md:col-span-6 mt-2">
                <div class="col-span-12 md:col-span-6 form-inline mt-2">
                    <label for="mobile" class="form-label sm:w-30">Mobile <span class="text-theme-6">*</span></label>
                    <div class="sm:w-5/6">
                    <input id="mobile" wire:model.defer="mobile" name="mobile" type="text" class="form-control" value="{{ $user->phone }}" required="required">
                    </div>
                </div>
            </div>
            <div class="col-span-12 md:col-span-6 mt-2">
                <div class="col-span-12 md:col-span-6 form-inline mt-2">
                    <label for="otp" class="form-label sm:w-30">Otp <span class="text-theme-6">*</span></label>
                    <div class="sm:w-5/6">
                    <input id="otp" wire:model.defer="otp" name="otp" type="text" class="form-control" required="required">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
