<?php

namespace App\Repositories\Eloquent;

use App\Models\Produto;

class ProdutoRepository extends BaseRepository
{
    public function __construct(Produto $model)
    {
        parent::__construct($model);
    }

    public function getEstoque(int $produtoId)
    {
        return $this->model->find($produtoId)->estoque;
    }

    public function store(array $data)
    {
        $produto = $this->model->create($data);

        $produto->estoque()->create([
            'quantidade' => $data['estoque'],
        ]);

        return $produto;
    }

    public function update(int $id, array $data)
    {
        $produto = $this->model->find($id);
        $produto->update($data);

        if (isset($data['estoque'])) {
            $produto->estoque()->update(['quantidade' => $data['estoque']]);
        }

        return $produto;
    }
}
