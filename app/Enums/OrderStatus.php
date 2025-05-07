<?php

namespace App\Enums;

enum OrderStatus: string
{
    case Pending = 'pending';
    case Paid = 'paid';
    case Shipped = 'shipped';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match($this) {
            self::Pending => '未処理',
            self::Paid => '支払い済み',
            self::Shipped => '発送済み',
            self::Cancelled => 'キャンセル',
        };
    }
}

