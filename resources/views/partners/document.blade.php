@extends('international-transfer::layouts.master')

@section('title', 'Membership proof of documentation')

@section('content')
    <div id="ProofDocumentation"
        class="tab-pane grid grid-cols-12 gap-3 {{ request()->routeIs('dashboard.membership-proof-information', [request()->route('membershipId'), request()->route('workspaceId')]) ? 'active' : '' }}"
        role="tabpanel" aria-labelledby="ProofDocumentation-tab">
        @if (!is_null($documents))
            @foreach ($documents as $document)
                <div class="intro-y col-span-12 lg:col-span-12">
                    <div class="intro-y box mt-0">
                        <div class="flex flex-col sm:flex-row items-center p-3 border-b border-gray-200 dark:border-dark-5">
                            <h2 class="font-medium text-base mr-auto">

                                @if ($document->type == 'id_proof1')
                                    Identity Proof Front
                                @elseif ($document->type == 'id_proof2')
                                    Identity Proof Back
                                @elseif ($document->type == 'address_proof')
                                    Address Proof
                                @elseif ($document->type == 'verification_image')
                                    Biometrics - Selfie
                                @elseif ($document->type == 'verification_video')
                                    Biometrics - Video
                                @elseif ($document->type == 'business_document_one')
                                    KYB Document 1
                                @elseif ($document->type == 'business_document_two')
                                    KYB Document 
                                @elseif ($document->type == 'course_document')
                                    Course Document 
                                @endif


                            </h2>
                        </div>
                        @php
                           
                            $documentType = \Kanexy\PartnerFoundation\Core\Models\DocumentType::find($document->document_type_id);
                        @endphp
                        <div class="preview p-5">
                            <div class="grid grid-cols-12 lg:gap-10">
                                <div class="col-span-12 md:col-span-12 lg:col-span-6 form-inline mt-2">
                                    <label for="identity_proof_type" class="form-label sm:w-30">Document Type</label>
                                    <div class="sm:w-5/6">
                                        @if ($document->type == 'id_proof1' || $document->type == 'id_proof2' || $document->type == 'id_proof')
                                            <input type="text" class="form-control"
                                                value="@isset($yotiLog) {{ trans('partner-foundation::yoti.' . $yotiLog->value['id_proof']) }} @else {{ $documentType->name }} @endisset">
                                        @elseif($document->type == 'address_proof')
                                            <input type="text" class="form-control"
                                                value="@isset($yotiLog) {{ trans('partner-foundation::yoti.' . $yotiLog->value['address_proof']) }} @else {{ $documentType->name }} @endisset">
                                        @elseif($document->type == 'business_document_one')
                                            <input type="text" class="form-control" value="{{ $documentType->name }}">
                                        @elseif($document->type == 'business_document_two')
                                            <input type="text" class="form-control" value="{{ $documentType->name }}">
                                        @elseif($document->type == 'course_document')
                                            <input type="text" class="form-control" value="{{ $documentType->name }}">
                                        @else
                                            <input type="text" class="form-control" value="Liveness Capture">
                                        @endif
                                    </div>
                                </div>

                                <div class="col-span-12 md:col-span-12 lg:col-span-6 form-inline mt-2">
                                    <label for="verified_date" class="form-label sm:w-30 ">Date & Time</label>
                                    <div class="sm:w-5/6">
                                        <input type="text" class="datepicker form-control  block mx-auto"
                                            data-single-mode="true" value="{{ $document->created_at }}" disabled>
                                    </div>
                                </div>
                            </div>

                            

                            <div class="grid grid-cols-12 md:gap-0 lg:gap-3 xl:gap-10 mt-0">
                                

                                <div class="col-span-12 md:col-span-12 lg:col-span-6 form-inline mt-2"
                                    style="align-items: flex-start;">
                                    <label for="identity_proof" class="form-label sm:w-30 pt-3">
                                        @if ($document->type == 'id_proof')
                                            Identity Proof
                                        @elseif ($document->type == 'address_proof')
                                            Address Proof
                                        @elseif ($document->type == 'verification_image')
                                            Biometrics - Selfie
                                        @elseif ($document->type == 'verification_video')
                                            Biometrics - Video
                                        @elseif ($document->type == 'business_document_one')
                                            KYB Document 1
                                        @elseif ($document->type == 'business_document_two')
                                            KYB Document 2
                                        @endif
                                    </label>
                                    @php
                                        $extension = substr($document->media, strpos($document->media, '.') + 1);
                                    @endphp
                                    <div class="sm:w-5/6">
                                        <div class="form-inline mt-2">
                                            <div class="w-full  mx-auto ml-0 xl:ml-0 pl-0">
                                                <div
                                                    class="border-2 border-dashed shadow-sm border-gray-200 dark:border-dark-5 rounded-md p-5">
                                                    <div
                                                        class="h-40 min-h-full relative image-fit cursor-pointer zoom-in mx-auto selfievideo">
                                                        @if ($document->documentType()->first()->type == 'verification_video')
                                                            <video id="video" class="h-40 min-h-full w-full m-auto"
                                                                controls id="address_proof_img">
                                                                <source
                                                                    src="{{ \Illuminate\Support\Facades\Storage::disk('azure')->temporaryUrl($document->media, now()->addMinutes(5)) }}"
                                                                    type="video/mp4">
                                                            </video>
                                                        @else
                                                            @if ($extension == 'application/octet-stream' || $extension == 'application/pdf')
                                                                <img class="rounded-md proof-default" alt=""
                                                                    src="{{ asset('img/pdf.png') }}">
                                                            @else
                                                                <img class="rounded-md proof-default" alt=""
                                                                    src="{{ \Illuminate\Support\Facades\Storage::disk('azure')->temporaryUrl($document->media, now()->addMinutes(5)) }}">
                                                            @endif
                                                        @endif
                                                        <div
                                                            class="tooltip w-5 h-5 flex items-center justify-center absolute rounded-full text-white bg-theme-6 right-0 top-0 -mr-2 -mt-2">
                                                            <i data-lucide="x" class="w-4 h-4 mr-0"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="relative justify-center items-center px-3 mt-5">
                                            <a id="Download"
                                                href="{{ \Illuminate\Support\Facades\Storage::disk('azure')->temporaryUrl($document->media, now()->addMinutes(5)) }}"
                                                target="_blank" class="btn btn-secondary w-32 mr-2 mb-2">
                                                <i data-lucide="download" class="w-4 h-4 mr-0"></i>
                                                Download
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endsection
