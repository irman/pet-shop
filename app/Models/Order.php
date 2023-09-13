<?php

namespace App\Models;

use Database\Factories\OrderFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Irman\Notify\Contracts\Notifiable;
use Irman\Notify\Events\ModelUpdated;

/**
 * App\Models\Order
 *
 * @property int $id
 * @property int $user_id
 * @property string $order_status_uuid
 * @property int|null $payment_id
 * @property string $uuid
 * @property array $products
 * @property array $address
 * @property float|null $delivery_fee
 * @property float $amount
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $shipped_at
 *
 * @property-read OrderStatus $order_status
 * @property-read User $user
 *
 * @method static OrderFactory factory($count = null, $state = [])
 * @method static Builder|Order newModelQuery()
 * @method static Builder|Order newQuery()
 * @method static Builder|Order query()
 * @method static Builder|Order whereAddress($value)
 * @method static Builder|Order whereAmount($value)
 * @method static Builder|Order whereCreatedAt($value)
 * @method static Builder|Order whereDeliveryFee($value)
 * @method static Builder|Order whereId($value)
 * @method static Builder|Order whereOrderStatusUuid($value)
 * @method static Builder|Order wherePaymentId($value)
 * @method static Builder|Order whereProducts($value)
 * @method static Builder|Order whereShippedAt($value)
 * @method static Builder|Order whereUpdatedAt($value)
 * @method static Builder|Order whereUserId($value)
 * @method static Builder|Order whereUuid($value)
 *
 * @mixin Eloquent
 */
class Order extends Model implements Notifiable
{
    use HasFactory;

    public const DEFAULT_STATUS_UUID = '2be6f04b-29f6-33af-90c2-18c3f39c9310';

    protected $casts = [
        'products' => 'json',
        'address' => 'json',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::saved(function (Order $order) {
            if($order->wasChanged('order_status_uuid')){
                event(new ModelUpdated($order));
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    #region Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function order_status(): BelongsTo
    {
        return $this->belongsTo(OrderStatus::class, 'order_status_uuid', 'uuid');
    }
    #endregion

    /**
     * @return string|array<string, mixed>
     */
    function getNotifiableContent(): string|array
    {
        $description = "Order status for " . $this->uuid . " has been updated";
        return [
            "@type" => "MessageCard",
            "@context" => "http://schema.org/extensions",
            "themeColor" => "0076D7",
            "summary" => $description,
            "sections" => [
                [
                    "activityTitle" => $description,
                    "activitySubtitle" => "PetShop",
                    "facts" => [
                        [
                            "name" => "New Status",
                            "value" => $this->order_status->title,
                        ],
                    ],
                    "markdown" => true
                ]
            ],
        ];
    }
}
