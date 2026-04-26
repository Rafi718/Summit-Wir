<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\User;
use App\Models\OrderDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_PAID = 'paid';
    public const STATUS_ON_RENT = 'on_rent';
    public const STATUS_OVERDUE = 'overdue';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELLED = 'cancelled';
    public const STATUS_FAILED = 'failed';
    public const STATUS_EXPIRED = 'expired';

    protected $fillable = [
        'user_id',
        'loan_date',
        'return_date',
        'duration',
        'status',
        'total_price',
        'total_fine',
        'snap_token',
        'whatsapp_receipt_sent_at',
        'whatsapp_receipt_send_attempted_at',
    ];

    protected $casts = [
        'loan_date' => 'datetime',
        'return_date' => 'datetime',
        'duration' => 'integer',
        'whatsapp_receipt_sent_at' => 'datetime',
        'whatsapp_receipt_send_attempted_at' => 'datetime',
    ];

    protected $dates = ['loan_date', 'return_date'];

    protected $appends = ['displayStatus'];

    public static function canonicalizeStatus(?string $status): ?string
    {
        return match ($status) {
            'confirmed' => self::STATUS_PAID,
            'canceled' => self::STATUS_CANCELLED,
            default => $status,
        };
    }

    public function getDisplayStatusAttribute()
    {
        $status = self::canonicalizeStatus($this->status);

        if (in_array($status, [self::STATUS_COMPLETED, self::STATUS_CANCELLED, self::STATUS_FAILED, self::STATUS_EXPIRED])) {
            return $status;
        }

        if ($status !== self::STATUS_ON_RENT || !$this->loan_date) {
            return $status;
        }

        $dueDate = Carbon::parse($this->loan_date)->addDays((int) $this->duration);

        if (now()->greaterThan($dueDate)) {
            return self::STATUS_OVERDUE;
        }

        return $status;
    }

    public function hasReservedStock(): bool
    {
        return in_array(self::canonicalizeStatus($this->status), [
            self::STATUS_PAID,
            self::STATUS_ON_RENT,
            self::STATUS_OVERDUE,
        ], true);
    }

    public function reserveStock(): void
    {
        $this->loadMissing('orderDetails.product');

        foreach ($this->orderDetails as $detail) {
            if (!$detail->product) {
                continue;
            }

            $detail->product->decrement('stock', $detail->quantity);
            $detail->product->increment('sold', $detail->quantity);
        }
    }

    public function releaseStock(): void
    {
        $this->loadMissing('orderDetails.product');

        foreach ($this->orderDetails as $detail) {
            if (!$detail->product) {
                continue;
            }

            $detail->product->increment('stock', $detail->quantity);
        }
    }

    public function startRental(?Carbon $startedAt = null): void
    {
        $loanDate = $this->loan_date ?: ($startedAt ?? now());

        $this->forceFill([
            'status' => self::STATUS_ON_RENT,
            'loan_date' => $loanDate,
            'return_date' => Carbon::parse($loanDate)->addDays((int) $this->duration),
        ])->save();
    }

    public function completeRental(): void
    {
        $this->forceFill([
            'status' => self::STATUS_COMPLETED,
        ])->save();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function orderDetails(): HasMany
    {
        return $this->hasMany(OrderDetail::class);
    }
}
