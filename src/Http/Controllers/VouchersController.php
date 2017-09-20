<?php

namespace AccessManager\Prepaid\Http\Controllers;


use AccessManager\Base\Http\Controller\AdminBaseController;
use AccessManager\Prepaid\Http\Requests\GenerateVouchersRequest;
use AccessManager\Prepaid\Models\Voucher;
use AccessManager\Services\Plans\Models\ServicePlan;

class VouchersController extends AdminBaseController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUnused()
    {
        $vouchers = Voucher::orderby('generated_on', 'DESC')
            ->whereNull('used_on')
            ->paginate(10);
        return view("Prepaid::unused-vouchers", compact('vouchers'));
    }

    public function getUsed()
    {
        $vouchers = Voucher::orderby('used_on', 'DESC')
            ->whereNotNull('used_on')
            ->with('usedby.account')
            ->paginate(10);
        return view("Prepaid::used-vouchers", compact('vouchers'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getGenerate()
    {
        $plans = ServicePlan::pluck('name', 'id');
        return view("Prepaid::generate-vouchers", compact('plans'));
    }

    /**
     * @param GenerateVouchersRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postGenerate( GenerateVouchersRequest $request )
    {
        try {
//            dd($request->all());
            $plan = ServicePlan::findOrFail( $request->plan_id );
            Voucher::generateVouchers($plan, $request->validity, $request->validity_unit, $request->count);
            return redirect()->route('vouchers.index');
        }
        catch (\Exception $e)
        {
            dd($e->getMessage());
        }
    }
}