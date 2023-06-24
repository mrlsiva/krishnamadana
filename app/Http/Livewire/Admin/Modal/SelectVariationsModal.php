<?php

namespace App\Http\Livewire\Admin\Modal;

use App\Models\Variation;
use Illuminate\Support\Facades\Log;
use LivewireUI\Modal\ModalComponent;

class SelectVariationsModal extends ModalComponent
{
    public $variations;
    public $selected;
    public $total_possibilities;
    public $base_price;

    protected $rules = [
        'base_price' => 'required',
    ];

    public function mount()
    {
        $this->selected = array();
        $this->variations = Variation::with('options')->get()->toArray();
        foreach ($this->variations as $index => $variation) {
            $this->variations[$index]['selected'] = false;
            foreach ($variation['options'] as $i => $option) {
                $this->variations[$index]['options'][$i]['selected'] = false;
            }
        }
    }

    public function render()
    {
        return view('livewire.admin.modal.select-variations-modal');
    }

    public function submit()
    {
        $this->validate();
        $selected = collect([]);
        foreach ($this->variations as $variation) {
            foreach ($variation['options'] as $option) {
                if ($option['selected'] == true) {
                    $selected->push(collect([
                        'option_id' => $option['id'],
                        'variation_id' => $option['variation_id'],
                        'value' => $option['value'],
                    ]));
                }
            }
        }
        $selected = $selected->groupBy(fn ($item, $key) => $item['variation_id']);
        $filtered = $selected->values()->map(fn ($item, $key) => $item->map(fn ($item) => $item['option_id']));
        $filtered_title = $selected->values()->map(fn ($item, $key) => $item->map(fn ($item) => $item['value']));
        // $remaining = $selected->skip(1)->flatten()->map(fn ($item, $key) => $item);
        // $remaining = $selected->filter(fn ($item, $key) => $key !== $first)
        // Log::debug($first->skip(1)->values()->toArray());
        $combinations = $filtered->first()->crossJoin(...$filtered->skip(1)->values())
            ->map(fn ($item) => array_map(fn ($item) => ['variation_option_id' => $item], $item));
        $combinations_title = $filtered_title->first()->crossJoin(...$filtered_title->skip(1)->values())
            ->map(fn ($item) => join(" / ", $item));
        $data = [
            'base_price' => $this->base_price,
            'combinations' => $combinations,
        ];
        Log::debug($combinations_title);
        // $this->emit('create_possible_variations', $data);
        // $this->closeModal();
    }

    public function calculate_variations($i, $index)
    {
        $selected = $this->variations[$i]['options'][$index]['selected'];
        if (!$selected) {
            $this->variations[$i]['selected'] = false;
        }

        $possibilities = 1;
        foreach ($this->variations as $variation) {
            $filtered = array_filter($variation['options'], function ($item) {
                return isset($item['selected']) && $item['selected'] == true;
            });
            $possibilities = (sizeof($filtered) > 0 ? sizeof($filtered) : 1) * $possibilities;
        }
        $this->total_possibilities = $possibilities;
    }

    public function onVariantChange($index)
    {
        $selected = $this->variations[$index]['selected'];
        foreach ($this->variations[$index]['options'] as $i => $option) {
            $this->variations[$index]['options'][$i]['selected'] = $selected;
        }
        $this->calculate_variations($index, 0);
    }
}
