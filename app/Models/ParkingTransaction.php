<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParkingTransaction extends Model
{
    protected $fillable = [
        'vehicle_id', 'slot_id', 'entry_user_id', 'exit_user_id', 'entered_at', 'exited_at',
    ];

    protected $casts = [
        'entered_at' => 'datetime',
        'exited_at'  => 'datetime',
    ];

    public function vehicle()   { return $this->belongsTo(Vehicle::class); }
    public function slot()      { return $this->belongsTo(Slot::class); }
    public function entryUser() { return $this->belongsTo(User::class, 'entry_user_id'); }
    public function exitUser()  { return $this->belongsTo(User::class, 'exit_user_id'); }

    // Transaksi yang masih parkir
    public function scopeActive($query)
    {
        return $query->whereNull('exited_at');
    }
}