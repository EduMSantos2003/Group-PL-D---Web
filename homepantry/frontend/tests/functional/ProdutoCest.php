<?php

declare(strict_types=1);

namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;
use common\fixtures\UserFixture;

final class ProdutoCest
{
    public function _fixtures(): array
    {
        return [
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'login_data.php',
            ],
        ];
    }

    private function login(FunctionalTester $I, string $username = 'admin', string $password = 'TUNTUN_123'): void
    {
        $I->amOnRoute('/site/login');
        $I->fillField('Username', $username);
        $I->fillField('Password', $password);
        $I->click('login-button');

        // Ajusta se no teu layout não aparecer exatamente assim
        $I->see('Logout');
    }

    public function createProduto(FunctionalTester $I): void
    {
        $this->login($I);

        // Cria uma categoria na BD de testes para usar no produto (evita dependência de dados existentes)
        $categoriaId = $I->haveRecord(\common\models\Categoria::class, [
            'nome' => 'Categoria Teste',
        ]);

        $I->amOnRoute('/produto/create');

        // Se categoria_id for dropdown:
        $I->selectOption('Produto[categoria_id]', (string)$categoriaId);

        $I->fillField('Produto[nome]', 'Arroz Agulha');
        $I->fillField('Produto[descricao]', 'Arroz para testes funcionais');
        $I->fillField('Produto[unidade]', '1');
        $I->fillField('Produto[preco]', '1.99');
        $I->fillField('Produto[validade]', '2026-01-20'); // YYYY-MM-DD

        /**
         * IMAGEM:
         * - Se for textInput (varchar), isto funciona:
         */
        $I->fillField('Produto[imagem]', 'teste.jpg');

        /**
         * - Se o teu form usar upload (input type="file"), então em vez do fillField usa:
         *   $I->attachFile('Produto[imagem]', 'teste.jpg');
         *   e coloca um ficheiro teste.jpg em frontend/tests/_data/teste.jpg
         */

        // Ajusta o texto do botão se for "Guardar" / "Criar" etc.
        $I->click('Guardar');

        // Confirmação
        $I->see('Arroz Agulha');
    }

    public function updateProduto(FunctionalTester $I): void
    {
        $this->login($I);

        // Cria categoria
        $categoriaId = $I->haveRecord(\common\models\Categoria::class, [
            'nome' => 'Categoria Update',
        ]);

        // Cria produto diretamente na BD (para garantir que existe um ID para editar)
        $produtoId = $I->haveRecord(\common\models\Produto::class, [
            'categoria_id' => $categoriaId,
            'nome' => 'Leite Meio-Gordo',
            'descricao' => 'Produto para editar',
            'unidade' => 1,
            'preco' => 0.89,
            'validade' => '2026-02-10',
            'imagem' => 'leite.jpg',
        ]);

        // Abre a página de update diretamente pelo ID (mais estável do que clicar em "Update" no grid)
        $I->amOnRoute('/produto/update', ['id' => $produtoId]);

        $I->fillField('Produto[nome]', 'Leite Meio-Gordo (Atualizado)');
        $I->click('Guardar');

        $I->see('Leite Meio-Gordo (Atualizado)');
    }
}
