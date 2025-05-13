<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Helpers\Validator;
use App\Repositories\ClienteRepositoryInterface;

class ClienteController extends Controller
{
    protected $clienteRepository;

    public function __construct(ClienteRepositoryInterface $clienteRepository)
    {
        $this->clienteRepository = $clienteRepository;
    }

    public function index(Request $request)
    {
        $clientes = $this->clienteRepository->paginateWithFilters($request->only(['nome_completo', 'cpf', 'cep']), 10);

        return response()->json([
            'data' => $clientes->items(),
            'total' => $clientes->total(),
            'per_page' => $clientes->perPage(),
            'current_page' => $clientes->currentPage(),
            'last_page' => $clientes->lastPage(),
            'from' => $clientes->firstItem(),
            'to' => $clientes->lastItem(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome_completo' => 'required|string|max:255',
            'cpf'           => 'required|string|max:14|unique:clientes,cpf',
            'email'         => 'required|email|unique:clientes,email',
            'telefone'      => 'required|string|max:20',
            'cep'           => 'required|string|size:8',
        ], [
            'nome_completo.required' => 'O nome completo é obrigatório.',
            'nome_completo.string'   => 'O nome completo deve ser um texto.',
            'nome_completo.max'      => 'O nome completo não pode ter mais de 255 caracteres.',

            'cpf.required' => 'O CPF é obrigatório.',
            'cpf.string'   => 'O CPF deve ser um texto.',
            'cpf.max'      => 'O CPF não pode ter mais de 14 caracteres.',
            'cpf.unique'   => 'Este CPF já está cadastrado.',

            'email.required' => 'O e-mail é obrigatório.',
            'email.email'    => 'O e-mail informado não é válido.',
            'email.unique'   => 'Este e-mail já está cadastrado.',

            'telefone.required' => 'O telefone é obrigatório.',
            'telefone.string'   => 'O telefone deve ser um texto.',
            'telefone.max'      => 'O telefone não pode ter mais de 20 caracteres.',

            'cep.required' => 'O CEP é obrigatório.',
            'cep.string'   => 'O CEP deve ser um texto.',
            'cep.size'     => 'O CEP deve conter exatamente 8 dígitos.',
        ]);

        
        if (!Validator::validarCpf($validated['cpf'])) {
            return response()->json(['error' => 'O CPF informado é inválido.'], 422);
        }

        $cepResponse = Http::get("https://brasilapi.com.br/api/cep/v1/{$validated['cep']}");
        if ($cepResponse->failed()) {
            return response()->json(['error' => 'CEP inválido ou não encontrado'], 422);
        }

        $cepData = $cepResponse->json();

        $dados = array_merge($validated, [
            'logradouro' => $cepData['street'] ?? '',
            'bairro'     => $cepData['neighborhood'] ?? '',
            'cidade'     => $cepData['city'] ?? '',
            'estado'     => $cepData['state'] ?? '',
        ]);

        $cliente = $this->clienteRepository->create($dados);

        return response()->json($cliente, 201);
    }

    public function show($id)
    {
        $cliente = $this->clienteRepository->find($id);
        if (!$cliente) {
            return response()->json(['error' => 'Cliente não encontrado'], 404);
        }
        return response()->json($cliente);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nome_completo' => 'required|string|max:255',
            'cpf'           => 'required|string|max:14|unique:clientes,cpf,' . $id,
            'email'         => 'required|email|unique:clientes,email,' . $id,
            'telefone'      => 'required|string|max:20',
            'cep'           => 'required|string|size:8',
        ]);

        $cepResponse = Http::get("https://brasilapi.com.br/api/cep/v1/{$validated['cep']}");
        if ($cepResponse->failed()) {
            return response()->json(['error' => 'CEP inválido ou não encontrado'], 422);
        }

        $cepData = $cepResponse->json();

        $dados = array_merge($validated, [
            'logradouro' => $cepData['street'] ?? '',
            'bairro'     => $cepData['neighborhood'] ?? '',
            'cidade'     => $cepData['city'] ?? '',
            'estado'     => $cepData['state'] ?? '',
        ]);

        $cliente = $this->clienteRepository->update($id, $dados);

        return response()->json($cliente);
    }

    public function destroy($id)
    {
        $deleted = $this->clienteRepository->delete($id);
        if (!$deleted) {
            return response()->json(['error' => 'Cliente não encontrado'], 404);
        }
        return response()->json(null, 204);
    }
}