<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Organization>
 */
class OrganizationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $imagePath = '/organization_logos';

        return [
            'name' => $this->faker->company,
            'type' => $this->faker->randomElement([
                'Education',
                'Environnement',
                'Santé',
                'Protection des animaux',
                'Droits de l\'homme',
            ]),
            'location' => $this->faker->address,
            'phone_number' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'website' => $this->faker->url,
            'description' => $this->faker->paragraph,
            'founding_date' => $this->faker->date,
            'archived' => $this->faker->boolean(0),
            'logo' => $this->faker->image(public_path($imagePath), 200, 200, 'business', false)
        ];
    }
}
