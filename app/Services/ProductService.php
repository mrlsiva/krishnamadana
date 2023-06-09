<?php

namespace App\Services;

use App\Models\AttributeSku;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductService
{

    public function createOrUpdateProduct($product, $variants, $skus)
    {
        try {
            DB::beginTransaction();

            // Update the attributes first
            if ($variants->isNotEmpty()) {
                $variants = $variants->map(function ($variant) use ($product) {
                    return array(
                        'product_id' => $product->id,
                        'name' => $variant['name'],
                    );
                });
                $product->attributes()->upsert(
                    $variants->toArray(),
                    ['product_id', 'name'],
                    ['name'],
                );
            }

            // Update the SKUs for the product
            if (!empty($skus)) {
                $updated_skus = [];
                $skus = $skus->map(function ($sku) use ($product, &$updated_skus) {
                    array_push(
                        $updated_skus,
                        array(
                            'product_id' => $product->id,
                            'sku' => $sku['sku'],
                            'amount' => $sku['amount'],
                            'stock' => $sku['stock'] ?? null,
                        ),
                    );
                    $sku['product_id'] = $product->id;
                    return $sku;
                });

                $product->skus()->upsert(
                    $updated_skus,
                    ['product_id', 'sku'],
                    ['amount', 'stock'],
                );
                $product_skus = $product->skus()->get();
                $attributes = $product->attributes()->get();

                // Once the SKUs are updated, insert the attribute_sku values
                foreach ($skus as $sku) {
                    $sku_value = $sku['sku'];
                    $sku_id = $product_skus->first(fn ($item) => $item->sku == $sku_value)->id;
                    foreach ($sku['variants'] as $index => $variant) {
                        $variant_name = $sku['variants'][$index]['name'];
                        $attribute_id = $attributes->first(fn ($item) => $item->name == $variant_name)->id;
                        AttributeSku::updateOrCreate(
                            ['attribute_id' => $attribute_id, 'sku_id' => $sku_id, 'value' => $variant['value']],
                            ['value' => $variant['value']]
                        );
                    }
                }
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            Log::debug($e);
            DB::rollBack();
            return false;
        }
    }
}
