<?php
    namespace common\models;
    use yii\db\ActiveRecord;

    class Todo extends ActiveRecord
    {
       private $id;
       private $name;
       private $category_id;
       private $timestamp;

       public function rules(){
           return[
               [['name','category_id'],'required']
           ];
       }
    }

?>