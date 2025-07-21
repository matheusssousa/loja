@extends('layouts.app')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('produtos.update', $produto->id) }}" method="POST" class="card">
        @csrf
        @method('PUT')
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Editar Produto</h4>
            <a href="{{ route('produtos.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Voltar
            </a>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome do Produto <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nome') is-invalid @enderror"
                       id="nome" name="nome" value="{{ old('nome', $produto->nome) }}" required>
                @error('nome')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="preco" class="form-label">Preço (R$) <span class="text-danger">*</span></label>
                <input type="number" step="0.01" class="form-control @error('preco') is-invalid @enderror"
                       id="preco" name="preco" value="{{ old('preco', $produto->preco) }}" required>
                @error('preco')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="estoque" class="form-label">Quantidade em Estoque <span class="text-danger">*</span></label>
                <input type="number" class="form-control @error('estoque') is-invalid @enderror"
                       id="estoque" name="estoque" value="{{ old('estoque', $produto->estoque->quantidade ?? 0) }}" required>
                @error('estoque')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">Informe a quantidade disponível do produto</div>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-end gap-2">
            <button type="submit" class="btn btn-primary">Atualizar</button>
        </div>
    </form>
@endsection
