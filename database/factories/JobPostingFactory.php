<?php

namespace Database\Factories;

use App\Enums\EmploymentType;
use App\Enums\JobCategory;
use App\Enums\JobStatus;
use App\Models\JobPosting;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/** @extends Factory<JobPosting> */
class JobPostingFactory extends Factory
{
    public function definition(): array
    {
        $title = 'Site foreman '.fake()->unique()->numberBetween(1, 9999);

        return [
            'slug' => Str::slug($title),
            'title' => $title,
            'category' => JobCategory::Supervisor,
            'employment_type' => EmploymentType::Project,
            'status' => JobStatus::Open,
            'location' => 'Kingston',
            'openings' => 1,
            'summary' => 'Run a civil works crew.',
            'duties' => "Supervise the crew\nDaily site diary",
            'requirements' => "5 years as a foreman",
        ];
    }
}
