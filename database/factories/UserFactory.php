<?php

    namespace Database\Factories;

    use App\Models\User;
    use Illuminate\Database\Eloquent\Factories\Factory;
    use Illuminate\Support\Str;

    /**
     * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
     */
    class UserFactory extends Factory
    {
        protected $model = User::class;
        /**
         * Define the model's default state.
         *
         * @return array<string, mixed>
         */
        public function definition()
        {
            return [
                'email' => fake()->unique()->safeEmail(),
                'name' => fake()->name(),
                // possible default password
                'is_admin' => false,
            ];
        }

        /**
         * Indicate that the model's email address should be unverified.
         *
         * @return static
         */
        public function unverified()
        {
            return $this->state(fn(array $attributes) => [
                'email_verified_at' => null,
            ]);
        }
    }
