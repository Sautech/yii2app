<?php
    namespace common\models;
    use yii\db\ActiveRecord;

    class Category extends ActiveRecord
    {
       private $id;
       private $name;

       public function rules(){
           return[
               [['name'],'required']
           ];
       }
    }

?>