<?php

namespace App\Http\Controllers\Oryon;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateOryonRequest;
use App\Models\Oryon;
use Illuminate\Support\Facades\Gate;
use League\Flysystem\Filesystem;
use League\Flysystem\Ftp\FtpAdapter;
use League\Flysystem\Ftp\FtpConnectionOptions;
use Illuminate\Http\Request;
use App\Http\Requests\StoreOryonRequest;

class OryonController extends Controller
{
    public function index()
    {
        $produtos = Oryon::orderBy('descricao', 'asc')->paginate(30);  // Paginação com 30 itens por página
        return view('oryon.index', compact('produtos'));  // Atualizado para oryon
    }

    public function new()
    {
        return view('oryon.create');
    }

    public function edit($id)
    {
        $produto = Oryon::find($id);
        if (!$produto) {
            return redirect()->route('oryon.index')->with('error', 'Produto não encontrado.');
        }

        return view('oryon.edit', compact('produto'));
    }

    public function destroy($id)
    {

        // Verifica se o usuário é administrador é uma segurança extra, mas não é obrigatório pois ja nao consegue acessar a rota de exclusão
        // o denise verifica se o usuário não tem permissão e o allow verifica se tem permissão
        if (Gate::denies('is-admin')) {
            return redirect()->route('oryon.index')->with('error', 'Você não tem permissão para excluir produtos.');
        }

        if (!$produto = Oryon::find($id)) {
            return redirect()->route('oryon.index')->with('error', 'Produto não encontrado.');
        }
        $produto->delete();

        return redirect()->route('oryon.index')->with('error', 'Produto excluído com sucesso!');
    }

    public function update(UpdateOryonRequest $request, $id)
    {
        if (!$produto = Oryon::find($id)) {
            return redirect()->route('oryon.index')->with('error', 'Produto não encontrado.');
        }
        $produto->update($request->validated());

        return back()->with('success', 'Produto atualizado com sucesso!');
    }

    public function store(StoreOryonRequest $request)
    {
        Oryon::create($request->validated());

        return redirect()->route('oryon.index')->with('success', 'Produto cadastrado com sucesso!');
    }

    public function importarProdutos()
    {
        // Cria as opções de conexão FTP com FtpConnectionOptions
        $ftpOptions = FtpConnectionOptions::fromArray([
            'host' => env('FTP_HOST'),
            'username' => env('FTP_USER'),
            'password' => env('FTP_PASS'),
            'port' => (int) env('FTP_PORT'),  // Garantindo que o valor de port seja um inteiro
            'root' => env('FTP_ROOT'),
            'passive' => true,
            'ssl' => false,
        ]);

        // Cria o adaptador FTP com as opções corretas
        $adapter = new FtpAdapter($ftpOptions);  // Passando o objeto FtpConnectionOptions
        $filesystem = new Filesystem($adapter);

        // Caminho para o arquivo no servidor FTP
        $ftpFile = env('FTP_FILE');

        // Obtém o conteúdo do arquivo
        if ($filesystem->has($ftpFile)) {
            $content = $filesystem->read($ftpFile);
            // Garante que o conteúdo esteja em UTF-8 para evitar problemas com acentos
            $content = mb_convert_encoding($content, 'UTF-8', 'ISO-8859-1');

            $lines = explode("\n", $content);
            array_shift($lines);
            // Converte o conteúdo do arquivo para um array
            foreach ($lines as $line) {
                $columns = str_getcsv($line, ';'); // Considerando que o separador é ponto e vírgula

                if (count($columns) == 9 && !empty($columns[0])) {  // Verifica se o arquivo tem o número correto de colunas
                    // Faz o mapeamento dos dados
                    $produtoData = [
                        'codigo' => $columns[0],
                        'descricao' => $columns[1],
                        'preco' => str_replace(',', '.', $columns[2]),  // Substitui vírgula por ponto
                        'categoria' => $columns[3],
                        'fornecedor' => $columns[4],
                        'peso' => empty($columns[5]) ? null : str_replace(',', '.', $columns[5]),  // Verifica se 'peso' está vazio e usa NULL
                        'preco_compra' => str_replace(',', '.', $columns[6]),  // Substitui vírgula por ponto
                        'estoque' => str_replace(',', '.', $columns[7]),
                    ];
                    // Verifica se o produto já existe no banco de dados
                    $produto = Oryon::updateOrCreate(
                        ['codigo' => $produtoData['codigo']],  // Verifica pelo código
                        $produtoData  // Atualiza ou cria com os dados do arquivo
                    );
                }
            }

            // Após importar, pode redirecionar para a página de produtos com sucesso
            return redirect()->route('oryon.index')->with('success', 'Produtos atualizados com sucesso!');
        } else {
            return redirect()->route('oryon.index')->with('error', 'Erro ao acessar o arquivo FTP.');
        }
    }
    public function search(Request $request)
    {
        if ($request->ajax()) {
            $query = $request->get('search');
            $produtos = Oryon::where('descricao', 'LIKE', "%{$query}%")
                ->orWhere('codigo', 'LIKE', "%{$query}%")
                ->orderBy('descricao', 'asc')
                ->paginate(70);

            $output = '';
            $isOdd = true; // Inicializa a variável para alternar as classes

            foreach ($produtos as $produto) {
                $rowClass = $isOdd ? 'bg-white dark:bg-gray-800' : 'bg-gray-200 dark:bg-gray-700';
                $isOdd = !$isOdd; // Alterna a variável

                $output .= '
                <tr class="' . $rowClass . '">
                    <td class="px-6 py-4 whitespace-normal">' . $produto->codigo . '</td>
                    <td class="px-6 py-4 whitespace-normal">' . $produto->descricao . '</td>
                    <td class="px-6 py-4 whitespace-normal">R$ ' . number_format($produto->preco, 2, ',', '.') . '</td>
                    <td class="px-6 py-4 whitespace-normal">' . $produto->categoria . '</td>
                    <td class="px-6 py-4 whitespace-normal">' . number_format($produto->estoque, 0, ',', '.') . '</td>
                    <td class="px-6 py-4 whitespace-normal">
                        <a href="' . route('oryon.edit', $produto->id) . '" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                    </td>
                </tr>';
            }
            
            $pagination = $produtos->links()->render();
            return response()->json(['tableData' => $output, 'pagination' => $pagination]);
        }
    }

}
