<?php

namespace App\Enums;

/**
 * Public stock status: the exact stock count is never exposed to customers.
 */
enum StockAvailability: string
{
    case InStock = 'in_stock';
    case LowStock = 'low_stock';
    case OutOfStock = 'out_of_stock';

    public const LOW_STOCK_THRESHOLD = 3;

    public static function fromStock(int $stock): self
    {
        return match (true) {
            $stock <= 0 => self::OutOfStock,
            $stock <= self::LOW_STOCK_THRESHOLD => self::LowStock,
            default => self::InStock,
        };
    }
}
