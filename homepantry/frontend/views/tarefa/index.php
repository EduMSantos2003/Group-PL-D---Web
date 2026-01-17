<?php
use yii\helpers\Html;

/** @var $tarefas common\models\Tarefa[] */

$this->title = 'As minhas tarefas';
?>

<div class="container mt-4">

    <h1 class="mb-4"><?= Html::encode($this->title) ?></h1>

    <?php if (empty($tarefas)): ?>
        <div class="alert alert-info">
            Não tens tarefas atribuídas 😊
        </div>
    <?php else: ?>

        <div class="row">
            <div class="row">
                <?php foreach ($tarefas as $tarefa): ?>
                    <div class="col-sm-6 col-md-3 mb-3">

                    <div class="card <?= $tarefa->feito ? 'border-success' : 'border-warning' ?>">
                            <div class="card-body">

                                <h5 class="card-title">
                                    <?= Html::encode($tarefa->descricao) ?>
                                </h5>

                                <p class="card-text">
                                    Estado:
                                    <?php if ($tarefa->feito): ?>
                                        <span class="badge bg-success">Concluída</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark">Pendente</span>
                                    <?php endif; ?>
                                </p>

                                <?= Html::a(
                                    $tarefa->feito ? 'Marcar como pendente' : 'Marcar como concluída',
                                    ['toggle', 'id' => $tarefa->id],
                                    [
                                        'class' => $tarefa->feito
                                            ? 'btn btn-outline-secondary btn-sm'
                                            : 'btn btn-success btn-sm'
                                    ]
                                ) ?>

                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>

    <?php endif; ?>

</div>
