<?php
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\data\ActiveDataProvider;
use common\models\Category;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>To-do application</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.pjax/2.0.1/jquery.pjax.min.js"></script>
</head>
<body>
<div>
<div class="jumbotron text-center">
<div class="container">
<img src="../web/images/handysolver.png" alt="Handy Solver" style="float:left;width:70px;height:70px;">
  </div>
  <h3>To-do List Application</h3>
  <p>Where to-do items are added/deleted and belong to categories</p> 
</div>
  
<div class="container">
  <div class="row">
    <div class="col-sm-2">
    <div class="form-group">
  <select id="category_id" class="form-control">
  <?php 
    $categories=\common\models\Category::find()->all();
    foreach($categories as $category)
    {
      ?>
        <option  value="<?php echo $category->id ?>" > <?php echo $category->name ?> </option>

      <?php
    }
  ?>
  </select>
</div>
    </div>
    <div class="col-sm-6">
    <div class="form-group">
  <input type="text" class="form-control" id="item_name">
</div>
    </div>
    <div class="col-sm-4">
    <button type="button" class="btn btn-success" onclick="saveFunction()"> Add </button>
    </div>
  </div>
</div>
<div class="container p-3 my-3 border">
<?php Pjax::begin(['id' => 'todo_pjax']) ?>
<?php 

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
    //['class' => 'yii\grid\SerialColumn'],
    // Simple columns defined by the data contained in $dataProvider.
    // Data from the model's column will be used.
    [
      'attribute' => 'name',
      'label' => 'Todo item name'
    ],
    [
      'attribute' => 'category_id',
      'label' => 'Category',
      'value' => function($data){
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
      'value' =>function($data){
        return '<button type="button" class="btn btn-danger" onclick="deleteFunction('.$data->id.')">Delete</button>';
      }
    ],

    // More complex one.
    //[
     //   'class' => 'yii\grid\DataColumn', // can be omitted, as it is the default
     //   'value' => function ($data) {
     //       return $data->name; // $data['name'] for array data, e.g. using SqlDataProvider.
   //     },
],
]);

  ?>

<?php Pjax::end() ?>
<script>
function deleteFunction(id) {
  $.ajax({
    
    url: "/todo/backend/web/index.php?r=site%2Fdelete",
    type: "POST",
    data: {
      id:id

    },
    
    success: function(result){
    $.pjax.defaults.timeout = false; 
    $.pjax.reload({container: '#todo_pjax', async: false});
    console.log(result);
  }});



  
}

function saveFunction() {

  console.log($('#category_id').val());
  console.log($('#item_name').val());
  $.ajax({
    
    url: "/todo/backend/web/index.php?r=site%2Fsave",
    type: "POST",
    data: {
      name:$('#item_name').val(),
      category_id:$('#category_id').val()

    },
    
    success: function(result){
    $.pjax.defaults.timeout = false; 
    $.pjax.reload({container: '#todo_pjax', async: false});
    console.log(result);
  }});
}


</script>
</div>
</div>
</body>
</html>
