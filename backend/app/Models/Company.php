<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'owner_id',
        'name',
        'cnpj',
        'email',
        'phone',
        'street',
        'number',
        'complement',
        'neighborhood',
        'city',
        'postal_code',
        'state',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'owner_id' => 'integer',
        'name'     => 'string',
        'cnpj'     => 'string',
        'email'    => 'string',
        'phone'    => 'string',
        'street'   => 'string',
        'number'   => 'string',
        'complement' => 'string',
        'neighborhood' => 'string',
        'city'     => 'string',
        'postal_code' => 'string',
        'state'    => 'string',
    ];
}
