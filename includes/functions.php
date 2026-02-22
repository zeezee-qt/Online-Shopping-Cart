<?php

declare(strict_types=1);

function generateProductId(string $productCode, int $nextNumber): string
{
    return sprintf('%02d%05d', (int) $productCode, $nextNumber);
}

function generateOrderNumber(int $deliveryType, string $productId, int $nextOrderNumber): string
{
    return sprintf('%01d%07s%08d', $deliveryType, $productId, $nextOrderNumber);
}

function money(float $amount): string
{
    return '₹' . number_format($amount, 2);
}

function deliveryTypeLabel(int $type): string
{
    return match ($type) {
        1 => 'Standard',
        2 => 'Express',
        3 => 'VPP/Cash on Delivery',
        default => 'Unknown',
    };
}
