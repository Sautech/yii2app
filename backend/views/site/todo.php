<?php

use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\data\ActiveDataProvider;
use common\models\Category;

?>
<title>To-do application</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!--  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>-->
<<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.pjax/2.0.1/jquery.pjax.min.js"></script>-->

<div class="jumbotron text-center">
    <div class="container">
        <img src="../web/images/handysolver.png" alt="Handy Solver" style="float:left;width:70px;height:70px;">
    </div>
    <h2>To-do List Application</h2>
    <p>Where to-do items are added/deleted and belong to categories</p>
</div>
<div class="container">

    <?= $this->render('form', ['model' => $model]) ?>

    <div class="container p-3 my-3 border">
        <?php
        Pjax::begin(['id' => 'todo_pjax']);

        $dataProvider = new ActiveDataProvider([
            'query' => \common\models\Todo::find(),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'layout' => '{items} {pager}',
            'columns' => [
                [
                    'attribute' => 'name',
                    'label' => 'Todo item name'
                ],
                [
                    'attribute' => 'category_id',
                    'label' => 'Category',
                    'value' => function ($data) {
                        return Category::findOne($data->category_id)->name;
                    }
                ],

                [
                    'attribute' => 'timestamp',
                    'label' => 'Timestamp',
                    'format' => ['date', 'php:d  F']
                ],

                [

                    'label' => 'Action',
                    'format' => 'raw',
                    'value' => function ($data) {
                        return '<button type="button" class="btn btn-danger" onclick="deleteFunction(' . $data->id . ')">Delete</button>';
                    }
                ]
            ],
        ]);

        Pjax::end()
        ?>
        <script>
            function deleteFunction(id) {
                $.ajax({
                    url: "<?= \yii\helpers\Url::to(['/site/delete'])?>",
                    type: "POST",
                    data: {
                        id: id

                    },
                    success: function (result) {
                        console.log(result)
                        $.pjax.reload({container: '#todo_pjax', async: false});
                    }
                });
            }
        </script>
    </div>
</div>
