<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Product
 *
 * @property int $id
 * @property string $sku
 * @property string $slug
 * @property string $title
 * @property string $author
 * @property string $publisher
 * @property int $price
 * @property string $img_url
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereImgUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product wherePublisher($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereSku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product withoutTrashed()
 * @mixin \Eloquent
 */
class Product extends Model {
    use SoftDeletes;

    public function hasPriceDiscount() {
        if (Discount::active()->where('target_type', 'single')->where('target_reference', $this->sku)->whereIn('discount_type', ['percent', 'fix'])->count() > 0) {
            return true;
        }
        if (Discount::active()->where('target_type', 'publisher')->where('target_reference', $this->publisher)->whereIn('discount_type', ['percent', 'fix'])->count() > 0) {
            return true;
        }

        return false;
    }

    public function hasOtherDiscount() {
        if (Discount::active()->where('target_type', 'single')->where('target_reference', $this->sku)->whereNotIn('discount_type', ['percent', 'fix'])->count() > 0) {
            return true;
        }
        if (Discount::active()->where('target_type', 'publisher')->where('target_reference', $this->publisher)->whereNotIn('discount_type', ['percent', 'fix'])->count() > 0) {
            return true;
        }

        return false;
    }

    public function getOtherDiscount() {
        $disc = Discount::active()->where('target_type', 'single')->where('target_reference', $this->sku)->whereNotIn('discount_type', ['percent', 'fix'])->first();
        if ($disc) {
            return $disc->getText();
        }
        $disc = Discount::active()->where('target_type', 'publisher')->where('target_reference', $this->publisher)->whereNotIn('discount_type', ['percent', 'fix'])->first();
        if ($disc) {
            return $disc->getText();
        }

        return "";
    }

    public function formatPrice($price, $format = false) {
        if ($format) {
            return number_format($price, 0, '', ' ');
        }

        return $price;
    }

    public function getOldPrice($format = false) {
        return $this->formatPrice($this->price, $format);
    }

    public function getPrice($format = false) {
        return $this->formatPrice($this->price, $format);
    }

    /**
     * @param bool $format
     *
     * @return string
     */
    public function getDiscountPrice($format = false) {
        if (!$this->hasPriceDiscount()) {
            return $this->getOldPrice($format);
        }

        $singleTarget = Discount::active()->where('target_type', 'single')->where('target_reference', $this->sku)->whereIn('discount_type', ['percent', 'fix'])->first();
        if ($singleTarget) {
            return $this->formatPrice($singleTarget->getNewPrice($this->price), $format);
        }

        $publisherTarget = Discount::active()->where('target_type', 'publisher')->where('target_reference', $this->publisher)->whereIn('discount_type', ['percent', 'fix'])->first();
        if ($publisherTarget) {
            return $this->formatPrice($publisherTarget->getNewPrice($this->price), $format);
        }

        return $this->getOldPrice($format);
    }
}
