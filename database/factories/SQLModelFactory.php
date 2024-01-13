<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\SQLModel;

class SQLModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    protected $model = SQLModel::class;

    public function definition()
    {
        return [
            'id' => $this->faker->unique()->numberBetween(1, 100),
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
            'name' => $this->faker->name(),
        ];
    }
}
