<?php

namespace AccessManager\Prepaid\Models;


use AccessManager\Base\Models\AdminBaseModel;

/**
 * Class VoucherPrimaryPolicy
 * @package AccessManager\Prepaid
 */
class VoucherPrimaryPolicy extends AdminBaseModel
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * Define name of fields in the table that can be mass assigned.
     *
     * @var array
     */
    protected $fillable = [
        'voucher_id', 'min_up', 'min_up_unit', 'min_down', 'min_down_unit',
        'max_up', 'max_up_unit', 'max_down', 'max_down_unit'
    ];

    /**
     * Define relationship with Voucher where it belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }
}