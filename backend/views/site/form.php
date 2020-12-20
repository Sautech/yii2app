<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Todo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="todo-form">

    <?php $form = ActiveForm::begin(['id'=>'add-item']); ?>
    <div class="col-sm-2">
        <?= $form->field($model, 'category_id')->dropDownList(\yii\helpers\ArrayHelper::map(\common\models\Category::find()->all(),'id', 'name' ))->label(false) ?>
    </div>
    <div class="col-sm-6">
    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label(false) ?>
    </div>
    <div class="col-sm-3">
    <div class="form-group">
        <?= Html::submitButton('Add', ['class' => 'btn btn-success']) ?>
    </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
<script>
    $(document).ready(function(event) {
        $("#add-item").submit(function(event) {
            event.preventDefault(); // stopping submitting
            var data = $(this).serializeArray();
            var url = "<?=\yii\helpers\Url::to(['/site/save'])?>";
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'json',
                data: data
            })
                .done(function(response) {
                    if (response.success == true) {
                        console.log(response.success);
                        $("#add-item").trigger("reset");
                        $.pjax.reload({container: '#todo_pjax', async: false});
                    }
                })
                .fail(function() {
                    console.log("error");
                });

        });
    })
</script>

