<?php

namespace common\tests\unit;

use common\models\Lista;
use common\models\ListaProduto;
use common\tests\UnitTester;

class ListaTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;

    // IDs válidos (têm de existir na BD de teste)
    private const UTILIZADOR_VALIDO = 1;

    // Valores válidos
    private const NOME_VALIDO = 'Compras semanais';
    private const TIPO_VALIDO = 'Supermercado';

    // Valores inválidos
    private const STRING_PEQUENA = 'ABCDE';

    protected function _before()
    {
//        $this->createValidLista(true);
    }

    // 1) Testes de validação das rules() de Lista
    public function testValidations()
    {
        $lista = new Lista();

        // 1.1) Campos obrigatórios a null → falham required
        $lista->nome = null;
        $lista->tipo = null;

        $this->assertFalse($lista->validate(['nome']));
        $this->assertFalse($lista->validate(['tipo']));

        // 1.2) Campos numéricos com string → falham number/integer
        $lista->nome = self::NOME_VALIDO;
        $lista->tipo = self::TIPO_VALIDO;
        $lista->totalEstimado = self::STRING_PEQUENA;
        $lista->utilizador_id = self::STRING_PEQUENA;

        $this->assertFalse($lista->validate(['totalEstimado']));
        $this->assertFalse($lista->validate(['utilizador_id']));

        // 1.3) Strings demasiado longas para nome/tipo
        $lista->nome = str_repeat('A', 256);
        $lista->tipo = str_repeat('B', 256);

        $this->assertFalse($lista->validate(['nome']));
        $this->assertFalse($lista->validate(['tipo']));

        // 1.4) utilizador_id inexistente → falha exist
        $lista->nome = self::NOME_VALIDO;
        $lista->tipo = self::TIPO_VALIDO;
        $lista->totalEstimado = 10.5;
        $lista->utilizador_id = 999999;

        $this->assertFalse($lista->validate(['utilizador_id']));

        // 1.5) Valores totalmente válidos (pressupõe User id=1)
        $lista->utilizador_id = self::UTILIZADOR_VALIDO;

        if (!$lista->validate()) {
            var_dump($lista->getErrors());
        }

        $this->assertTrue($lista->validate(['nome']));
        $this->assertTrue($lista->validate(['tipo']));
        $this->assertTrue($lista->validate(['totalEstimado']));
        $this->assertTrue($lista->validate(['utilizador_id']));
    }

    // 2) Guardar e ler uma Lista válida
    public function testSaveAndRead()
    {
        $lista = $this->createValidLista(true);

        $ListaReadFromDatabase = Lista::find()
            ->where(['id' => $lista->id])
            ->one();

        $this->assertNotNull($ListaReadFromDatabase);
        $this->assertEquals(self::NOME_VALIDO, $ListaReadFromDatabase->nome);
        $this->assertEquals(self::TIPO_VALIDO, $ListaReadFromDatabase->tipo);
        $this->assertEquals(0.0, (float)$ListaReadFromDatabase->totalEstimado);
    }

    // 3) Testar calcularTotal() com ListaProdutos associados
    public function testCalcularTotal()
    {
        $lista = $this->createValidLista(true);

        $lp1 = new ListaProduto();
        $lp1->lista_id      = $lista->id;
        $lp1->produto_id    = 2;        // tem de existir Produto id=2 na BD de teste
        $lp1->quantidade    = 2;
        $lp1->precoUnitario = 1.5;
        $lp1->subTotal      = 3.0;

        if (!$lp1->save()) {
            var_dump($lp1->getErrors());
        }
        $this->assertTrue($lp1->save());

        $lp2 = new ListaProduto();
        $lp2->lista_id      = $lista->id;
        $lp2->produto_id    = 1;
        $lp2->quantidade    = 1;
        $lp2->precoUnitario = 2.0;
        $lp2->subTotal      = 2.0;

        if (!$lp2->save()) {
            var_dump($lp2->getErrors());
        }
        $this->assertTrue($lp2->save());

        $this->assertEquals(5.0, $lista->calcularTotal());
    }


    // 4) Atualizar e ler Lista
    public function testUpdateAndRead()
    {
        $lista = $this->createValidLista(true);

        $ListaReadFromDatabase = Lista::findOne($lista->id);
        $this->assertNotNull($ListaReadFromDatabase);

        $ListaReadFromDatabase->nome = 'Compras mensais';

        if (!$ListaReadFromDatabase->validate()) {
            var_dump($ListaReadFromDatabase->getErrors());
        }

        $this->assertTrue($ListaReadFromDatabase->save());

        $ListaReadFromDatabase2 = Lista::findOne($lista->id);

        $this->assertEquals('Compras mensais', $ListaReadFromDatabase2->nome);
    }


    // 5) Apagar uma Lista
    public function testDelete()
    {
        $lista = $this->createValidLista(true);

        $ListaReadFromDatabase = Lista::findOne($lista->id);
        $this->assertNotNull($ListaReadFromDatabase);

        $ListaReadFromDatabase->delete();

        $ListaReadFromDatabase2 = Lista::findOne($lista->id);
        $this->assertNull($ListaReadFromDatabase2);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        // Em testes unitários não queremos mexer em MQTT nem em casa_id
        if (YII_ENV_TEST) {
            return;
        }

        /*
        if ($this->lista && $this->lista->casa_id) {
            $casaId = $this->lista->casa_id;
            // código MQTT...
        }
        */
    }
    public function afterDelete()
    {
        parent::afterDelete();

        if (YII_ENV_TEST) {
            return;
        }

        /*
        if ($this->lista && $this->lista->casa_id) {
            $casaId = $this->lista->casa_id;
            // código MQTT...
        }
        */
    }

    // Helper para criar uma Lista válida
    private function createValidLista(bool $save = false): Lista
    {
        $lista = new Lista();
        $lista->nome = self::NOME_VALIDO;
        $lista->tipo = self::TIPO_VALIDO;
        $lista->totalEstimado = 0.0;
        $lista->utilizador_id = self::UTILIZADOR_VALIDO;

        if (!$lista->validate()) {
            var_dump($lista->getErrors());
        }

        if ($save) {
            $this->assertTrue($lista->save());
        }

        return $lista;
    }

    /* public function testSomeFeature()
    {
        Espaço para um teste extra específico se o professor pedir algo mais
    } */
}
