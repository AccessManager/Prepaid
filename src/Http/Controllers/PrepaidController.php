<?php

namespace AccessManager\Prepaid\Http\Controllers;


use AccessManager\AccountDetails\AccountSubscription\Models\PrepaidSubscription;
use AccessManager\Base\Http\Controller\AdminBaseController;
use AccessManager\Prepaid\Http\Requests\RechargeAccountRequest;
use AccessManager\Prepaid\Libraries\SubscriptionRechargeHandler;
use AccessManager\Services\Plans\Models\ServicePlan;
use Spatie\Url\Url;

class PrepaidController extends AdminBaseController
{
    public function getRechargeAccount()
    {
        $plans = ServicePlan::pluck('name', 'id');
        $subscriptions = PrepaidSubscription::pluck('username', 'username');
        return view("Prepaid::recharge-account", compact('plans', 'subscriptions'));
    }

    public function postRechargeAccount( RechargeAccountRequest $request )
    {
        try {
            $subscription = PrepaidSubscription::where('username', $request->username)->firstOrFail();
            $plan = ServicePlan::findOrFail($request->plan_id);

            $handler = new SubscriptionRechargeHandler($subscription, $plan);
            $handler->process();

            $url = Url::fromString(url()->previous());
            if( $url->getQueryParameter('referrer') !== null )
            {
                return redirect()->to(urldecode($url->getQueryParameter('referrer')));
            } else {
                return redirect()->route('prepaid.recharge');
            }
        }
        catch (\Exception $e)
        {
            dd($e->getMessage());
        }
    }
}