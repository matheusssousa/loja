<?php

namespace App\Http\Controllers;

use App\Models\Cupom;
use App\Models\Produto;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CarrinhoController extends Controller
{
    public function adicionar(Request $request, Produto $produto)
    {
        $quantidade = $request->input('quantidade', 1);
        
        if ($produto->estoque->quantidade < $quantidade) {
            return redirect()->back()->with('error', 'Estoque insuficiente! Disponível: ' . $produto->estoque->quantidade . ' unidades.');
        }
        
        $carrinho = session()->get('carrinho', []);

        if (isset($carrinho[$produto->id])) {
            $novaQuantidade = $carrinho[$produto->id]['quantidade'] + $quantidade;
            if ($produto->estoque->quantidade < $novaQuantidade) {
                return redirect()->back()->with('error', 'Estoque insuficiente! Você já tem ' . $carrinho[$produto->id]['quantidade'] . ' no carrinho.');
            }
            $carrinho[$produto->id]['quantidade'] = $novaQuantidade;
        } else {
            $carrinho[$produto->id] = [
                "nome" => $produto->nome,
                "quantidade" => $quantidade,
                "preco" => $produto->preco,
            ];
        }

        session()->put('carrinho', $carrinho);
        return redirect()->back()->with('success', $quantidade . ' unidade(s) de "' . $produto->nome . '" adicionada(s) ao carrinho!');
    }

    public function index()
    {
        $carrinho = session()->get('carrinho', []);
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
        
        $desconto = 0;
        if (session()->has('cupom')) {
            $cupomData = session('cupom');
            $desconto = $cupomData['desconto'];
            $total -= $desconto;
        }

        return view('carrinho.index', compact('carrinho', 'subtotal', 'frete', 'total', 'desconto'));
    }

    public function aplicarCupom(Request $request)
    {
        $cupom = Cupom::where('codigo', $request->codigo_cupom)->first();
        $carrinho = session()->get('carrinho', []);
        
        $subtotal = 0;
        foreach ($carrinho as $item) {
            $subtotal += $item['preco'] * $item['quantidade'];
        }

        if (!$cupom) {
            return redirect()->route('carrinho.index')->with('error', 'Cupom inválido.');
        }
        if ($cupom->data_expiracao < Carbon::today()) {
            return redirect()->route('carrinho.index')->with('error', 'Cupom expirado.');
        }
        if ($subtotal < $cupom->valor_minimo) {
            return redirect()->route('carrinho.index')->with('error', 'O valor mínimo para este cupom não foi atingido. Valor mínimo: R$ ' . number_format($cupom->valor_minimo, 2, ',', '.'));
        }

        session()->put('cupom', [
            'codigo' => $cupom->codigo,
            'desconto' => $cupom->desconto 
        ]);

        return redirect()->route('carrinho.index')->with('success', 'Cupom aplicado com sucesso!');
    }

    public function aumentar($produtoId)
    {
        $carrinho = session()->get('carrinho', []);
        
        if (isset($carrinho[$produtoId])) {
            $produto = Produto::find($produtoId);
            if ($carrinho[$produtoId]['quantidade'] < $produto->estoque->quantidade) {
                $carrinho[$produtoId]['quantidade']++;
                session()->put('carrinho', $carrinho);
                return redirect()->route('carrinho.index')->with('success', 'Quantidade atualizada!');
            } else {
                return redirect()->route('carrinho.index')->with('error', 'Estoque insuficiente!');
            }
        }
        
        return redirect()->route('carrinho.index');
    }

    public function diminuir($produtoId)
    {
        $carrinho = session()->get('carrinho', []);
        
        if (isset($carrinho[$produtoId])) {
            if ($carrinho[$produtoId]['quantidade'] > 1) {
                $carrinho[$produtoId]['quantidade']--;
                session()->put('carrinho', $carrinho);
                return redirect()->route('carrinho.index')->with('success', 'Quantidade atualizada!');
            } else {
                unset($carrinho[$produtoId]);
                session()->put('carrinho', $carrinho);
                return redirect()->route('carrinho.index')->with('success', 'Item removido do carrinho!');
            }
        }
        
        return redirect()->route('carrinho.index');
    }

    public function remover($produtoId)
    {
        $carrinho = session()->get('carrinho', []);
        
        if (isset($carrinho[$produtoId])) {
            $nomeProduto = $carrinho[$produtoId]['nome'];
            unset($carrinho[$produtoId]);
            session()->put('carrinho', $carrinho);
            return redirect()->route('carrinho.index')->with('success', '"' . $nomeProduto . '" removido do carrinho!');
        }
        
        return redirect()->route('carrinho.index');
    }

    public function removerCupom()
    {
        session()->forget('cupom');
        return redirect()->route('carrinho.index')->with('success', 'Cupom removido!');
    }
}
