<?php

namespace App\Services;

use App\Models\Oryon;
use League\Flysystem\Filesystem;
use League\Flysystem\Ftp\FtpAdapter;
use League\Flysystem\Ftp\FtpConnectionOptions;

class FtpImportService
{
    public function import(): array
    {
        if (!$ftpFile = env('FTP_FILE')) {
            return ['success' => false, 'message' => 'Arquivo FTP não configurado.'];
        }

        $ftpOptions = FtpConnectionOptions::fromArray([
            'host' => env('FTP_HOST'),
            'username' => env('FTP_USER'),
            'password' => env('FTP_PASS'),
            'port' => (int) env('FTP_PORT'),
            'root' => env('FTP_ROOT'),
            'passive' => true,
            'ssl' => false,
        ]);

        $adapter = new FtpAdapter($ftpOptions);
        $filesystem = new Filesystem($adapter);

        if ($filesystem->has($ftpFile)) {
            $content = $filesystem->read($ftpFile);
            $content = mb_convert_encoding($content, 'UTF-8', 'ISO-8859-1');

            $lines = array_filter(array_map('trim', explode("\n", $content)));

            if (empty($lines)) {
                return ['success' => false, 'message' => 'Arquivo vazio ou inválido.'];
            }

            $header = str_getcsv(array_shift($lines), ';');
            $headerMap = [];

            foreach ($header as $index => $col) {
                $normalized = $this->normalizeHeader($col);
                switch ($normalized) {
                    case 'codigo':
                    case 'descricao':
                    case 'preco':
                    case 'categoria':
                    case 'fornecedor':
                    case 'peso':
                    case 'codigo_forn':
                    case 'preco_compra':
                    case 'estoque':
                        $headerMap[$normalized] = $index;
                        break;
                }
            }

            $required = ['codigo', 'descricao', 'preco', 'categoria', 'fornecedor', 'peso', 'codigo_forn', 'preco_compra', 'estoque'];
            foreach ($required as $req) {
                if (!array_key_exists($req, $headerMap)) {
                    return [
                        'success' => false,
                        'message' => "Coluna obrigatória '{$req}' não encontrada no cabeçalho."
                    ];
                }
            }

            foreach ($lines as $lineNumber => $line) {
                $columns = str_getcsv($line, ';');

                // Validação dos campos obrigatórios
                $missing = [];

                foreach (['codigo', 'descricao', 'categoria', 'preco'] as $requiredField) {
                    $index = $headerMap[$requiredField];

                    if (!isset($columns[$index]) || trim($columns[$index]) === '') {
                        $missing[] = $requiredField;
                    }
                }

                if (!empty($missing)) {
                    return [
                        'success' => false,
                        'message' => "Erro na linha " . ($lineNumber + 2) . ": campos obrigatórios ausentes → " . implode(', ', $missing)
                    ];
                }

                $produtoData = [
                    'codigo' => $columns[$headerMap['codigo']],
                    'descricao' => $columns[$headerMap['descricao']],
                    'preco' => (!empty($columns[$headerMap['preco']]) && is_numeric(str_replace(',', '.', $columns[$headerMap['preco']])))
                        ? str_replace(',', '.', $columns[$headerMap['preco']])
                        : null,
                    'categoria' => $columns[$headerMap['categoria']],
                    'fornecedor' => $columns[$headerMap['fornecedor']],
                    'peso' => (!empty($columns[$headerMap['peso']]) && is_numeric(str_replace(',', '.', $columns[$headerMap['peso']])))
                        ? str_replace(',', '.', $columns[$headerMap['peso']])
                        : null,
                    'codigo_fornecedor' => $columns[$headerMap['codigo_forn']] ?? null,
                    'preco_compra' => (!empty($columns[$headerMap['preco_compra']]) && is_numeric(str_replace(',', '.', $columns[$headerMap['preco_compra']])))
                        ? str_replace(',', '.', $columns[$headerMap['preco_compra']])
                        : null,
                    'estoque' => (!empty($columns[$headerMap['estoque']]) && is_numeric(str_replace(',', '.', $columns[$headerMap['estoque']])))
                        ? str_replace(',', '.', $columns[$headerMap['estoque']])
                        : null,
                ];

                Oryon::updateOrCreate(
                    ['codigo' => $produtoData['codigo']],
                    $produtoData
                );
            }

            return ['success' => true, 'message' => 'Produtos atualizados com sucesso!'];
        }

        return ['success' => false, 'message' => 'Arquivo não encontrado no FTP.'];
    }

    private function normalizeHeader($header)
    {
        $header = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $header);  // Transforma acentos
        $header = mb_strtolower($header);
        $header = preg_replace('/[^a-z0-9_]/u', '', $header);
        return $header;
    }
}