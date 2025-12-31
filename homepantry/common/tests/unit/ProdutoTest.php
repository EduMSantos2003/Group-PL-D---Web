<?php

namespace common\tests\unit;

use common\models\Produto;
use common\tests\UnitTester;

class ProdutoTest extends \Codeception\Test\Unit
{
    // Strings para testar limites de tamanho
    private const STRING_PEQUENA = 'ABCDE';
    private const STRING_300 =
        'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA' .
        'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA' .
        'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA';

    // Valores numéricos usados nos testes
    private const CATEGORIA_VALIDA = 1;   // tem de existir Categoria com id=1 na BD de teste
    private const UNIDADE_VALIDA   = 1;
    private const PRECO_VALIDO     = 2.50;

    protected UnitTester $tester;

    protected function _before()
    {
        // opcional: $this->createValidProduto(true);
    }

    // 1) Testes de validação das rules() do Produto
    public function testValidations()
    {
        $produto = new Produto();

        // 1.1) Todos obrigatórios a null → falham
        $produto->categoria_id = null;
        $produto->nome         = null;
        $produto->descricao    = null;
        $produto->unidade      = null;
        $produto->preco        = null;
        $produto->validade     = null;

        $this->assertFalse($produto->validate(['categoria_id']));
        $this->assertFalse($produto->validate(['nome']));
        $this->assertFalse($produto->validate(['descricao']));
        $this->assertFalse($produto->validate(['unidade']));
        $this->assertFalse($produto->validate(['preco']));
        $this->assertFalse($produto->validate(['validade']));

        // 1.2) Tipos inválidos (string em vez de integer/number)
        $produto->categoria_id = self::STRING_PEQUENA;
        $produto->unidade      = self::STRING_PEQUENA;
        $produto->preco        = self::STRING_PEQUENA;

        $this->assertFalse($produto->validate(['categoria_id']));
        $this->assertFalse($produto->validate(['unidade']));
        $this->assertFalse($produto->validate(['preco']));

        // 1.3) Strings demasiado grandes para nome/descricao (max 255)
        $produto->nome      = self::STRING_300;
        $produto->descricao = self::STRING_300;

        $this->assertFalse($produto->validate(['nome']));
        $this->assertFalse($produto->validate(['descricao']));

        // 1.4) categoria_id inteiro mas sem Categoria correspondente → falha exist
        $produto->categoria_id = 999999; // id que não existe
        $produto->nome         = 'Leite';
        $produto->descricao    = 'Leite meio-gordo';
        $produto->unidade      = self::UNIDADE_VALIDA;
        $produto->preco        = self::PRECO_VALIDO;
        $produto->validade     = '2025-12-31';

        $this->assertFalse($produto->validate(['categoria_id']));

        // 1.5) Valores totalmente válidos (pressupõe Categoria com id = 1)
        $produto->categoria_id = self::CATEGORIA_VALIDA;
        $this->assertTrue($produto->validate(['categoria_id']));
        $this->assertTrue($produto->validate(['nome']));
        $this->assertTrue($produto->validate(['descricao']));
        $this->assertTrue($produto->validate(['unidade']));
        $this->assertTrue($produto->validate(['preco']));
        $this->assertTrue($produto->validate(['validade']));

        // 1.6) imageFile opcional → sem ficheiro continua válido
        $this->assertTrue($produto->validate(['imageFile']));
    }

    // 2) Guardar e ler um produto válido
    public function testSaveAndRead()
    {
        $produto = $this->createValidProduto(false);
        $produto->nome = 'Leite gordo';

        $result = $produto->save();
        $this->assertTrue($result);

        $produtoReadFromDatabase = Produto::find()->where(['id' => $produto->id])->one();
        $this->assertNotNull($produtoReadFromDatabase);
        $this->assertEquals('Leite gordo', $produtoReadFromDatabase->nome);
    }

    // 3) Tentar guardar com nome inválido (demasiado grande)
    public function testSaveInvalidName()
    {
        $produto = $this->createValidProduto(false);
        $produto->nome = self::STRING_300; // inválido pelo max

        $result = $produto->save();
        $this->assertFalse($result);
    }

    // 4) Atualizar e ler o produto
    public function testUpdateAndRead()
    {
        $produto = $this->createValidProduto(true);

        // Ler da BD o produto acabado de criar
        $produtoReadFromDatabase = Produto::find()->where(['id' => $produto->id])->one();
        $this->assertNotNull($produtoReadFromDatabase, 'Nao foi encontrado produto na BD');
        $this->assertEquals('Arroz', $produtoReadFromDatabase->nome, 'O nome inicial do produto é diferente');

        // Atualizar o nome
        $produtoReadFromDatabase->nome = 'Massa';
        $produtoReadFromDatabase->save();

        // Voltar a ler e confirmar o update
        $produtoReadFromDatabase2 = Produto::find()->where(['id' => $produto->id])->one();
        $this->assertEquals('Massa', $produtoReadFromDatabase2->nome, 'O nome do produto após update é diferente');
    }

    // 5) Apagar um produto
    public function testDelete()
    {
        $produto = $this->createValidProduto(true);

        $produtoReadFromDatabase = Produto::find()->where(['id' => $produto->id])->one();
        $this->assertNotNull($produtoReadFromDatabase);

        $produtoReadFromDatabase->delete();

        $produtoReadFromDatabase2 = Produto::find()->where(['id' => $produto->id])->one();
        $this->assertNull($produtoReadFromDatabase2);
    }

    // Helper para criar um produto válido de acordo com as rules()
    private function createValidProduto(bool $save = false): Produto
    {
        $produto = new Produto();
        $produto->categoria_id = self::CATEGORIA_VALIDA;  // tem de existir Categoria com id=1 na BD de teste
        $produto->nome         = 'Arroz';
        $produto->descricao    = 'Arroz agulha';
        $produto->unidade      = self::UNIDADE_VALIDA;
        $produto->preco        = self::PRECO_VALIDO;
        $produto->validade     = '2025-12-31';

        if ($save) {
            $produto->save();
        }
        return $produto;
    }
}
