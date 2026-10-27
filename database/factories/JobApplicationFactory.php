<?php

namespace Database\Factories;

use App\Enums\ApplicationStatus;
use App\Enums\Experience;
use App\Enums\JobCategory;
use App\Models\JobApplication;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<JobApplication> */
class JobApplicationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'category' => JobCategory::Trades,
            'status' => ApplicationStatus::New,
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'phone' => '876-555-'.fake()->numerify('####'),
            'email' => fake()->safeEmail(),
            'experience' => Experience::TwoToFive,
            'consented_at' => now(),
        ];
    }
}
