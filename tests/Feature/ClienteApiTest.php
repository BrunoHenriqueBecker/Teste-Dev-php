<?php

namespace Tests\Feature;

use App\Models\Cliente;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClienteApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_cliente()
    {
        $clienteData = [
            'nome_completo' => 'João Silva',
            'cpf'           => '12345678909',
            'email'         => 'joao.silva@example.com',
            'telefone'      => '11987654321',
            'cep'           => '01001000',
        ];

        $response = $this->postJson('/api/clientes', $clienteData);

        $response->assertStatus(201)
                 ->assertJson([
                     'nome_completo' => 'João Silva',
                     'cpf' => '12345678909',
                     'email' => 'joao.silva@example.com',
                 ]);
    }

    public function test_update_cliente()
    {
        $cliente = Cliente::factory()->create();

        $updatedData = [
            'nome_completo' => 'João Silva Atualizado',
            'cpf'           => '12345678909',
            'email'         => 'joao.silva.atualizado@example.com',
            'telefone'      => '11987654321',
            'cep'           => '01001000',
        ];

        $response = $this->putJson('/api/clientes/' . $cliente->id, $updatedData);

        $response->assertStatus(200)
                 ->assertJson([
                     'nome_completo' => 'João Silva Atualizado',
                     'email' => 'joao.silva.atualizado@example.com',
                 ]);
    }

    public function test_destroy_cliente()
    {
        $cliente = Cliente::factory()->create();

        $response = $this->deleteJson('/api/clientes/' . $cliente->id);

        $response->assertStatus(204);

        // Verifica se o cliente foi excluído do banco de dados
        $this->assertDatabaseMissing('clientes', [
            'id' => $cliente->id,
        ]);
    }


    public function test_index_clientes()
    {
        Cliente::factory()->count(5)->create();

        $response = $this->getJson('/api/clientes');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         '*' => [
                             'id',
                             'nome_completo',
                             'cpf',
                             'email',
                             'telefone',
                             'cep',
                             'created_at',
                             'updated_at',
                         ],
                     ],
                 ])
                 ->assertJsonCount(5, 'data');
    }

    public function test_store_cliente_com_dados_invalidos()
    {
        $response = $this->postJson('/api/clientes', [
            'email' => 'email-invalido'
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['nome_completo', 'email']);
    }


   public function test_update_cliente_com_dados_invalidos()
    {
        $cliente = Cliente::factory()->create();

        $response = $this->putJson("/api/clientes/{$cliente->id}", [
            'email' => 'email-invalido'
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['nome_completo', 'email']);
    }


    public function test_destroy_cliente_inexistente()
    {
        $response = $this->deleteJson('/api/clientes/999999'); 
        $response->assertStatus(404);
    }

   



}
