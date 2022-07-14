<?php

namespace Kanexy\InternationalTransfer\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Kanexy\PartnerFoundation\Banking\Models\Transaction;
use Kanexy\PartnerFoundation\Core\Models\Log;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class TransactionAttachmentComponent extends Component
{
    use WithFileUploads;

    public Transaction $transaction;

    public $description;

    public $attachment = [];

    public $mediaItems;

    public $logSent;

    public $logs = [];

    protected $listeners = [
        'showTransactionAttachment',
        'refreshComponent' => '$refresh',
        'clearInput'
    ];

    protected function rules()
    {
        return  [
            'attachment.*' => ['required','max:5120','mimes:png,jpg,jpeg','file']
        ];

    }

    protected $validationAttributes = [
        'attachment.*' => 'attachments',
    ];

    protected function messages()
    {
        return  [
            'attachment.*.max' => 'The attachments may not be greater than 5 MB.',
        ];
    }

    public function showTransactionAttachment(Transaction $transaction)
    {
        $this->transaction = $transaction;
        $this->mediaItems =  $transaction->getMedia('Images');
        $this->dispatchBrowserEvent('loadDropzone');
    }

    public function render()
    {
        $this->dispatchBrowserEvent('loadDropzone');
        return view('international-transfer::livewire.transaction-attachment-component');
    }

    public function transactionAttachmentSubmit($transaction)
    {
        $data = $this->validate();
        if(! is_null($this->attachment))
        {
            $transaction = Transaction::find($transaction);

            collect($this->attachment)->each(fn($image) =>
                $transaction->addMedia($image->getRealPath())->toMediaCollection('Images', 'azure')
            );

            $this->mediaItems =  $transaction?->getMedia('Images');

            $this->logSent = true;
        }
       
        $this->emit('clearInput');
    }

    public function clearInput()
    {
        $this->logSent = false;
        $this->description = null;
        $this->attachment = null;
    }
}
