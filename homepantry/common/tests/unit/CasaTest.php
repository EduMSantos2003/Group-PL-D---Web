<?php
namespace common\tests\Unit;

use common\models\Casa;
use common\tests\UnitTester;

class CasaTest extends \Codeception\Test\Unit
{
    private const STRING = 'ABCDE';
    private const DATETIME = '2025-12-31 23:59:59';
//    private const INTEGER  = 2;

    protected UnitTester $tester;

    protected function _before()
    {
//        $this->createValidCasa(true);
    }

    // tests
    public function testValidations()
    {
        $casa = new Casa();
        $casa->nome = null;
        $casa->dataCriacao = null;
        $casa->utilizadorPrincipal_id = null;

        // nome é required → deve falhar
        $this->assertFalse($casa->validate(['nome']));
        // dataCriacao NÃO é required (só safe) → deve passar
        $this->assertTrue($casa->validate(['dataCriacao']));
        // utilizadorPrincipal_id é required → deve falhar
        $this->assertFalse($casa->validate(['utilizadorPrincipal_id']));

        $this -> assertFalse($casa -> validate(['nome']));
        $this -> assertTrue($casa -> validate(['dataCriacao']));
        $this -> assertFalse($casa -> validate(['utilizadorPrincipal_id']));

        $casa->nome = self::STRING;
        $casa->dataCriacao = self::DATETIME;
        $casa->utilizadorPrincipal_id = 1;

        $this->assertTrue($casa -> validate(['nome']));
        $this->assertTrue($casa -> validate(['dataCriacao']));
        $this->assertTrue($casa -> validate(['utilizadorPrincipal_id']));
    }

    public function testSaveAndRead()
    {
        $casa = $this->createValidCasa(false);
        $casa-> nome = 'partyHouse';
        $result = $casa->save();
        $this->assertTrue($result);

        $casaReadFromDatabase = Casa::find()->where(['id' => $casa->id])->one();
        $this->assertNotNull($casaReadFromDatabase);
        $this->assertEquals('partyHouse', $casaReadFromDatabase->nome, 'The name of the house found in Database is different');
    }

    public function testSaveInvalidName()
    {
        $casa = $this->createValidCasa(false);
        $casa -> nome = -1;
        $casa -> save();

        $casaReadFromDatabase = Casa::find()->where(['nome' => 'casaSerrana'])->one();
        $this->assertNull($casaReadFromDatabase);
    }

    public function testUpdateAndRead(){
        $casa = $this->createValidCasa(true);

        $casaReadFromDatabase = Casa::find()->where(['id' => $casa->id])->one();
        $this->assertNotNull($casaReadFromDatabase, 'Nao foi encontrada casa com nome casaSerrana');
        $this->assertEquals('casaSerrana', $casaReadFromDatabase->nome, 'The name of the house found in Database is different' );

        $casa->nome = 'casaPiscina';
        $casa->save();

        $casaReadFromDatabase2 = Casa::find()->where(['id' => $casa->id])->one();
        $this->assertEquals('casaPiscina', $casaReadFromDatabase2->nome, 'The name of the house found in Database is different' );
    }

    public function testDelete()
    {
        $casa = $this->createValidCasa(true);

        $casaReadFromDatabase = Casa::find()->where(['id' => $casa->id])->one();
        $this->assertNotNull($casaReadFromDatabase, 'Nao foi encontrada uma casa com nome partyHouse');

        $casaReadFromDatabase -> delete();
        $casaReadFromDatabase2 = Casa::find()->where(['id' => $casa->id])->one();
        $this->assertNull($casaReadFromDatabase2, 'A casa não foi apagada');
    }

    private function createValidCasa(bool $save = false)
    {
        $casa = new Casa();
        $casa->nome = 'casaSerrana';
        $casa->utilizadorPrincipal_id = 1; // precisa existir user 1

        if ($save) {
            $this->assertTrue($casa->save());
        }
        return $casa;
    }

    /* public function testSomeFeature()
    {
        Espaço para um teste extra específico se o professor pedir algo mais
    } */
}
