<?php

namespace App\Models;

use App\Traits\PopulateTenantID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class PurchaseMedicine extends Model
{
    use BelongsToTenant, PopulateTenantID;

    protected $fillable =
        [
            'purchase_no',
            'total',
            'discount',
            'tax',
            'net_amount',
            'payment_type',
            'payment_note',
            'note',
            'tenant_id',
        ];

    const CASH = 0;

    const CHEQUE = 1;

    const OTHER = 2;

    const PAYMENT_METHOD = [
        self::CASH => 'Cash',
        self::CHEQUE => 'Cheque',
        self::OTHER => 'Other',
    ];

    public function purchasedMedcines(): HasMany
    {
        return $this->hasMany(PurchasedMedicine::class, 'purchase_medicines_id');
    }
}
