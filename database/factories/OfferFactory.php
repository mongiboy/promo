<?php

namespace Database\Factories;

use App\Enums\PartnerNetwork;
use App\Models\Category;
use App\Models\Offer;
use App\Models\Shop;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Offer>
 */
class OfferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $discount = fake()->numberBetween(5, 75);
        $discountAmount = fake()->numberBetween(1, 15) * 100;

        return [
            'shop_id' => Shop::inRandomOrder()->value('id'),
            'title' => fake()->randomElement([
                "Скидка {$discount}% на первый заказ",
                'Промокод на бесплатную доставку',
                "Скидка {$discount}% на всё",
                "Скидки до -{$discount}%",
                "Дополнительная скидка до {$discount}% на первый заказ"
            ]),
            'description' => fake()->boolean(80) ? fake()->realText(300) : null,
            'starts_at' => fake()->dateTimeBetween('-2 months', 'now'),
            'expires_at' => fake()->boolean(80)
                ? fake()->dateTimeBetween('+1 week', '+2 months') // активные, с запасом
                : fake()->dateTimeBetween('-1 months', '-1 day') ,  // просроченные
            'discount' => fake()->boolean(70) ? $discount . '%' : $discountAmount . '₽',
            'promocode' => fake()->boolean() ? strtoupper(fake()->bothify('????##')) : null,
            'url' => fake()->url,
            'is_moderated' => fake()->boolean(90),
            'is_active' => fake()->boolean(80),
            'partner_network' => fake()->randomElement(PartnerNetwork::cases()),
            'erid' => fake()->uuid,
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Offer $offer) {
            $categoryIds = Category::inRandomOrder()
                ->take(rand(1, 3))
                ->pluck('id');

            $offer->categories()->attach($categoryIds);
        });
    }
}
