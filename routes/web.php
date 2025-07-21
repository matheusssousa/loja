<?php

use App\Http\Controllers\CarrinhoController;
use App\Http\Controllers\CupomController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProdutoController;
use App\Models\Produto;
use Illuminate\Support\Facades\Route;

Route::get('/', ProdutoController::class . '@index')->name('home');

Route::post('/carrinho/aplicar-cupom', [CarrinhoController::class, 'aplicarCupom'])->name('carrinho.aplicarCupom');
Route::delete('/carrinho/remover-cupom', [CarrinhoController::class, 'removerCupom'])->name('carrinho.removerCupom');
Route::post('/carrinho/adicionar/{produto}', [CarrinhoController::class, 'adicionar'])->name('carrinho.adicionar');
Route::post('/carrinho/aumentar/{produto}', [CarrinhoController::class, 'aumentar'])->name('carrinho.aumentar');
Route::post('/carrinho/diminuir/{produto}', [CarrinhoController::class, 'diminuir'])->name('carrinho.diminuir');
Route::delete('/carrinho/remover/{produto}', [CarrinhoController::class, 'remover'])->name('carrinho.remover');
Route::get('/carrinho', [CarrinhoController::class, 'index'])->name('carrinho.index');

Route::resource('cupons', CupomController::class);
Route::resource('produtos', ProdutoController::class);

Route::post('/webhook/pedido-status', [PedidoController::class, 'webhookStatus']);
Route::post('/pedidos', [PedidoController::class, 'store'])->name('pedidos.store');

