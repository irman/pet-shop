<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\JwtToken
 *
 * @property int $id
 * @property int $user_id
 * @property string $unique_id
 * @property string $token_title
 * @property array|null $restrictions
 * @property array|null $permissions
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $expires_at
 * @property Carbon|null $last_used_at
 * @property Carbon|null $refreshed_at
 *
 * @property-read User $user
 *
 * @method static Builder|JwtToken newModelQuery()
 * @method static Builder|JwtToken newQuery()
 * @method static Builder|JwtToken query()
 * @method static Builder|JwtToken whereCreatedAt($value)
 * @method static Builder|JwtToken whereExpiresAt($value)
 * @method static Builder|JwtToken whereId($value)
 * @method static Builder|JwtToken whereLastUsedAt($value)
 * @method static Builder|JwtToken wherePermissions($value)
 * @method static Builder|JwtToken whereRefreshedAt($value)
 * @method static Builder|JwtToken whereRestrictions($value)
 * @method static Builder|JwtToken whereTokenTitle($value)
 * @method static Builder|JwtToken whereUniqueId($value)
 * @method static Builder|JwtToken whereUpdatedAt($value)
 * @method static Builder|JwtToken whereUserId($value)
 *
 * @mixin Eloquent
 */
class JwtToken extends Model
{
    use HasFactory;

    protected $casts = [
        'restrictions' => 'array',
        'permissions' => 'array',
        'expires_at' => 'datetime',
        'last_used_at' => 'datetime',
        'refreshed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
