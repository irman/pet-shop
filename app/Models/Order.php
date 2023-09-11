<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Order
 *
 * @property int $id
 * @property int $user_id
 * @property int $order_status_id
 * @property int $payment_id
 * @property string $uuid
 * @property mixed $products
 * @property mixed $address
 * @property float|null $delivery_fee
 * @property float $amount
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $shipped_at
 * @property-read User $user
 * @method static Builder|Order newModelQuery()
 * @method static Builder|Order newQuery()
 * @method static Builder|Order query()
 * @method static Builder|Order whereAddress($value)
 * @method static Builder|Order whereAmount($value)
 * @method static Builder|Order whereCreatedAt($value)
 * @method static Builder|Order whereDeliveryFee($value)
 * @method static Builder|Order whereId($value)
 * @method static Builder|Order whereOrderStatusId($value)
 * @method static Builder|Order wherePaymentId($value)
 * @method static Builder|Order whereProducts($value)
 * @method static Builder|Order whereShippedAt($value)
 * @method static Builder|Order whereUpdatedAt($value)
 * @method static Builder|Order whereUserId($value)
 * @method static Builder|Order whereUuid($value)
 * @mixin Eloquent
 */
class Order extends Model
{
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
