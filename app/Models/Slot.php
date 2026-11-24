<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable(['block_id', 'map_cell_id', 'number', 'is_active', 'notes'])]
class Slot extends Model
{
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'number' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    /**
     * @return BelongsTo<Block, $this>
     */
    public function block(): BelongsTo
    {
        return $this->belongsTo(Block::class);
    }

    /**
     * @return BelongsTo<MapCell, $this>
     */
    public function mapCell(): BelongsTo
    {
        return $this->belongsTo(MapCell::class);
    }

    /**
     * @return HasMany<ParkingTransaction, $this>
     */
    public function parkingTransactions(): HasMany
    {
        return $this->hasMany(ParkingTransaction::class);
    }

    /**
     * @return HasOne<ParkingTransaction, $this>
     */
    public function activeTransaction(): HasOne
    {
        return $this->hasOne(ParkingTransaction::class)->whereNull('exited_at')->latestOfMany();
    }

    public function isOccupied(): bool
    {
        return $this->activeTransaction()->exists();
    }

    public function transactions()
    {
        return $this->hasMany(ParkingTransaction::class);
    }
}
