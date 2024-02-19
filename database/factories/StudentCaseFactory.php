<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\StudentCase;
use Illuminate\Support\Facades\Validator;
use App\Models\Branch;
use App\Models\Intake;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StudentCase>
 */
class StudentCaseFactory extends Factory
{
    protected $model = StudentCase::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $randomBranch = Branch::inRandomOrder()->first();
        $randomIntake = Intake::inRandomOrder()->first();
        $randomCreatedBy = User::inRandomOrder()->value('id');
        $randomUpdatedBy = User::inRandomOrder()->value('id');
        $email = $this->faker->unique()->email;

        // Validate email uniqueness
        $validator = Validator::make(['email' => $email], [
            'email' => 'unique:leads,email',
        ]);

        if ($validator->fails()) {
            // If not unique, regenerate the email
            return $this->definition(); // Recursive call to regenerate email
        }

        // If no record with the email exists, proceed with generating other fields
        return [
            'branch_id' => $randomBranch->id,
            'intake_id' => $randomIntake->id,
            'name' => $this->faker->name,
            'email' => $email,
            'phone' => $this->faker->phoneNumber,
            'active' => 1,
            'status' => $this->faker->randomElement(['NEW', 'ADM APP', 'COL', 'UOL', 'BANK STATEMENT', 'INTERVIEW', 'CAS', 'VISA APP', 'VISA DECISION']),
            'description' => $this->faker->paragraph,
            'created_by' => $randomCreatedBy,
            'updated_by' => $randomUpdatedBy,
            'added_by' => '',
            'cnic' => $this->faker->uuid,
            'region_id' => 0,
            'offer_letter_condition' => $this->faker->text,
            'uol_date' => $this->faker->date,
            'status_date' => $this->faker->date,
            'date_of_deposit' => $this->faker->date,
            'maturity_date' => $this->faker->date,
            'applied_date' => $this->faker->date,
            'col_date' => $this->faker->date,
            'adventus_id' => $this->faker->randomNumber(),
            'group_agent' => $this->faker->word,
            'full_fee' => $this->faker->randomFloat(2, 0, 10000),
            'scholarship_discount' => $this->faker->randomFloat(2, 0, 1000),
            'after_scholarship' => $this->faker->randomFloat(2, 0, 10000),
            'case_status' => '',
            'consultancy_fee' => $this->faker->randomFloat(2, 0, 10000),
            'consultancy_fee_mark_date' => $this->faker->date,
            'university_fee_mark_date' => $this->faker->date,
        ];
    
    }
}
