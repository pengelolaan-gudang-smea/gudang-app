<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Barang>
 */
class BarangFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->name;
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'spek' => $this->faker->paragraph(2),
            'harga' => $this->faker->numerify,
            'stock' => $this->faker->numberBetween(1, 10),
            'satuan' => $this->faker->numberBetween(1,2),
            'user_id' => '2',
            'jurusan_id' =>'1',
        ];
    }
}
