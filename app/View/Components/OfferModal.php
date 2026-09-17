<?php

namespace App\View\Components;

use App\Models\Offer;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class OfferModal extends Component
{
    public ?Offer $offer;

    public function __construct()
    {
        $this->offer = $this->resolveOffer();
    }

    private function resolveOffer(): ?Offer
    {
        if (!$cid = request('cid')) {
            return null;
        }

        return Offer::published()->find($cid);
    }


    public function render(): View|Closure|string
    {
        return view('components.offer-modal');
    }
}
