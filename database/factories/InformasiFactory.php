<?php

namespace Database\Factories;

use App\Models\Informasi;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class InformasiFactory extends Factory
{
    protected $model = Informasi::class;

    public function definition(): array
    {
        $judul = $this->faker->sentence(rand(3, 7));
        return [
            'judul' => $judul,
            'slug' => Str::slug($judul),
            'isi' => $this->faker->paragraphs(rand(3, 7), true),
            'file' => $this->faker->imageUrl(),
        ];
    }
}