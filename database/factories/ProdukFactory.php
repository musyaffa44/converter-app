<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produk>
 */
class ProdukFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition()
    {
        return [
            //
            'nama_produk' => fake()->unique()->word(),
            'jenis_produk' => fake()->unique()->word(),
            'size' => fake()->randomLetter(),
            'stock_produk' => fake()->randomNumber(2, false), // password
            'harga_produk' => fake()->randomNumber(5, true),
        ];
    }
}
