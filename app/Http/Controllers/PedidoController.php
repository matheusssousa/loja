<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Http\Requests\StorePedidoRequest;
use App\Mail\PedidoConfirmado;
use App\Models\Cupom;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PedidoController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePedidoRequest $request)
    {
        $carrinho = session()->get('carrinho', []);
        if (empty($carrinho)) {
            return redirect()->route('produtos.index')->with('error', 'Seu carrinho está vazio.');
        }

        $subtotal = 0;
        foreach ($carrinho as $item) {
            $subtotal += $item['preco'] * $item['quantidade'];
        }

        $frete = 20.00;
        if ($subtotal >= 52.00 && $subtotal <= 166.59) {
            $frete = 15.00;
        } elseif ($subtotal > 200.00) {
            $frete = 0.00;
        }

        $total = $subtotal + $frete;
        $cupomId = null;

        if (session()->has('cupom')) {
            $cupomData = session('cupom');
            $cupom = Cupom::where('codigo', $cupomData['codigo'])->first();
            if ($cupom && $subtotal >= $cupom->valor_minimo) {
                $total -= $cupom->desconto;
                $cupomId = $cupom->id;
            }
        }

        $pedido = Pedido::create([
            'cupom_id' => $cupomId, 
            'cliente_email' => $request->email, 
            'endereco' => $request->logradouro, 
            'total' => $total, 
            'status' => 'processando',
        ]);

        foreach ($carrinho as $id => $detalhes) {
            $pedido->produtos()->attach($id, [
                'quantidade' => $detalhes['quantidade'],
                'preco_unitario' => $detalhes['preco']
            ]);
            $produto = Produto::find($id);
            if ($produto && $produto->estoque) {
                $produto->estoque->decrement('quantidade', $detalhes['quantidade']);
            }
        }

        Mail::to($request->email)->send(new PedidoConfirmado($pedido));

        session()->forget(['carrinho', 'cupom']);

        return redirect()->route('produtos.index')->with('success', 'Pedido realizado com sucesso!');
    }

    public function webhookStatus(Request $request)
    {
        $validated = $request->validate([
            'pedido_id' => 'required|integer',
            'status' => 'required|string',
        ]);

        $pedido = Pedido::find($validated['pedido_id']);

        if (!$pedido) {
            return response()->json(['message' => 'Pedido não encontrado'], 404);
        }

        if ($validated['status'] === 'cancelado') {
            foreach ($pedido->produtos as $produto) {
                $produto->estoque->increment('quantidade', $produto->pivot->quantidade);
            }
            $pedido->delete();
            return response()->json(['message' => 'Pedido cancelado e removido']);
        }

        $pedido->update(['status' => $validated['status']]);
        return response()->json(['message' => 'Status do pedido atualizado']);
    }
}
