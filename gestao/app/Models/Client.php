<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['name', 'phone', 'email', 'document', 'address', 'city', 'state', 'cep', 'notes'];

    public function services()
    {
        return $this->hasMany(Service::class);
    }
}
