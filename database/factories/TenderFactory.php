<?php

namespace Database\Factories;

use App\Enums\ProcurementMethod;
use App\Enums\TenderStatus;
use App\Models\Tender;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Tender> */
class TenderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'status' => TenderStatus::New,
            'sector' => 'public',
            'entity_name' => 'Sample Parish Municipal Corporation',
            'contact_name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => '876-555-'.fake()->numerify('####'),
            'title' => 'Drainage improvement works, '.fake()->city(),
            'method' => ProcurementMethod::Open,
            'parish' => 'St. Catherine',
            'scope' => 'Construction of reinforced concrete drains and culverts.',
            'submission_due_at' => now()->addDays(10)->setTime(14, 0),
        ];
    }

    public function dueIn(int $days): static
    {
        return $this->state(fn () => ['submission_due_at' => now()->addDays($days)->setTime(14, 0)]);
    }
}
