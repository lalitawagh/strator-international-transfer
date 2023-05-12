<div class="form-inline mb-2">
    <label for="register_as_agent" class="form-label sm:w-30"> Register As Agent </label>
    <div class="sm:w-3/5 form-check form-switch">
        <input id="register_as_agent" name="register_as_agent" type="checkbox" class="form-check-input">

        @error('register_as_agent')
            <span class="block text-theme-6 mt-2">{{ $message }}</span>
        @enderror
    </div>
</div>
<div class="form-inline mb-2">
    <label for="agent_name" class="form-label sm:w-30"> Agent Name </label>
    <div class="sm:w-3/5">
        <input id="agent_name" name="agent_name" value="{{ old('agent_name') }}" type="text"
        class="form-control  @error('agent_name') border-theme-6 @enderror">

        @error('agent_name')
            <span class="block text-theme-6 mt-2">{{ $message }}</span>
        @enderror
    </div>
</div>
<input type="hidden" name="agentName" value="{{  request()?->agent }}">


