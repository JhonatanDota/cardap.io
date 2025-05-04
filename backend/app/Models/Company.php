<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'state'    => 'string',
    ];

    /** Get Payment Methods 
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function paymentMethods(): HasMany
    {
        return $this->hasMany(CompanyPaymentMethod::class);
    }

    /** Get Opening Hours
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function openingHours(): HasMany
    {
        return $this->hasMany(CompanyOpeningHour::class);
    }
}
