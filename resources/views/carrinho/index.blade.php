@extends('layouts.app')

@section('content')
    <div class="card mb-4">
        <div class="card-header">
            <h4><i class="bi bi-cart3 me-2"></i>Carrinho de Compras</h4>
        </div>
        <div class="card-body">
            @if (empty($carrinho))
                <div class="text-center py-5">
                    <i class="bi bi-cart-x display-1 text-muted"></i>
                    <h5 class="text-muted mt-3">Seu carrinho está vazio</h5>
                    <p class="text-muted">Adicione alguns produtos para continuar</p>
                    <a href="{{ route('produtos.index') }}" class="btn btn-primary">
                        <i class="bi bi-arrow-left me-1"></i>Continuar Comprando
                    </a>
                </div>
            @else
                <div class="row">
                    <div class="col-lg-8">
                        <h5>Itens do Pedido</h5>
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th>Produto</th>
                                        <th>Preço Unit.</th>
                                        <th>Quantidade</th>
                                        <th>Subtotal</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($carrinho as $id => $details)
                                        <tr>
                                            <td>
                                                <strong>{{ $details['nome'] }}</strong>
                                            </td>
                                            <td>R$ {{ number_format($details['preco'], 2, ',', '.') }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <form action="{{ route('carrinho.diminuir', $id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-outline-secondary">-</button>
                                                    </form>
                                                    <span class="mx-2 fw-bold">{{ $details['quantidade'] }}</span>
                                                    <form action="{{ route('carrinho.aumentar', $id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-outline-secondary">+</button>
                                                    </form>
                                                </div>
                                            </td>
                                            <td><strong>R$ {{ number_format($details['preco'] * $details['quantidade'], 2, ',', '.') }}</strong></td>
                                            <td>
                                                <form action="{{ route('carrinho.remover', $id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" 
                                                            onclick="return confirm('Remover este item do carrinho?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="card bg-light">
                            <div class="card-body">
                                <h5>Resumo do Pedido</h5>
                                <div class="d-flex justify-content-between">
                                    <span>Subtotal:</span>
                                    <span><strong>R$ {{ number_format($subtotal, 2, ',', '.') }}</strong></span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>Frete:</span>
                                    <span><strong>R$ {{ number_format($frete, 2, ',', '.') }}</strong></span>
                                </div>
                                @if (session('cupom'))
                                    <div class="d-flex justify-content-between text-success">
                                        <span>Cupom ({{ session('cupom')['codigo'] }}):</span>
                                        <span><strong>- R$ {{ number_format(session('cupom')['desconto'], 2, ',', '.') }}</strong></span>
                                    </div>
                                    <form action="{{ route('carrinho.removerCupom') }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-link text-danger p-0">Remover cupom</button>
                                    </form>
                                @endif
                                <hr>
                                <div class="d-flex justify-content-between fs-5">
                                    <span><strong>Total:</strong></span>
                                    <span><strong>R$ {{ number_format($total, 2, ',', '.') }}</strong></span>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-4">
                            <div class="card-header">
                                <h5>Finalizar Pedido</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('pedidos.store') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Seu E-mail <span class="text-danger">*</span></label>
                                                <input type="email" class="form-control" id="email" name="email" required>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <h6>Endereço de Entrega</h6>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="cep" class="form-label">CEP <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="cep" name="cep" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="logradouro" class="form-label">Rua <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="logradouro" name="logradouro" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="numero" class="form-label">Número</label>
                                                <input type="text" class="form-control" id="numero" name="numero">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="bairro" class="form-label">Bairro</label>
                                                <input type="text" class="form-control" id="bairro" name="bairro">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="cidade" class="form-label">Cidade</label>
                                                <input type="text" class="form-control" id="cidade" name="cidade">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="uf" class="form-label">Estado</label>
                                                <input type="text" class="form-control" id="uf" name="uf">
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success w-100 btn-lg">
                                        <i class="bi bi-check-circle me-2"></i>Finalizar Compra
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <!-- Aplicar Cupom -->
                        <div class="card">
                            <div class="card-header">
                                <h6><i class="bi bi-ticket-perforated me-1"></i>Cupom de Desconto</h6>
                            </div>
                            <div class="card-body">
                                @if (!session('cupom'))
                                    <form action="{{ route('carrinho.aplicarCupom') }}" method="POST">
                                        @csrf
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="codigo_cupom" 
                                                   placeholder="Digite seu cupom" required>
                                            <button class="btn btn-primary" type="submit">Aplicar</button>
                                        </div>
                                    </form>
                                @else
                                    <div class="alert alert-success">
                                        <i class="bi bi-check-circle me-1"></i>
                                        Cupom <strong>{{ session('cupom')['codigo'] }}</strong> aplicado!
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="card mt-3">
                            <div class="card-body">
                                <h6>Resumo Rápido</h6>
                                <small class="text-muted">
                                    {{ count($carrinho) }} {{ count($carrinho) == 1 ? 'item' : 'itens' }} no carrinho
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    document.getElementById('cep').addEventListener('blur', function() {
                        const cep = this.value.replace(/\D/g, '');
                        if (cep.length === 8) {
                            fetch(`https://viacep.com.br/ws/${cep}/json/`)
                                .then(response => response.json())
                                .then(data => {
                                    if (!data.erro) {
                                        document.getElementById('logradouro').value = data.logradouro || '';
                                        document.getElementById('bairro').value = data.bairro || '';
                                        document.getElementById('cidade').value = data.localidade || '';
                                        document.getElementById('uf').value = data.uf || '';
                                    } else {
                                        alert('CEP não encontrado.');
                                    }
                                })
                                .catch(error => {
                                    console.error('Erro ao buscar CEP:', error);
                                    alert('Erro ao buscar CEP. Tente novamente.');
                                });
                        }
                    });
                </script>
            @endif
        </div>
    </div>
@endsection
