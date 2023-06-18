<?php

namespace App\Services;

use App\Models\AttributeSku;
use App\Models\Variation;
use App\Models\VariationOption;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductService
{

    public function createOrUpdateProduct($product, $variants, $variantOptions, $items, $category_id)
    {
        try {
            DB::beginTransaction();

            // Update the attributes first
            if ($variants->isNotEmpty()) {
                $variants = $variants->map(function ($variant) use ($category_id) {
                    return array(
                        'category_id' => $category_id,
                        'name' => $variant['name'],
                    );
                });
                Variation::upsert(
                    $variants->toArray(),
                    ['category_id', 'name'],
                    ['name'],
                );
            }

            if ($variantOptions->isNotEmpty()) {
                $options = $variantOptions->map(function ($option) use ($category_id) {
                    $variation_id = '';
                    if (!isset($option['variation_id']) || empty($option['variation_id'])) {
                        $variation_id =  Variation::firstWhere([
                            'name' => $option['name'],
                            'category_id' => $category_id
                        ])->id;
                    } else {
                        $variation_id = $option['variation_id'];
                    }
                    return array(
                        'variation_id' => $variation_id,
                        'value' => $option['value'],
                    );
                });
                VariationOption::upsert(
                    $options->toArray(),
                    ['variation_id', 'value'],
                    ['value'],
                );
            }

            // Update the SKUs for the product
            // if (!empty($skus)) {
            //     // $updated_skus = [];
            //     $skus = $skus->map(function ($sku) use ($product) {
            //         // array_push(
            //         //     $updated_skus,
            //         //     array(
            //         //         'product_id' => $product->id,
            //         //         'sku' => $sku['sku'],
            //         //         'amount' => $sku['amount'],
            //         //         'stock' => $sku['stock'] ?? null,
            //         //     ),
            //         // );
            //         $sku['product_id'] = $product->id;
            //         return $sku;
            //     });

            //     $product->skus()->upsert(
            //         $skus,
            //         ['product_id', 'sku'],
            //         ['amount', 'stock'],
            //     );
            //     // $product_skus = $product->skus()->get();
            //     // $attributes = $product->attributes()->get();

            //     // Once the SKUs are updated, insert the attribute_sku values
            //     // foreach ($skus as $sku) {
            //     //     $sku_value = $sku['sku'];
            //     //     $sku_id = $product_skus->first(fn ($item) => $item->sku == $sku_value)->id;
            //     //     foreach ($sku['variants'] as $index => $variant) {
            //     //         $variant_name = $sku['variants'][$index]['name'];
            //     //         $attribute_id = $attributes->first(fn ($item) => $item->name == $variant_name)->id;
            //     //         AttributeSku::updateOrCreate(
            //     //             ['attribute_id' => $attribute_id, 'sku_id' => $sku_id, 'value' => $variant['value']],
            //     //             ['value' => $variant['value']]
            //     //         );
            //     //     }
            //     // }

            // }

            // if (!empty($attributesSku)) {
            //     $product_skus = $product->skus()->get();
            //     $attributes = $product->attributes()->get();
            //     foreach ($attributesSku as $att) {
            //         $attribute_id = $att['attribute_id'];
            //         $sku_id = $att['sku_id'];
            //         if (empty($attribute_id)) {
            //             $attribute_id = $attributes->first(fn ($item) => $item->name == $att['name'])->id;
            //         }
            //         if (empty($sku_id)) {
            //             $attribute_id = $product_skus->first(fn ($item) => $item->sku == $att['sku'])->id;
            //         }
            //         AttributeSku::updateOrCreate(
            //             ['attribute_id' => $attribute_id, 'sku_id' => $sku_id, 'value' => $att['value']],
            //             ['value' => $att['value']]
            //         );
            //     }
            // }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            Log::debug($e);
            DB::rollBack();
            return false;
        }
    }
}
