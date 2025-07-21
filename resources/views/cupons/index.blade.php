@extends('layouts.app')

@section('content')
    <div class="card mb-5">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4><i class="bi bi-ticket-perforated me-2"></i>Gerenciar Cupons</h4>
            <button class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#novoCupomForm" 
                    aria-expanded="false" aria-controls="novoCupomForm">
                <i class="bi bi-plus-circle me-1"></i>Novo Cupom
            </button>
        </div>
        <div class="card-body">
            <div class="collapse" id="novoCupomForm">
                <div class="card border-primary mb-4">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0"><i class="bi bi-plus-circle me-1"></i>Criar Novo Cupom</h6>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <h6><i class="bi bi-exclamation-triangle-fill me-1"></i>Erro de validação</h6>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <form action="{{ route('cupons.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="codigo" class="form-label">Código <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('codigo') is-invalid @enderror" 
                                               id="codigo" name="codigo" value="{{ old('codigo') }}" 
                                               placeholder="Ex: DESCONTO10" required>
                                        @error('codigo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="desconto" class="form-label">Desconto (R$) <span class="text-danger">*</span></label>
                                        <input type="number" step="0.01" class="form-control @error('desconto') is-invalid @enderror" 
                                               id="desconto" name="desconto" value="{{ old('desconto') }}" required>
                                        @error('desconto')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="valor_minimo" class="form-label">Valor Mínimo (R$) <span class="text-danger">*</span></label>
                                        <input type="number" step="0.01" class="form-control @error('valor_minimo') is-invalid @enderror" 
                                               id="valor_minimo" name="valor_minimo" value="{{ old('valor_minimo') }}" required>
                                        @error('valor_minimo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="data_expiracao" class="form-label">data_expiracao <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control @error('data_expiracao') is-invalid @enderror" 
                                               id="data_expiracao" name="data_expiracao" value="{{ old('data_expiracao') }}" 
                                               min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                                        @error('data_expiracao')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end gap-2">
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-check-lg me-1"></i>Salvar Cupom
                                </button>
                                <button type="button" class="btn btn-secondary" data-bs-toggle="collapse" 
                                        data-bs-target="#novoCupomForm" aria-expanded="false">
                                    Cancelar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($cupons->count() > 0)
        <div class="row">
            @foreach ($cupons as $cupom)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100 shadow-sm border-left-primary">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <h5 class="card-title text-primary">
                                    <i class="bi bi-ticket-perforated me-1"></i>{{ $cupom->codigo }}
                                </h5>
                                @php
                                    $isExpired = \Carbon\Carbon::parse($cupom->data_expiracao)->isPast();
                                @endphp
                                <span class="badge {{ $isExpired ? 'bg-danger' : 'bg-success' }}">
                                    {{ $isExpired ? 'Expirado' : 'Ativo' }}
                                </span>
                            </div>
                            
                            <div class="mb-3">
                                <p class="card-text mb-1">
                                    <strong class="text-success fs-5">
                                        - R$ {{ number_format($cupom->desconto, 2, ',', '.') }}
                                    </strong>
                                </p>
                                <small class="text-muted">
                                    <i class="bi bi-cash-coin me-1"></i>
                                    Valor mínimo: R$ {{ number_format($cupom->valor_minimo, 2, ',', '.') }}
                                </small>
                            </div>
                            
                            <div class="mb-3">
                                <small class="text-muted">
                                    <i class="bi bi-calendar-event me-1"></i>
                                    Válido até: {{ \Carbon\Carbon::parse($cupom->data_expiracao)->format('d/m/Y') }}
                                </small>
                            </div>
                        </div>
                        
                        <div class="card-footer bg-transparent">
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-outline-primary btn-sm" 
                                        onclick="copiarCupom('{{ $cupom->codigo }}')">
                                    <i class="bi bi-clipboard me-1"></i>Copiar Código
                                </button>
                                <form action="{{ route('cupons.destroy', $cupom->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" 
                                            onclick="return confirm('Tem certeza que deseja excluir este cupom?')">
                                        <i class="bi bi-trash"></i> Excluir
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $cupons->appends(request()->query())->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <div class="mb-3">
                <i class="bi bi-ticket-perforated display-1 text-muted"></i>
            </div>
            <h4 class="text-muted">Nenhum cupom encontrado</h4>
            <p class="text-muted">Comece criando seu primeiro cupom de desconto!</p>
            <button class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#novoCupomForm">
                <i class="bi bi-plus-circle me-1"></i>Criar Primeiro Cupom
            </button>
        </div>
    @endif

    <script>
        function copiarCupom(codigo) {
            navigator.clipboard.writeText(codigo).then(function() {
                const toast = document.createElement('div');
                toast.className = 'toast align-items-center text-white bg-success border-0';
                toast.setAttribute('role', 'alert');
                toast.style.position = 'fixed';
                toast.style.top = '20px';
                toast.style.right = '20px';
                toast.style.zIndex = '9999';
                toast.innerHTML = `
                    <div class="d-flex">
                        <div class="toast-body">
                            Código ${codigo} copiado para a área de transferência!
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                `;
                document.body.appendChild(toast);
                const bsToast = new bootstrap.Toast(toast);
                bsToast.show();
                toast.addEventListener('hidden.bs.toast', function () {
                    document.body.removeChild(toast);
                });
            });
        }
    </script>
@endsection