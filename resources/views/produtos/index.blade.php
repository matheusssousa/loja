@extends('layouts.app')

@section('content')
    <div class="card mb-5">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Lista de Produtos</h4>
            <a href="{{ route('produtos.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i>Novo Produto
            </a>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('produtos.index') }}" class="d-flex flex-column gap-2">
                <div>
                    <input type="text" name="nome" class="form-control me-2"
                        placeholder="Pesquisar produtos por nome..." value="{{ request('nome') }}">
                </div>
                <div class="d-flex gap-2 justify-content-end">
                    <button class="btn btn-secondary" type="submit">
                        <i class="bi bi-search"></i> Buscar
                    </button>
                    <a href="{{ route('produtos.index') }}" class="btn btn-danger">
                        <i class="bi bi-x-circle"></i> Limpar
                    </a>
                </div>
            </form>
        </div>
    </div>

    @if ($produtos->count() > 0)
        <div class="row">
            @foreach ($produtos as $produto)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $produto->nome }}</h5>
                            <p class="card-text text-muted mb-1">
                                <strong class="text-success fs-5">R$
                                    {{ number_format($produto->preco, 2, ',', '.') }}</strong>
                            </p>
                            <p class="card-text">
                                <small class="text-muted">
                                    <i class="bi bi-box-seam"></i>
                                    Estoque: {{ $produto->estoque->quantidade ?? 0 }} unidades
                                </small>
                            </p>
                            
                            @if($produto->variacoes && count($produto->variacoes) > 0)
                                <div class="mb-2">
                                    <small class="text-muted d-block mb-1">
                                        <i class="bi bi-palette"></i> Variações disponíveis:
                                    </small>
                                    <div class="d-flex flex-wrap gap-1">
                                        @foreach($produto->variacoes as $variacao)
                                            <span class="badge bg-secondary">{{ $variacao }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div class="mt-auto">
                                <div class="d-grid gap-2">
                                    <form action="{{ route('carrinho.adicionar', $produto->id) }}" method="POST">
                                        @csrf
                                        <div class="input-group mb-2">
                                            <span class="input-group-text">Qtd:</span>
                                            <input type="number" class="form-control" name="quantidade" value="1" min="1" 
                                                   max="{{ $produto->estoque->quantidade ?? 0 }}" 
                                                   {{ ($produto->estoque->quantidade ?? 0) < 1 ? 'disabled' : '' }}>
                                        </div>
                                        <button type="submit" class="btn btn-success w-100"
                                            {{ ($produto->estoque->quantidade ?? 0) < 1 ? 'disabled' : '' }}>
                                            <i class="bi bi-cart-plus me-1"></i>
                                            {{ ($produto->estoque->quantidade ?? 0) < 1 ? 'Sem Estoque' : 'Adicionar ao Carrinho' }}
                                        </button>
                                    </form>
                                </div>
                                <div class="d-flex gap-2 mt-2">
                                    <a href="{{ route('produtos.edit', $produto->id) }}" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil"></i> Editar
                                    </a>
                                    <form action="{{ route('produtos.destroy', $produto->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Tem certeza que deseja excluir este produto?')">
                                            <i class="bi bi-trash"></i> Excluir
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $produtos->appends(request()->query())->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <div class="mb-3">
                <i class="bi bi-search display-1 text-muted"></i>
            </div>
            <h4 class="text-muted">Nenhum produto encontrado</h4>
            @if (request('nome'))
                <p class="text-muted">Tente buscar com outros termos ou
                    <a href="{{ route('produtos.index') }}">veja todos os produtos</a>
                </p>
            @else
                <p class="text-muted">Comece criando seu primeiro produto!</p>
                <a href="{{ route('produtos.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i>Criar Produto
                </a>
            @endif
        </div>
    @endif
@endsection
