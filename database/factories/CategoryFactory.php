<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    protected $model = \App\Models\Category::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'name' =>$this->faker->word,
            'image'=>$this->faker->imageUrl(640,480,'category',true),
            'description' => $this->faker->sentence(),
            'created_at' => now(),
            'updated_at' => now(),
        
        ];
    }
}
