<?php

namespace App\Models;

use App\Traits\PopulateTenantID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

/**
 * App\Models\Transaction
 *
 * @property int $id
 * @property string $transaction_id
 * @property int $amount
 * @property int $user_id
 * @property string $status
 * @property array|null $meta
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereStripeTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereUserId($value)
 *
 * @mixin \Eloquent
 */
class Transaction extends Model
{
    use BelongsToTenant, PopulateTenantID;

    protected $table = 'transactions';

    public $fillable = [
        'transaction_id',
        'payment_type',
        'amount',
        'user_id',
        'status',
        'meta',
        'is_manual_payment',
        'tenant_id',
        'notes',
    ];

    protected $hidden = ['created_at', 'updated_at'];
    const PATH = 'transactions';

    /**
     * @var array
     */
    protected $appends = ['attachment_url'];

    protected $casts = [
        'meta' => 'json',
        'status' => 'boolean',
        'notes' => 'string'
    ];

    const PAID = 'Paid';

    const UNPAID = 'Unpaid';

    const TYPE_STRIPE = 1;

    const TYPE_PAYPAL = 2;

    const TYPE_RAZORPAY = 3;

    const TYPE_CASH = 4;

    const TYPE_PAYTM = 5;

    const TYPE_PAYSTACK = 6;

    const ALL = 7;

    const APPROVED = 1;

    const DENIED = 2;

    const PAYMENT_TYPES = [
        self::TYPE_STRIPE => 'Stripe',
        self::TYPE_PAYPAL => 'PayPal',
        self::TYPE_RAZORPAY => 'RazorPay',
        self::TYPE_CASH => 'Manual',
        self::TYPE_PAYTM => 'Paytm',
        self::TYPE_PAYSTACK => 'Paystack',
    ];

    const PAYMENT_TYPES_FILTER = [
        self::ALL => 'All',
        self::TYPE_STRIPE => 'Stripe',
        self::TYPE_PAYPAL => 'PayPal',
        self::TYPE_RAZORPAY => 'RazorPay',
        self::TYPE_CASH => 'Manual',
        self::TYPE_PAYTM => 'Paytm',
        self::TYPE_PAYSTACK => 'Paystack',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class, 'transaction_id');
    }

    public function transactionSubscription(): HasOne
    {
        return $this->hasOne(Subscription::class, 'transaction_id', 'id');
    }

    /**
     * @return mixed
     */
    public function getAttachmentUrlAttribute()
    {
        /** @var Media $media */
        $media = $this->media->first();
        if (! empty($media)) {
            return $media->getFullUrl();
        }

        return '';
    }
}
