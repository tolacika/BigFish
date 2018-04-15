<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Discount
 *
 * @property int $id
 * @property string $sku
 * @property string $discount_type
 * @property string|null $discount_amount
 * @property string $target_type
 * @property string $target_reference
 * @property int $active
 * @property string $valid_from
 * @property string $valid_to
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Discount active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Discount whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Discount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Discount whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Discount whereDiscountAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Discount whereDiscountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Discount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Discount whereSku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Discount whereTargetReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Discount whereTargetType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Discount whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Discount whereValidFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Discount whereValidTo($value)
 * @mixin \Eloquent
 */
class Discount extends Model {
    /**
     * Scope a query to only include popular users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query) {
        return $query->where('active', 1)->where('valid_from', '<=', date('Y-m-d H:i:s'))->where('valid_to', '>=', date('Y-m-d H:i:s'));
    }

    public function getNewPrice($price) {
        if ($this->discount_type == 'percent') {
            $percent = floatval($this->discount_amount);
            $percent = 1.0 - ($percent / 100.0);

            return intval($price * $percent);
        }
        if ($this->discount_type == 'fix') {
            if ($this->discount_amount >= $price) {
                return 0;
            }

            return $price - $this->discount_amount;
        }

        return $price;
    }

    public function getText() {
        switch ($this->discount_type) {
            case "fix":
                return $this->discount_amount . " Ft kedvezmény a termék árából";
            case "percent":
                return $this->discount_amount . "% kedvezmény a termék árából";
            case "2+1":
                return "2+1 Akció";
        }

        return "";
    }
}
