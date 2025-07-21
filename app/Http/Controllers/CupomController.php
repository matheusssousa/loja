<?php

namespace App\Http\Controllers;

use App\Models\Cupom;
use App\Http\Requests\StoreCupomRequest;
use App\Http\Requests\UpdateCupomRequest;
use App\Repositories\Eloquent\CupomRepository;
use Illuminate\Http\Request;

class CupomController extends Controller
{
    protected $cupomRepository;

    public function __construct(CupomRepository $cupomRepository)
    {
        $this->cupomRepository = $cupomRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $cupons = $this->cupomRepository->all($request);
        return view('cupons.index', compact('cupons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cupons.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCupomRequest $request)
    {
        $cupom = $this->cupomRepository->create($request->validated());
        return redirect()->route('cupons.index')->with('success', 'Cupom criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cupom $cupom)
    {
        return view('cupons.show', compact('cupom'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cupom $cupom)
    {
        return view('cupons.edit', compact('cupom'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCupomRequest $request, Cupom $cupom)
    {
        $this->cupomRepository->update($cupom->id, $request->validated());
        return redirect()->route('cupons.show', $cupom);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cupom $cupom)
    {
        $this->cupomRepository->delete($cupom->id);
        return redirect()->route('cupons.index');
    }
}
