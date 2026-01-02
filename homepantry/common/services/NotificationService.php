<?php

namespace common\services;

use common\models\Casa;
use common\models\Lista;
use common\models\StockProduto;
use Yii;

class NotificationService
{
    public static function getRecent($limit = 6)
    {
        $items = [];

        /* ==========================
         *  Casas criadas
         * ========================== */
        foreach (
            Casa::find()
                ->orderBy(['dataCriacao' => SORT_DESC])
                ->limit($limit)
                ->all() as $casa
        ) {
            $items[] = [
                'label' => 'Nova casa criada: ' . $casa->nome,
                'icon'  => 'home',
                'url'   => ['/casa/view', 'id' => $casa->id],
                'date'  => $casa->dataCriacao,
                'type'  => 'recent',
            ];
        }

        /* ==========================
         *  Listas de compras criadas
         * ========================== */
        foreach (
            Lista::find()
                ->orderBy(['dataCriacao' => SORT_DESC])
                ->limit($limit)
                ->all() as $lista
        ) {
            $items[] = [
                'label' => 'Nova lista criada: ' . $lista->nome,
                'icon'  => 'shopping-cart',
                'url' => 'http://localhost/Group-PL-D---Web/homepantry/frontend/web/index.php?r=lista/view&id=' . $lista->id,
                'date'  => $lista->dataCriacao,
                'type'  => 'recent',
            ];
        }

        /* ==========================
         *  Produtos adicionados à despensa
         * ========================== */
        foreach (
            StockProduto::find()
                ->orderBy(['dataCriacao' => SORT_DESC])
                ->limit($limit)
                ->all() as $stock
        ) {
            if (!$stock->produto) {
                continue;
            }

            $items[] = [
                'label' => 'Produto adicionado: ' . $stock->produto->nome,
                'icon'  => 'box',
                'url' => 'http://localhost/Group-PL-D---Web/homepantry/frontend/web/index.php?r=stock-produto/view&id=' . $stock->id,
                'date'  => $stock->dataCriacao,
                'type'  => 'recent',
            ];
        }

        /* ==========================
         *  Produtos a expirar
         * ========================== */
        $diasAviso = 5;
        $hoje = date('Y-m-d');
        $limite = date('Y-m-d', strtotime("+{$diasAviso} days"));

        foreach (
            StockProduto::find()
                ->where(['between', 'validade', $hoje, $limite])
                ->orderBy(['validade' => SORT_ASC])
                ->all() as $stock
        ) {
            if (!$stock->produto) {
                continue;
            }

            $items[] = [
                'label' => 'Produto a expirar: ' . $stock->produto->nome,
                'icon'  => 'exclamation-triangle',
                'url'   => ['/stock-produto/view', 'id' => $stock->id],
                'date'  => $stock->validade,
                'type'  => 'warning',
            ];
        }

        /* ==========================
         * 🔽 Ordenar tudo por data
         * ========================== */
        usort($items, fn($a, $b) =>
            strtotime($b['date']) <=> strtotime($a['date'])
        );

        return array_slice($items, 0, $limit);
    }
}
