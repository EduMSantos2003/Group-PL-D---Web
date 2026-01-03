<?php

namespace common\tests\unit;

use common\models\Produto;
use common\tests\UnitTester;

class ProdutoTest extends \Codeception\Test\Unit
{
    // IDs válidos (têm de existir na BD de teste)
    private const CATEGORIA_VALIDA = 1;

    // Valores válidos
    private const NOME_VALIDO      = 'Arroz';
    private const DESCRICAO_VALIDA = 'Arroz agulha';
    private const UNIDADE_VALIDA   = 1;
    private const PRECO_VALIDO     = 1.99;
    private const VALIDADE_PT      = '31/12/2025'; // formato dd/mm/yyyy

    // Valores inválidos
    private const STRING_PEQUENA = 'ABCDE';
    private const STRING_300     = 'A'; // depois usamos str_repeat
    private const PRECO_NEGATIVO = -5.0;

    protected UnitTester $tester;

    // 1) Testes de validação das rules() de Produto
    public function testValidations()
    {
        $produto = new Produto();

        // 1.1) Campos obrigatórios a null → falham required
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

        // 1.3) Strings demasiado longas para nome/descricao/imagem
        $produto->nome      = str_repeat('A', 256);
        $produto->descricao = str_repeat('B', 256);
        $produto->imagem    = str_repeat('C', 256);

        $this->assertFalse($produto->validate(['nome']));
        $this->assertFalse($produto->validate(['descricao']));
        $this->assertFalse($produto->validate(['imagem']));

        // 1.4) categoria_id inexistente → falha exist
        $produto->categoria_id = 999999;
        $produto->nome         = self::NOME_VALIDO;
        $produto->descricao    = self::DESCRICAO_VALIDA;
        $produto->unidade      = self::UNIDADE_VALIDA;
        $produto->preco        = self::PRECO_VALIDO;
        $produto->validade     = self::VALIDADE_PT;

        $this->assertFalse($produto->validate(['categoria_id']));

        // 1.5) Valores totalmente válidos (pressupõe Categoria id=1)
        $produto->categoria_id = self::CATEGORIA_VALIDA;
        $produto->nome         = self::NOME_VALIDO;
        $produto->descricao    = self::DESCRICAO_VALIDA;
        $produto->unidade      = self::UNIDADE_VALIDA;
        $produto->preco        = self::PRECO_VALIDO;
        $produto->validade     = self::VALIDADE_PT;

        if (!$produto->validate()) {
            var_dump($produto->getErrors());
        }

        $this->assertTrue($produto->validate(['categoria_id']));
        $this->assertTrue($produto->validate(['nome']));
        $this->assertTrue($produto->validate(['descricao']));
        $this->assertTrue($produto->validate(['unidade']));
        $this->assertTrue($produto->validate(['preco']));
        $this->assertTrue($produto->validate(['validade']));

        // 1.6) imageFile é opcional → válido mesmo sem ficheiro
        $this->assertTrue($produto->validate(['imageFile']));
    }

    // 2) Guardar e ler um Produto válido (inclui teste ao beforeSave)
    public function testSaveAndRead()
    {
        $produto = $this->createValidProduto(true);

        $ProdutoReadFromDatabase = Produto::find()
            ->where(['id' => $produto->id])
            ->one();

        $this->assertNotNull($ProdutoReadFromDatabase);

        // Verificar se os campos simples foram persistidos
        $this->assertEquals(self::CATEGORIA_VALIDA, $ProdutoReadFromDatabase->categoria_id);
        $this->assertEquals(self::NOME_VALIDO, $ProdutoReadFromDatabase->nome);
        $this->assertEquals(self::DESCRICAO_VALIDA, $ProdutoReadFromDatabase->descricao);
        $this->assertEquals(self::UNIDADE_VALIDA, $ProdutoReadFromDatabase->unidade);
        $this->assertEquals(self::PRECO_VALIDO, $ProdutoReadFromDatabase->preco);

        // beforeSave: validade normalizada para Y-m-d
        $this->assertEquals('2025-12-31', $ProdutoReadFromDatabase->validade);
    }

    // 3) Tentar guardar com preco inválido (string) → falha save
    public function testSaveInvalidPreco()
    {
        $produto = new Produto();
        $produto->categoria_id = self::CATEGORIA_VALIDA;
        $produto->nome         = self::NOME_VALIDO;
        $produto->descricao    = self::DESCRICAO_VALIDA;
        $produto->unidade      = self::UNIDADE_VALIDA;
        $produto->preco        = self::STRING_PEQUENA; // inválido
        $produto->validade     = self::VALIDADE_PT;

        $this->assertFalse($produto->save());
    }

    // 4) Atualizar e ler Produto (inclui teste preco negativo → 0)
    public function testUpdateAndRead()
    {
        $produto = $this->createValidProduto(true);

        $ProdutoReadFromDatabase = Produto::findOne($produto->id);
        $this->assertNotNull($ProdutoReadFromDatabase);

        // Quantidade de alterações: mudar preco para negativo e nome
        $ProdutoReadFromDatabase->preco = self::PRECO_NEGATIVO;
        $ProdutoReadFromDatabase->nome  = 'Arroz integral';

        if (!$ProdutoReadFromDatabase->validate()) {
            var_dump($ProdutoReadFromDatabase->getErrors());
        }

        $this->assertTrue($ProdutoReadFromDatabase->save());

        $ProdutoReadFromDatabase2 = Produto::findOne($produto->id);

        // beforeSave: preco negativo deve ser guardado como 0
        $this->assertEquals(0.0, $ProdutoReadFromDatabase2->preco);
        $this->assertEquals('Arroz integral', $ProdutoReadFromDatabase2->nome);
    }

    // 5) Apagar um Produto
    public function testDelete()
    {
        $produto = $this->createValidProduto(true);

        $ProdutoReadFromDatabase = Produto::findOne($produto->id);
        $this->assertNotNull($ProdutoReadFromDatabase);

        $ProdutoReadFromDatabase->delete();

        $ProdutoReadFromDatabase2 = Produto::findOne($produto->id);
        $this->assertNull($ProdutoReadFromDatabase2);
    }

    // Helper para criar um Produto válido
    private function createValidProduto(bool $save = false): Produto
    {
        $produto = new Produto();
        $produto->categoria_id = self::CATEGORIA_VALIDA;
        $produto->nome         = self::NOME_VALIDO;
        $produto->descricao    = self::DESCRICAO_VALIDA;
        $produto->unidade      = self::UNIDADE_VALIDA;
        $produto->preco        = self::PRECO_VALIDO;
        $produto->validade     = self::VALIDADE_PT;

        if (!$produto->validate()) {
            var_dump($produto->getErrors());
        }

        if ($save) {
            $this->assertTrue($produto->save());
        }

        return $produto;
    }
}
