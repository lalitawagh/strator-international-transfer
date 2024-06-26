<?php

namespace Kanexy\InternationalTransfer;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Kanexy\Cms\Facades\Cms;
use Kanexy\Cms\Menu\MenuItem;
use Kanexy\Cms\Traits\InteractsWithMigrations;
use Kanexy\InternationalTransfer\Contracts\FeeConfiguration;
use Kanexy\InternationalTransfer\Contracts\MasterAccountConfiguration;
use Kanexy\InternationalTransfer\Contracts\MoneyTransfer;
use Kanexy\InternationalTransfer\Contracts\TransferReasonConfiguration;
use Kanexy\InternationalTransfer\Contracts\RiskMgmtQueConfiguration;
use Kanexy\InternationalTransfer\Contracts\TransferTypeFeeConfiguration;
use Kanexy\InternationalTransfer\Contracts\ExchangeRateConfiguration;
use Kanexy\InternationalTransfer\Contracts\GeneralAmountSettingForm;
use Kanexy\InternationalTransfer\Http\Controllers\CcAccountSettingController;
use Kanexy\InternationalTransfer\Livewire\BalanceAddCurrencyComponent;
use Kanexy\InternationalTransfer\Livewire\ConversionInitialProcess;
use Kanexy\InternationalTransfer\Livewire\CurrencyCloudPayoutComponent;
use Kanexy\InternationalTransfer\Livewire\ExistingBeneficiary;
use Kanexy\InternationalTransfer\Livewire\InitialProcess;
use Kanexy\InternationalTransfer\Livewire\MyselfBeneficiary;
use Kanexy\InternationalTransfer\Livewire\OtpVerification;
use Kanexy\InternationalTransfer\Livewire\TransactionAttachmentComponent;
use Kanexy\InternationalTransfer\Livewire\TransactionDetailComponent;
use Kanexy\InternationalTransfer\Livewire\TransactionLogComponent;
use Kanexy\InternationalTransfer\Livewire\TransactionTrackComponent;
use Kanexy\InternationalTransfer\Livewire\TransactionKycdetailsComponent;
use Kanexy\InternationalTransfer\Livewire\InternationalTransferGraph;
use Kanexy\InternationalTransfer\Membership\MembershipComponent;
use Kanexy\InternationalTransfer\Membership\MembershipSubAccountComponent;
use Kanexy\InternationalTransfer\Menu\BeneficiariesMenu;
use Kanexy\InternationalTransfer\Menu\AgentMenu;
use Kanexy\InternationalTransfer\Menu\CurrencyCloudPartner;
use Kanexy\InternationalTransfer\Menu\AgentUser;
use Kanexy\InternationalTransfer\Menu\ConvertMenu;
use Kanexy\InternationalTransfer\Menu\CurrencyMenu;
use Kanexy\InternationalTransfer\Menu\InternationalTransferMenu;
use Kanexy\InternationalTransfer\Menu\MoneyTransferMenu;
use Kanexy\InternationalTransfer\Menu\TransactionMenu;
use Kanexy\InternationalTransfer\Policies\FeePolicy;
use Kanexy\InternationalTransfer\Policies\MasterAccountPolicy;
use Kanexy\InternationalTransfer\Policies\MoneyTransferPolicy;
use Kanexy\InternationalTransfer\Policies\TransferReasonPolicy;
use Kanexy\InternationalTransfer\Policies\RiskMgmtQuePolicy;
use Kanexy\InternationalTransfer\Policies\TransferTypeFeePolicy;
use Kanexy\InternationalTransfer\Policies\ExchangeRatePolicy;
use Kanexy\InternationalTransfer\Registration\CustomerRegistrationForm;
use Kanexy\InternationalTransfer\Setting\CcAccountSettingContent;
use Kanexy\InternationalTransfer\Setting\CcAccountSettingTab;
use Kanexy\InternationalTransfer\Transfer\BankingProcessSelectionTransferComponent;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class InternationalTransferServiceProvider extends PackageServiceProvider
{

    use InteractsWithMigrations;
    /**
     * The date and time for these migrations will be preserved when
     * published.
     *
     * @var array|string[]
     */

    protected array $migrationsWithPresetDateTime = [];

    private array $policies = [
        TransferTypeFeeConfiguration::class => TransferTypeFeePolicy::class,
        TransferReasonConfiguration::class => TransferReasonPolicy::class,
        MasterAccountConfiguration::class => MasterAccountPolicy::class,
        FeeConfiguration::class => FeePolicy::class,
        MoneyTransfer::class => MoneyTransferPolicy::class,
        RiskMgmtQueConfiguration::class => RiskMgmtQuePolicy::class,
        ExchangeRateConfiguration::class => ExchangeRatePolicy::class,
    ];

    public function registerDefaultPolicies()
    {
        foreach ($this->policies as $key => $value) {
            Gate::policy($key, $value);
        }
    }
    /**
     * A new date and time for these migrations will be appended in the
     * files when published.
     *
     * @var array|string[]
     */
    protected array $migrationsWithoutPresetDateTime = [];

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('international-transfer')
            ->hasViews()
            ->hasRoute('web')
            ->hasRoute('api')
            ->hasTranslations()
            ->hasMigrations($this->migrationsWithoutPresetDateTime);

        $this->publishMigrationsWithPresetDateTime($this->migrationsWithPresetDateTime);
    }

    public function packageRegistered()
    {
    }


    public function packageBooted()
    {
        parent::packageBooted();

        $this->registerDefaultPolicies();

        \Kanexy\Cms\Facades\SidebarMenu::addItem(new InternationalTransferMenu());
        \Kanexy\Cms\Facades\SidebarMenu::addItem(new MoneyTransferMenu());
        \Kanexy\Cms\Facades\SidebarMenu::addItem(new BeneficiariesMenu());
        \Kanexy\Cms\Facades\SidebarMenu::addItem(new TransactionMenu());

        if(config('services.registration_changed') == true)
        {
            \Kanexy\Cms\Facades\SidebarMenu::addItem(new CurrencyCloudPartner());
        }

        \Kanexy\Cms\Facades\SidebarMenu::addItem(new CurrencyMenu());
        \Kanexy\Cms\Facades\SidebarMenu::addItem(new ConvertMenu());

        \Kanexy\PartnerFoundation\Core\Facades\BankingProcessSelectionComponent::addItem(new BankingProcessSelectionTransferComponent());


        Livewire::component('initial-process', InitialProcess::class);
        Livewire::component('myself-beneficiary', MyselfBeneficiary::class);
        Livewire::component('otp-verification-component', OtpVerification::class);
        Livewire::component('existing-beneficiary', ExistingBeneficiary::class);
        Livewire::component('transaction-detail-component', TransactionDetailComponent::class);
        Livewire::component('transaction-log-component',TransactionLogComponent::class);
        Livewire::component('transaction-track-component',TransactionTrackComponent::class);
        Livewire::component('transaction-attachment-component',TransactionAttachmentComponent::class);
        Livewire::component('transaction-kycdetails-component',TransactionKycdetailsComponent::class);
        Livewire::component('transaction-log-component', TransactionLogComponent::class);
        Livewire::component('transaction-track-component', TransactionTrackComponent::class);
        Livewire::component('transaction-attachment-component', TransactionAttachmentComponent::class);
        Livewire::component('transaction-kycdetails-component', TransactionKycdetailsComponent::class);
        Livewire::component('international-transfer-graph', InternationalTransferGraph::class);
        Livewire::component('currency-cloud-payout-component', CurrencyCloudPayoutComponent::class);
        Livewire::component('conversion-initial-process', ConversionInitialProcess::class);
        Livewire::component('balance-add-currency-component', BalanceAddCurrencyComponent::class);

        \Kanexy\Cms\Facades\GeneralSetting::addItem(GeneralAmountSettingForm::class);
        \Kanexy\Cms\Facades\CustomerRegistration::addItem(CustomerRegistrationForm::class);
        \Kanexy\PartnerFoundation\Membership\Facades\MembershipBankingComponent::addItem(MembershipSubAccountComponent::class);
        \Kanexy\PartnerFoundation\Membership\Facades\MembershipComponent::addItem(MembershipComponent::class);
        \Kanexy\Cms\Facades\SettingContent::addItem(CcAccountSettingContent::class);
        \Kanexy\Cms\Facades\SettingTab::addItem(CcAccountSettingTab::class);

        Cms::setRedirectRouteAfterLogin(function (User $user) {
            if ($user->is_banking_user == 2 && config('services.disable_banking') == true) {
                return route('dashboard.international-transfer.money-transfer-dashboard');
            } else if ((!$user->isSubscriber()) && (config('services.disable_banking') == true)) {
                return route('dashboard.international-transfer.money-transfer-dashboard');
            }
        });


        Gate::define('agent-users', function (User $user, $id) {

            return $user->id ==  $id;
        });
    }
}
