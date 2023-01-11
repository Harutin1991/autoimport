<?php

namespace backend\controllers;

use Yii;
use backend\models\ProductImage;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\User;

/**
 * LanguageController implements the CRUD actions for Language model.
 */
class CompressController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index' => ['GET', 'POST'],
                    'view' => ['GET'],

                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => 'common\components\CAccessRule',
                ],
                'only' => ['index', 'view', 'create', 'update', 'delete'],
                'rules' => [
                    // allow authenticated users
                    [
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],
                        'allow' => true,
                        // Allow users, moderators and admins to create
                        'roles' => [
                            User::ADMIN,
                        ],
                    ],
                    // everything else is denied
                ],
            ],
        ];
    }

    /**
     * Lists all Language models.
     * @return mixed
     */
    public function actionImages($start = 0, $end = 1000)
    {
         $model = new ProductImage();
        $images = $model->find()->where(['compresed' => null, 'thumbCompress'=>null])->all();
        $directory = Yii::getAlias("@backend/web/uploads/images");
        $directoryThumb = Yii::getAlias("@backend/web/uploads/images/thumbnail");
  
        foreach($images as $key=>$image) {
            $filePath = $directory . '/' . $image->name;
            $filePathThumb = $directoryThumb . '/' . $image->name;
            $this->compressImage($filePath , $filePath, 60);
            $this->compressImage($filePathThumb , $filePathThumb, 60);
            $image->compresed = 1;
            $image->thumbCompress = 1;
            $image->save();
            echo $image->id; echo "<br>";
        }
       die;
    }

   public function compressImage($source, $destination, $quality) {

            $info = getimagesize($source);

            if ($info['mime'] == 'image/jpeg') 
                $image = imagecreatefromjpeg($source);

            elseif ($info['mime'] == 'image/gif') 
                $image = imagecreatefromgif($source);

            elseif ($info['mime'] == 'image/png') 
                $image = imagecreatefrompng($source);

            imagejpeg($image, $destination, $quality);

        }

    
}
