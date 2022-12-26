<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BahanBaku>
 */
class BahanBakuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    // $table->string('jenis_bahanbaku', 255);
    //         $table->string('satuan_bahanbaku', 255);
    //         $table->string('stock_bahabaku', 255);
    //         $table->string('harga_bahanbaku', 255);
    public function definition()
    {
        return [
            //
            'jenis_bahanbaku' => fake()->name(),
            'satuan_bahanbaku' => fake()->unique()->word(),
            'stock_bahabaku' => fake()->randomNumber(2, false),
            'harga_bahanbaku' => fake()->randomNumber(5, true), // password
        ];
    }
}
