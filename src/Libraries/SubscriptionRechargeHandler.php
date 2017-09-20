<?php

namespace AccessManager\Prepaid\Libraries;

use AccessManager\AccountDetails\AccountSubscription\Models\PrepaidSubscription;
use AccessManager\AccountDetails\Libraries\ServicePlanAssignmentAbstractService;
use AccessManager\Constants\Data;
use AccessManager\Constants\Time;
use AccessManager\Prepaid\Models\Voucher;
use AccessManager\Services\Plans\Models\ServicePlan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Class SubscriptionRechargeHandler
 * @package AccessManager\Prepaid
 */
class SubscriptionRechargeHandler extends ServicePlanAssignmentAbstractService
{
    /**
     * @var ServicePlan
     */
    protected $plan;

    /**
     * @var PrepaidSubscription
     */
    protected $subscription;

    /**
     * @var
     */
    protected $method;

    /**
     * @var Voucher
     */
    protected $voucher;


    public function process()
    {
        DB::transaction(function (){
            $this->voucher = $this->plan->generateVoucher();

            $this->setSubscription($this->subscription);
            $this->setServiceContainer($this->voucher);
            $this->assignServices();
            $this->updateRechargeTimestamp();
            $this->markVoucherAsUsed();
        });
    }

    protected function updateExpiry()
    {
        $this->subscription->expires_on = (new Carbon())->modify("+{$this->voucher->validity} {$this->voucher->validity_unit}");
        $this->subscription->saveOrFail();
    }

    /**
     * updates recharge time for the subscription.
     */
    protected function updateRechargeTimestamp()
    {
        $this->subscription->settings()->updateOrCreate([],
            ['recharged_on'  =>  date('Y-m-d H:i:s'),]);
    }

    /**
     * Mark the recently generated voucher as used.
     */
    protected function markVoucherAsUsed()
    {
        $this->voucher->method = $this->method;
        $this->voucher->used_on = new Carbon();
        $this->voucher->used_by = $this->subscription->id;
        $this->voucher->saveOrFail();
    }

    /**
     * SubscriptionRechargeHandler constructor.
     * @param PrepaidSubscription $subscription
     * @param ServicePlan $plan
     * @param string $method
     */
    public function __construct( PrepaidSubscription $subscription, ServicePlan $plan, $method = 'admin' )
    {
        $this->subscription = $subscription;
        $this->plan = $plan;
        $this->method = $method;
    }
}