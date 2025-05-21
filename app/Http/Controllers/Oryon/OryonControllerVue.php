<?php

namespace App\Http\Controllers\Oryon;

use App\Http\Controllers\Controller;
use App\Services\FtpImportService;
use Illuminate\Http\Request;
use App\Models\Oryon;
use Illuminate\Support\Facades\Auth;

class OryonControllerVue extends Controller
{
    public function index()
    {
        return response()->json(Oryon::all());
    }

    public function store(Request $request)
    {
        if (!auth()->user()->hasRole('administradores')) {
            return response()->json([
                'success' => false,
                'message' => 'Acesso negado. Apenas administradores podem cadastrar produtos.'
            ], 403);
        }

        $oryon = Oryon::create($request->all());

        return response()->json([
            'success' => true,
            'message' => "Produto '{$oryon->codigo} - {$oryon->descricao}' criado com sucesso.",
            'produto' => $oryon
        ], 201);
    }

    public function show($id)
    {
        $oryon = Oryon::findOrFail($id);
        return response()->json($oryon);
    }

    public function update(Request $request, $id)
    {
        if (!auth()->user()->hasRole('administradores')) {
            return response()->json([
                'success' => false,
                'message' => 'Acesso negado. Apenas administradores podem atualizar produtos.'
            ], 403);
        }

        $oryon = Oryon::findOrFail($id);
        $oryon->update($request->all());

        return response()->json([
            'success' => true,
            'message' => "Produto '{$oryon->codigo} - {$oryon->descricao}' atualizado com sucesso.",
            'produto' => $oryon
        ]);
    }

    public function destroy($id)
    {
        if (!auth()->user()->hasRole('administradores')) {
            return response()->json([
                'success' => false,
                'message' => 'Acesso negado. Apenas administradores podem excluir produtos.'
            ], 403);
        }

        $oryon = Oryon::find($id);

        if (!$oryon) {
            return response()->json([
                'success' => false,
                'message' => "Produto ID {$id} não encontrado."
            ], 404);
        }

        $codigo = $oryon->codigo;
        $descricao = $oryon->descricao;

        try {
            $oryon->delete();

            return response()->json([
                'success' => true,
                'message' => "Produto '{$descricao} | Código: {$codigo}' excluído com sucesso."
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => "Erro ao excluir '{$descricao} | Código: {$codigo}' " . $e->getMessage()
            ], 500);
        }
    }
    
    public function importar(FtpImportService $ftpImportService)
    {
        $resultado = $ftpImportService->import();

        if ($resultado['success']) {
            return response()->json(['message' => $resultado['message']], 200);
        } else {
            return response()->json(['message' => $resultado['message']], 500);
        }
    }
}