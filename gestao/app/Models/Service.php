<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'client_id', 'title', 'description', 'internal_notes',
        'total_value', 'labor_cost', 'material_cost',
        'start_date', 'delivery_date', 'status',
    ];

    protected $casts = [
        'start_date'    => 'date',
        'delivery_date' => 'date',
        'total_value'   => 'decimal:2',
        'labor_cost'    => 'decimal:2',
        'material_cost' => 'decimal:2',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function totalPaid(): float
    {
        return (float) $this->payments()->sum('amount');
    }

    public function remainingBalance(): float
    {
        return (float) $this->total_value - $this->totalPaid();
    }

    public function totalCost(): float
    {
        return (float) $this->labor_cost + (float) $this->material_cost;
    }

    public function profit(): float
    {
        return (float) $this->total_value - $this->totalCost();
    }
}
