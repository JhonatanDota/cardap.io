<?php

namespace App\Enums\Financial;

enum PaymentMethodsEnum: string
{
    case PIX = 'PIX';
    case CASH = 'CASH';
    case DEBIT_CARD = 'DEBIT_CARD';
    case CREDIT_CARD = 'CREDIT_CARD';

    /**
     * Get the values of the enum.
     *
     * @return array<string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
