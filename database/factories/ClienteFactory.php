<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ClienteFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nome_completo' => $this->faker->name(),
            'cpf' => $this->faker->numerify('###########'),
            'email' => $this->faker->unique()->safeEmail(),
            'telefone' => $this->faker->phoneNumber(),
            'cep' => $this->faker->postcode(),
            'logradouro' => $this->faker->streetAddress(),
            'bairro' => $this->faker->streetName(),
            'cidade' => $this->faker->city(),
            'estado' => $this->faker->stateAbbr(),
        ];
    }
}
