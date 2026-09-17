<?php

namespace App\Livewire;

use App\Models\Shop;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;

class Search extends Component
{
    public string $query;
    public $shops;

    public function updatedQuery(): void
    {
        if (mb_strlen($this->query) < 1) {
            $this->shops = [];
            return;
        }

        $this->shops = Shop::query()
            ->visible()
            ->where('name', 'like', "%{$this->query}%")
            ->limit(5)
            ->get();
    }

    public function render(): View
    {
        return view('livewire.search');
    }
}
