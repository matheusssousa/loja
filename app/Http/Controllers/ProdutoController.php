<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Http\Requests\StoreProdutoRequest;
use App\Http\Requests\UpdateProdutoRequest;
use App\Repositories\Eloquent\ProdutoRepository;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    protected $produtoRepository;
    
    public function __construct(ProdutoRepository $produtoRepository)
    {
        $this->produtoRepository = $produtoRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $produtos = $this->produtoRepository->all($request);
        return view('produtos.index', compact('produtos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('produtos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProdutoRequest $request)
    {
        $produto = $this->produtoRepository->store($request->validated());
        return redirect()->route('produtos.index')->with('success', 'Produto criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Produto $produto)
    {
        $estoque = $this->produtoRepository->getEstoque($produto->id);
        return view('produtos.show', compact('produto', 'estoque'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produto $produto)
    {
        return view('produtos.edit', compact('produto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProdutoRequest $request, Produto $produto)
    {
        $this->produtoRepository->update($produto->id, $request->validated());
        return redirect()->route('produtos.index')->with('success', 'Produto atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produto $produto)
    {
        $carrinho = session()->get('carrinho', []);
        if (isset($carrinho[$produto->id])) {
            unset($carrinho[$produto->id]);
            session()->put('carrinho', $carrinho);
        }

        $this->produtoRepository->delete($produto->id);
        return redirect()->route('produtos.index')->with('success', 'Produto excluído com sucesso!');
    }
}
