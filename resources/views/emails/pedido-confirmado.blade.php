<!DOCTYPE html>
<html>
<head>
    <title>Confirmação do Pedido</title>
</head>
<body>
    <h1>Obrigado pelo seu pedido!</h1>
    <p>Olá,</p>
    <p>Seu pedido #{{ $pedido->id }} foi recebido e está sendo processado.</p>

    <h2>Detalhes do Pedido</h2>
    <table border="1" cellpadding="10" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Produto</th>
                <th>Quantidade</th>
                <th>Preço</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pedido->produtos as $produto)
                <tr>
                    <td>{{ $produto->nome }}</td>
                    <td>{{ $produto->pivot->quantidade }}</td>
                    <td>R$ {{ number_format($produto->preco, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3 style="margin-top: 20px;">Total: R$ {{ number_format($pedido->valor_total, 2, ',', '.') }}</h3>

    <p>Obrigado por comprar conosco!</p>
</body>
</html>