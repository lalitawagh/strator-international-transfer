@extends('international-transfer::conversion.process.skeleton-wizard')

@section('money-transfer-content')
    <div class="px-5 mt-3 sm:px-10 sm:mt-10 sm:pt-10 border-t border-gray-200">

        <div class="intro-y col-span-12 lg:col-span-12">
            <div class="rounded-lg w-12/12 md:w-9/12 lg:w-9/12 m-auto p-0 gap-5">
                <h3 class="text-lg font-medium mb-4 sm:mb-2 text-left py-2">Preview</h3>
                <form id="money-transfer-store-form" method="POST"
                    action="">
                    @csrf
                    <div class="intro-y mt-0 p-3">
                        <div class="grid grid-cols-12 rounded-lg m-auto p-0 ">
                            <div class="col-span-12 md:col-span-8 mony-transfer m-auto">
                                <div class="px-5 pb-8 text-center">
                                    <div class="sm:w-52 sm:w-auto mx-auto mt-0">
                                        <div class="flex items-start text-left mt-4">
                                            <span class="font-medium w-2/4 truncate">Selling</span>
                                            <span class="font-medium w-2/3 text-sm break-all"></span>
                                        </div>
                                        <div class="flex items-start text-left mt-4">
                                            <span class="font-medium w-2/4 truncate">Buying</span>
                                            <span class="font-medium w-2/3 text-sm break-all"></span>
                                        </div>
                                        <div class="flex items-start text-left mt-4">
                                            <span class="font-medium w-2/4 truncate">Exchange Rate</span>
                                            <span class="font-medium w-2/3 text-sm break-all"></span>
                                        </div>
                                        <div class="flex items-start text-left mt-4">
                                            <span class="font-medium w-2/4 truncate">Conversion Date</span>
                                            <span class="font-medium w-2/3 text-sm break-all"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right mt-5 py-4">
                                    <a id="BenificaryPrevious" href="{{ route('dashboard.international-transfer.conversion.create', ['filter' => ['workspace_id' => app('activeWorkspaceId')]]) }}"
                                    class="btn btn-secondary w-24">Previous</a>
                                    <button id="continue-btn" class="btn btn-primary w-24 ml-2 ">Continue</button>
                                </div>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
@endsection

