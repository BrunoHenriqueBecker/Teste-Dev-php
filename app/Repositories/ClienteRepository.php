<?php

namespace App\Repositories;

use App\Models\Cliente;

class ClienteRepository implements ClienteRepositoryInterface
{
    public function paginateWithFilters(array $filters, int $perPage = 10)
    {
        $query = Cliente::query();

        if (!empty($filters['nome_completo'])) {
            $query->where('nome_completo', 'like', '%' . $filters['nome_completo'] . '%');
        }

        if (!empty($filters['cpf'])) {
            $query->where('cpf', 'like', '%' . $filters['cpf'] . '%');
        }

        if (!empty($filters['cep'])) {
            $query->where('cep', 'like', '%' . $filters['cep'] . '%');
        }

        return $query->paginate($perPage);
    }

    public function find($id)
    {
        return Cliente::find($id);
    }

    public function create(array $data)
    {
        return Cliente::create($data);
    }

    public function update($id, array $data)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->update($data);
        return $cliente;
    }

    public function delete($id)
    {
        $cliente = Cliente::find($id);
        if ($cliente) {
            return $cliente->delete();
        }
        return false;
    }
}
