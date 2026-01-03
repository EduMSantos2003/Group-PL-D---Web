<?php

namespace common\tests\unit;

use common\models\ListaProduto;
use common\tests\UnitTester;

class ListaProdutoTest extends \Codeception\Test\Unit
{
    // Valores para testes
    private const STRING = 'ABCDE';
    private const QUANTIDADE_VALIDA = 2;
    private const QUANTIDADE_ATUALIZADA = 5;

    protected UnitTester $tester;

    protected function _before()
    {
//        $this->createValidListaProduto(true);
    }

    // 1) Testes de validação das rules() de ListaProduto
    public function testValidations()
    {
        $listaProduto = new ListaProduto();

        // 1.1) Todos obrigatórios a null → falham
        $listaProduto->lista_id   = null;
        $listaProduto->produto_id = null;
        $listaProduto->quantidade = null;

        $this->assertFalse($listaProduto->validate(['lista_id']));
        $this->assertFalse($listaProduto->validate(['produto_id']));
        $this->assertFalse($listaProduto->validate(['quantidade']));

        // 1.2) Tipos inválidos (string em vez de integer/number)
        $listaProduto->lista_id      = self::STRING;
        $listaProduto->produto_id    = self::STRING;
        $listaProduto->quantidade    = self::STRING;
        $listaProduto->precoUnitario = self::STRING;
        $listaProduto->subTotal      = self::STRING;

        $this->assertFalse($listaProduto->validate(['lista_id']));
        $this->assertFalse($listaProduto->validate(['produto_id']));
        $this->assertFalse($listaProduto->validate(['quantidade']));
        $this->assertFalse($listaProduto->validate(['precoUnitario']));
        $this->assertFalse($listaProduto->validate(['subTotal']));

        // 1.3) IDs inteiros mas sem Lista/Produto correspondente → falham exist
        $listaProduto->lista_id   = 999999; // ids que não existem
        $listaProduto->produto_id = 999999;
        $listaProduto->quantidade = self::QUANTIDADE_VALIDA;

        $this->assertFalse($listaProduto->validate(['lista_id']));
        $this->assertFalse($listaProduto->validate(['produto_id']));

        // 1.4) Valores totalmente válidos (pressupõe Lista id=1 e Produto id=1)
        $listaProduto->lista_id      = 2;
        $listaProduto->produto_id    = 2;
        $listaProduto->quantidade    = self::QUANTIDADE_VALIDA;
        $listaProduto->precoUnitario = 1.5;
        $listaProduto->subTotal      = self::QUANTIDADE_VALIDA * 1.5;

        $this->assertTrue($listaProduto->validate(['lista_id']));
        $this->assertTrue($listaProduto->validate(['produto_id']));
        $this->assertTrue($listaProduto->validate(['quantidade']));
        $this->assertTrue($listaProduto->validate(['precoUnitario']));
        $this->assertTrue($listaProduto->validate(['subTotal']));
    }

    // 2) Guardar e ler
    public function testSaveAndRead()
    {
        $listaProduto = $this->createValidListaProduto(false);
        $listaProduto->quantidade = self::QUANTIDADE_VALIDA;

        $result = $listaProduto->save();
        $this->assertTrue($result);

        $listaProdutoFromDatebase = ListaProduto::find()->where(['id' => $listaProduto->id])->one();
        $this->assertNotNull($listaProdutoFromDatebase);
        $this->assertEquals(self::QUANTIDADE_VALIDA, $listaProdutoFromDatebase->quantidade);
    }

    public function beforeSave($insert)
    {
        if ($this->produto_id) {
            $produto = Produto::findOne($this->produto_id);
            if ($produto) {
                $this->precoUnitario = $produto->preco;
            }
        }

        $this->subTotal = $this->quantidade * $this->precoUnitario;

        return parent::beforeSave($insert);
    }

    // 3) beforeSave deve calcular precoUnitario e subTotal a partir do Produto
    public function testBeforeSaveCalculaSubTotal()
    {
        // Arrange
        $listaProduto = $this->createValidListaProduto(false);
        $listaProduto->quantidade = self::QUANTIDADE_VALIDA; // 2

        // Act
        $this->assertTrue($listaProduto->save());

        // Assert
        $listaProdutoFromDatabase = ListaProduto::findOne($listaProduto->id);
        $this->assertNotNull($listaProdutoFromDatabase);

        // precoUnitario tem de vir do Produto (por ex., 1.00)
        $this->assertGreaterThan(0, $listaProdutoFromDatabase->precoUnitario);

        // subTotal = quantidade * precoUnitario
        $this->assertEquals(
            $listaProdutoFromDatabase->quantidade * $listaProdutoFromDatabase->precoUnitario,
            $listaProdutoFromDatabase->subTotal
        );
    }

    // 4) Atualizar e ler
    public function testUpdateAndRead()
    {
        $listaProduto = $this->createValidListaProduto(true);

        $listaProdutoFromDatebase = ListaProduto::find()->where(['id' => $listaProduto->id])->one();
        $this->assertNotNull($listaProduto);

        $listaProdutoFromDatebase->quantidade = self::QUANTIDADE_ATUALIZADA;
        $listaProdutoFromDatebase->save();

        $listaProdutoFromDatebase2 = ListaProduto::find()->where(['id' => $listaProduto->id])->one();
        $this->assertEquals(self::QUANTIDADE_ATUALIZADA, $listaProdutoFromDatebase2->quantidade);
    }

    // 5) Apagar
    public function testDelete()
    {
        $listaProduto = $this->createValidListaProduto(true);

        $listaProdutoFromDatebase = ListaProduto::find()->where(['id' => $listaProduto->id])->one();
        $this->assertNotNull($listaProdutoFromDatebase);

        $listaProdutoFromDatebase->delete();

        $listaProdutoFromDatebase2 = ListaProduto::find()->where(['id' => $listaProduto->id])->one();
        $this->assertNull($listaProdutoFromDatebase2);
    }

    // Helper: cria um ListaProduto válido
    private function createValidListaProduto(bool $save = false): ListaProduto
    {
        $listaProduto = new ListaProduto();
        $listaProduto->lista_id   = 2;                     // tem de existir Lista com id=2
        $listaProduto->produto_id = 2;                     // tem de existir Produto com id=2
        $listaProduto->quantidade = self::QUANTIDADE_VALIDA;

        if ($save) {
            $this->assertTrue($listaProduto->save());
        }
        return $listaProduto;
    }
}