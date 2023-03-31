@extends('international-transfer::configuration.skeleton')

@section('title', 'Risk Management Question')

@section('config-content')
    <div class="p-5">
        <form action="{{ route('dashboard.international-transfer.risk-management-questions.update', $risk_mgmnt_question['id']) }}"
            method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-12 md:gap-3 mt-0">
                <div class="col-span-12 lg:col-span-12 xl:col-span-6 form-inline mb-2">
                    <label for="questions" class="form-label sm:w-24">Question <span class="text-theme-6">*</span></label>
                    <div class="sm:w-5/6">
                            <textarea name="questions" id="questions" rows="3" class="form-control resize-none">{{ old('questions', $risk_mgmnt_question['questions']) }}</textarea>
                        @error('questions')
                            <span class="block text-theme-6 mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-span-12 lg:col-span-12 xl:col-span-6 form-inline mb-2 self-center">
                    <label for="status" class="form-label sm:w-24">Status <span class="text-theme-6">*</span></label>
                    <div class="sm:w-5/6 tillselect-marging">
                        <select name="status" id="status" data-search="true"
                            class="w-full @error('status') border-theme-6 @enderror" required>
                            @foreach ($statuses as $status)
                                <option value="{{ $status }}" @if ($risk_mgmnt_question['status'] == $status) selected @endif>
                                    {{ ucfirst($status) }} </option>
                            @endforeach
                        </select>

                        @error('status')
                            <span class="block text-theme-6 mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-12 md:gap-3 mt-0"
                @if (old('answer', $risk_mgmnt_question['answer']) == 'yes') x-data="{ selected: '1' }" @elseif (old('answer', $risk_mgmnt_question['answer']) == 'no') x-data="{ selected: '0' }" @else x-data="{ selected: '3' }" @endif>
                <div class="col-span-12 lg:col-span-12 xl:col-span-6 form-inline mt-2">
                    <label for="answer" class="form-label sm:w-24">Answer <span class="text-theme-6">*</span></label>
                    <div class="sm:w-5/6 sm:pt-3">
                        <div class="form-check mr-2 sm:pt-0">
                            <input id="radio-switch-1" class="form-check-input" type="radio"
                                x-on:click="selected = '1'" name="answer" value="yes"
                                @if (old('answer', $risk_mgmnt_question['answer']) == 'yes') checked @endif>
                            <label class="form-check-label" for="radio-switch-1">
                                <h4 href="javascript:;" class="font-medium truncate mr-5 ">
                                    <h4>Yes</h4>
                            </label>
                            <input id="radio-switch-2" class="form-check-input ml-3" type="radio"
                                x-on:click="selected = '0'" name="answer" value="no"
                                @if (old('answer', $risk_mgmnt_question['answer']) == 'no') checked @endif>
                            <label class="form-check-label" for="radio-switch-2">
                                <h4 href="javascript:;" class="font-medium truncate mr-5">
                                    <h4>No</h4>
                            </label>
                        </div>
                        @error('answer')
                            <span class="block text-theme-6 mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-12 lg:col-span-12 xl:col-span-6 form-inline mt-2" x-show="selected == '1'">
                    <label for="yes" class="form-label sm:w-24">Score Yes<span class="text-theme-6">*</span></label>
                    <div class="sm:w-5/6">
                        <input id="yes" name="yes" type="text"
                            class="form-control @error('yes') border-theme-6 @enderror yes"
                            value="{{ old('yes', $risk_mgmnt_question['yes']) }}">

                        @error('yes')
                            <span class="block text-theme-6 mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-12 lg:col-span-12 xl:col-span-6 form-inline mt-2" x-show="selected == '0'">
                    <label for="no" class="form-label sm:w-24">Score No <span
                            class="text-theme-6">*</span></label>
                    <div class="sm:w-5/6">
                        <div class="input-group">
                            <input id="no" name="no" type="text"
                                class="form-control @error('no') border-theme-6 @enderror no"
                                value="{{ old('no', $risk_mgmnt_question['no']) }}">
                        </div>

                        @error('no')
                            <span class="block text-theme-6 mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="text-right mt-5">
                <a id="QuestionsCancel" href="{{ route('dashboard.international-transfer.risk-management-questions.index') }}"
                    class="btn btn-secondary w-24 inline-block mr-1">Cancel</a>
                <button id="QuestionsUpdate" type="submit" class="btn btn-primary w-24">Update</button>
            </div>
        </form>
    </div>
@endsection
