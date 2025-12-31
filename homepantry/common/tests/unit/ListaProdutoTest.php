<?php

namespace common\tests\Unit;

use common\models\Local;
use common\tests\UnitTester;

class LocalTest extends \Codeception\Test\Unit
{

    private const STRING = 'ABCDE';

    protected UnitTester $tester;

    protected function _before()
    {
//        $this->createValidLocal(true);
    }

    // tests
    public function testValidations()
    {
        $local = new Local();

        // 1) Ambos nulos → falham
        $local->nome = null;
        $local->casa_id = null;

        $this->assertFalse($local->validate(['nome']));
        $this->assertFalse($local->validate(['casa_id']));

        // 2) nome válido, casa_id nulo → casa_id ainda falha
        $local->nome = self::STRING;
        $local->casa_id = null;

        $this->assertTrue($local->validate(['nome']));
        $this->assertFalse($local->validate(['casa_id']));

        // 3) casa_id não inteiro → falha integer
        $local->casa_id = 'abc';
        $this->assertFalse($local->validate(['casa_id']));

        // 4) casa_id inteiro mas sem Casa correspondente → falha existe
        $local->casa_id = 999999; // id que não existe
        $this->assertFalse($local->validate(['casa_id']));

        // 5) valores totalmente válidos (pressupõe Casa com id=1)
        $local->casa_id = 1;
        $this->assertTrue($local->validate(['nome']));
        $this->assertTrue($local->validate(['casa_id']));
    }


    public function testSaveAndRead()
    {
        $local = $this->createValidLocal(false);
        $local->nome = 'frigorifico';
        $result = $local->save();
        $this->assertTrue($result);

        $localReadFromDatabase = Local::find()->where(['id' => $local->id])->one();
        $this->assertNotNull($localReadFromDatabase);
        $this->assertEquals('frigorifico', $localReadFromDatabase->nome, 'The name of the local found in Database is different');
    }

    public function testSaveInvalidName()
    {
        $local = $this->createValidLocal(false);
        $local->nome = -1;
        $local->save();

        $localReadFromDatabase = Local::find()->where(['nome' => 'frigorifico'])->one();
        $this->assertNull($localReadFromDatabase);
    }

    public function testUpdateAndRead()
    {
        $local = $this->createValidLocal(true);

        $localReadFromDatabase = Local::find()->where(['id' => $local->id])->one();
        $this->assertNotNull($localReadFromDatabase, 'Nao foi encontrado local com nome frigorifico');
        $this->assertEquals('frigorifico', $localReadFromDatabase->nome, 'The name of the category found in Database is different');

        $local->nome = 'dispensa';
        $local->save();

        $localReadFromDatabase2 = Local::find()->where(['id' => $local->id])->one();
        $this->assertEquals('dispensa', $localReadFromDatabase2->nome, 'The name of the category found in Database is different');
    }

    public function testDelete()
    {
        $local = $this->createValidLocal(true);

        $localReadFromDatabase = Local::find()->where(['id' => $local->id])->one();
        $this->assertNotNull($localReadFromDatabase, 'Nao foi encontrada nenhum local com nome frigorifico');

        $localReadFromDatabase->delete();
        $localReadFromDatabase2 = Local::find()->where(['id' => $local->id])->one();
        $this->assertNull($localReadFromDatabase2, 'O local não foi apagado');
    }

    private function createValidLocal(bool $save = false)
    {
        $local = new Local();
        $local->nome = 'frigorifico';  // <--- valor inicial
        $local->casa_id = 1; // tem de existir Casa com id=1 na BD de teste

        if ($save) {
            $this->assertTrue($local->save());
        }
        return $local;
    }

    /* public function testSomeFeature()
    {
        Espaço para um teste extra específico se o professor pedir algo mais
    } */
}

