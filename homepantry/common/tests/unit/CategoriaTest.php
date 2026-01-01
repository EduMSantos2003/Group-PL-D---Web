<?php

namespace common\tests\Unit;

use common\models\Categoria;
use common\tests\UnitTester;

class CategoriaTest extends \Codeception\Test\Unit
{

    private const STRING = 'ABCDE';

    protected UnitTester $tester;

    protected function _before()
    {
//        $this->createValidCategoria(true);
    }

    // tests
    public function testValidations()
    {
        $categoria = new Categoria();
        $categoria->nome = null;

        // nome é required → deve falhar
        $this->assertFalse($categoria->validate(['nome']));

        $categoria->nome = self::STRING;

        $this->assertTrue($categoria->validate(['nome']));
    }

    public function testSaveAndRead()
    {
        $categoria = $this->createValidCategoria(false);
        $categoria->nome = 'enlatados';
        $result = $categoria->save();
        $this->assertTrue($result);

        $categoriaReadFromDatabase = Categoria::find()->where(['id' => $categoria->id])->one();
        $this->assertNotNull($categoriaReadFromDatabase);
        $this->assertEquals('enlatados', $categoriaReadFromDatabase->nome, 'The name of the category found in Database is different');
    }

    public function testSaveInvalidName()
    {
        $categoria = $this->createValidCategoria(false);
        $categoria->nome = -1;
        $categoria->save();

        $categoriaReadFromDatabase = Categoria::find()->where(['nome' => 'frescos'])->one();
        $this->assertNull($categoriaReadFromDatabase);
    }

    public function testUpdateAndRead()
    {
        $categoria = $this->createValidCategoria(true);

        $categoriaReadFromDatabase = Categoria::find()->where(['id' => $categoria->id])->one();
        $this->assertNotNull($categoriaReadFromDatabase, 'Nao foi encontrada categoria com nome fruta');
        $this->assertEquals('fruta', $categoriaReadFromDatabase->nome, 'The name of the category found in Database is different');

        $categoria->nome = 'frescos';
        $categoria->save();

        $categoriaReadFromDatabase2 = Categoria::find()->where(['id' => $categoria->id])->one();
        $this->assertEquals('frescos', $categoriaReadFromDatabase2->nome, 'The name of the category found in Database is different');
    }

    public function testDelete()
    {
        $categoria = $this->createValidCategoria(true);

        $categoriaReadFromDatabase = Categoria::find()->where(['id' => $categoria->id])->one();
        $this->assertNotNull($categoriaReadFromDatabase, 'Nao foi encontrada nenhuma categoria com nome fruta');

        $categoriaReadFromDatabase->delete();
        $categoriaReadFromDatabase2 = Categoria::find()->where(['id' => $categoria->id])->one();
        $this->assertNull($categoriaReadFromDatabase2, 'A categoria não foi apagada');
    }

    private function createValidCategoria(bool $save = false)
    {
        $categoria = new Categoria();
        $categoria->nome = 'fruta';  // <--- valor inicial

        if ($save) {
            $this->assertTrue($categoria->save());
        }
        return $categoria;
    }

    /* public function testSomeFeature()
    {
        Espaço para um teste extra específico se o professor pedir algo mais
    } */
}

