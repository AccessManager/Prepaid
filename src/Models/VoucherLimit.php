<?php

namespace AccessManager\Prepaid\Models;


use AccessManager\Base\Models\AdminBaseModel;

/**
 * Class VoucherLimit
 * @package AccessManager\Prepaid
 */
class VoucherLimit extends AdminBaseModel
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        'voucher_id', 'time_limit', 'time_unit', 'data_limit', 'data_unit', 'reset_every', 'reset_every_unit',
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