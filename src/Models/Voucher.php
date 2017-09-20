<?php

namespace AccessManager\Prepaid\Models;


use AccessManager\Base\Models\AdminBaseModel;
use AccessManager\Services\Interfaces\ContainsSubscriptionServicesInterface;
use AccessManager\Services\Plans\Models\ServicePlan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use AccessManager\AccountDetails\AccountSubscription\Models\PrepaidSubscription;

/**
 * Class Voucher
 * @package AccessManager\Prepaid
 */
class Voucher extends AdminBaseModel implements ContainsSubscriptionServicesInterface
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * model properties defined in this dates array will automatically
     * be casted as Carbon instances.
     *
     * @var array
     */
    protected $dates = [
        'generated_on', 'expires_on', 'used_on',
    ];

    /**
     * Define name of fields in the table that can be mass assigned.
     *
     * @var array
     */
    protected $fillable = [
        'pin','method','generated_on','used_on','name', 'sim_sessions',
        'interim_updates','price','validity','validity_unit','expires_on', 'used_by',
    ];

    /**
     * Defines relationship with voucher limits.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function limits()
    {
        return $this->hasOne(VoucherLimit::class);
    }

    /**
     * Defines relationship with Voucher primary policy.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function primaryPolicy()
    {
        return $this->hasOne(VoucherPrimaryPolicy::class);
    }

    /**
     * Defines relationship with Voucher after quota policy.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function aqPolicy()
    {
        return $this->hasOne(VoucherAqPolicy::class);
    }

    /**
     * Defines relationship with account that used this vouher.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usedby()
    {
        return $this->belongsTo(PrepaidSubscription::class, 'used_by');
    }

    /**
     * Generates one or more prepaid vouchers for given service plan
     * wrapped in database transaction.
     *
     * @param ServicePlan $plan
     * @param $validity
     * @param $validity_unit
     * @param $count
     * @return array
     */
    public static function generateVouchers( ServicePlan $plan, $validity, $validity_unit, $count)
    {
        return DB::transaction(function() use( $plan, $validity, $validity_unit, $count){
            $pins = [];
            for($i=1; $i<=$count; $i++)
            {
                $voucher = static::generateSingle($plan, $validity, $validity_unit);
                $pins[] = $voucher->pin;
            }
            return $pins;
        });
    }

    /**
     * Generates one single voucher with provided service plan and voucher validity.
     *
     * @param ServicePlan $plan
     * @param int $validity
     * @param string $validity_unit
     * @return static
     */
    public static function generateSingle( ServicePlan $plan, $validity = 1, $validity_unit = 'Day' )
    {
        $voucher = new static([
            'pin'               =>  self::generateNewPin(),
            'generated_on'      =>  new Carbon,
            'name'              =>  $plan->name,
            'sim_sessions'      =>  $plan->sim_sessions,
            'interim_updates'   =>  $plan->interim_updates,
            'price'             =>  $plan->price,
            'validity'          =>  $plan->validity,
            'validity_unit'     =>  $plan->validity_unit,
        ]);
        $voucher->expires_on    =   (new Carbon)->modify("+$validity $validity_unit");
        $voucher->save();
        if( $plan->primaryPolicy != null ):
            $voucher->primaryPolicy()->create( $plan->primaryPolicy->toArray() );
        endif;
        if( $plan->limits != null ):
            $voucher->limits()->create( $plan->limits->toArray() );

            if( $plan->aqPolicy != null ):
                $voucher->aqPolicy()->create( $plan->aqPolicy->toArray() );
            endif;
        endif;

        return $voucher;
    }

    /**
     *  Generate a new unique PIN to create new prepaid voucher.
     *
     * @return int
     */
    public static function generateNewPin()
    {
        do {
            $newPin = mt_rand(100000, 999999999999);
        } while(
            static::where('pin', $newPin)->exists()
        );
        return $newPin;
    }
}