<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Anggaran>
 */
class AnggaranFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'anggaran' =>$this->faker->numerify,
            'jenis'=>'BOS',
        'tahun'=>$this->faker->year('now')
        ];
    }
}
