@extends('layouts.app')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <h5><i class="bi bi-exclamation-triangle-fill me-1"></i>Erro de validação</h5>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('produtos.store') }}" method="POST" class="card">
        @csrf
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4><i class="bi bi-plus-circle me-2"></i>Novo Produto</h4>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome do Produto <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nome') is-invalid @enderror" 
                       id="nome" name="nome" value="{{ old('nome') }}" required>
                @error('nome')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="preco" class="form-label">Preço (R$) <span class="text-danger">*</span></label>
                <input type="number" step="0.01" class="form-control @error('preco') is-invalid @enderror" 
                       id="preco" name="preco" value="{{ old('preco') }}" required>
                @error('preco')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="estoque" class="form-label">Quantidade em Estoque <span class="text-danger">*</span></label>
                <input type="number" class="form-control @error('estoque') is-invalid @enderror" 
                       id="estoque" name="estoque" value="{{ old('estoque') }}" required>
                @error('estoque')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">Informe a quantidade disponível do produto</div>
            </div>

            <div class="mb-3">
                <label for="variacoes" class="form-label">Variações <span class="text-muted">(Opcional)</span></label>
                <textarea class="form-control @error('variacoes') is-invalid @enderror" 
                          id="variacoes" name="variacoes" rows="3" placeholder="Ex: Cor: Azul, Vermelho, Verde&#10;Tamanho: P, M, G">{{ old('variacoes') }}</textarea>
                @error('variacoes')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">Digite as variações disponíveis (uma por linha)</div>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-end gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-lg me-1"></i>Criar Produto
            </button>
            <a href="{{ route('produtos.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
@endsection
