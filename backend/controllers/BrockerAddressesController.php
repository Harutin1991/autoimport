<?php

namespace backend\controllers;

use Yii;
use backend\models\BrockerAddresses;
use backend\models\BrockerAddressesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Product;

/**
 * BrockerAddressesController implements the CRUD actions for BrockerAddresses model.
 */
class BrockerAddressesController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all BrockerAddresses models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BrockerAddressesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	
	public function actionMyAddresses() {
		$searchModel = new BrockerAddressesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,Yii::$app->user->identity->id);
		return $this->render('my-address', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
	}
	
	public function actionFixAddress() {
		$model = new BrockerAddresses();
		$product = [];
        if ($model->load(Yii::$app->request->post())) {
			$product = Product::find()->where([
		'address'=>Yii::$app->request->post('BrockerAddresses')['address'],
		'addr_1'=>Yii::$app->request->post('addr_part_1'),
		'addr_2'=>Yii::$app->request->post('addr_part_2')])->one();
			if(empty($product)){
				$model->status = 1;
				if($model->save()){
					return $this->redirect('/brocker-addresses/my-addresses');
				} 
			}
        } 

        return $this->render('fix-address', [
            'model' => $model,
            'product' => $product,
        ]);
	}
	
	public function actionSaveBrokerAddress() {
		if (Yii::$app->request->isAjax) {
			$model = new BrockerAddresses();
            $data = Yii::$app->request->post();
			$model->brocker_id = $data['broker'];
			$model->address = $data['address'];
			$model->status = 1;
			if($model->save()){
				 echo json_encode(['success'=>true,'message'=>Yii::t('app','Successfuly Saved')]); exit();
			} else {
				echo json_encode(['success'=>false,'message'=>Yii::t('app','Entry Exist')]); exit();
			}
		}
	}
	
    /**
     * Displays a single BrockerAddresses model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new BrockerAddresses model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BrockerAddresses();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing BrockerAddresses model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			if(Yii::$app->user->identity->role) {
				return $this->redirect('/brocker-addresses/my-addresses');
			}
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing BrockerAddresses model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the BrockerAddresses model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BrockerAddresses the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BrockerAddresses::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
