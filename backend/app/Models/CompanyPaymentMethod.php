<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompanyPaymentMethod extends Model
{
    use HasFactory;

    /**
     * Disable timestamps.
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'company_id',
        'payment_method',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'company_id' => 'integer',
        'payment_method' => 'string',
    ];

    /**
     * Get the company that owns the payment method.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
