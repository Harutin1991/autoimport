<?php

namespace app\components;

use yii\base\Component;

class UserComponent extends Component{

    public static function getUserImage($id,$original=false){

        $base = '/template/admin/uploads/users/';
        return $base.(($original) ? $id : 'small_'.$id) . '.jpg';
    }

    public static function getGeneralImage($id,$general=true)
    {
        $base = \Yii::$app->params['baseUrl'].'/template/uploads/articles/'.$id.'/';
        
        return $base.(($general) ? 'general' : 'small_'.$id).'.jpg';
    }
}