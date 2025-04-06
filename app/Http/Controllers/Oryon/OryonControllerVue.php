<?php

namespace App\Http\Controllers\Oryon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Oryon;

class OryonControllerVue extends Controller
{
    public function index()
    {
        return response()->json(Oryon::all());
    }

    public function store(Request $request)
    {
        $oryon = Oryon::create($request->all());
        return response()->json($oryon, 201);
    }

    public function show($id)
    {
        return response()->json(Oryon::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $oryon = Oryon::findOrFail($id);
        $oryon->update($request->all());
        return response()->json($oryon);
    }

    public function destroy($id)
    {
        $oryon = Oryon::findOrFail($id);
        $oryon->delete();
        return response()->json(['message' => 'Produto deletado com sucesso.']);
    }
}