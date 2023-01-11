<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use \backend\models\LoginForm;
use backend\models\User;
use yii\data\ActiveDataProvider;
use backend\models\Sitesettings;
use backend\models\Homepage;
use backend\models\SocialNet;
use backend\models\Delivery;

/**
 * Site controller
 */
class SiteController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                        [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                        [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex() {
        $model = User::findOne(1);
        $dataProvider = new ActiveDataProvider([
            'query' => User::find()->where(['id' => 1]),
        ]);
        $dataProviderSettings = new ActiveDataProvider([
            'query' => Sitesettings::find(),
        ]);
        $dataProviderSocialNet = new ActiveDataProvider([
            'query' => SocialNet::find(),
        ]);
		$dataProviderHome = new ActiveDataProvider([
            'query' => Homepage::find(),
        ]);
        return $this->render('index', [
							'model' => $model, 
							'dataProvider' => $dataProvider,
							'dataProviderSocialNet' => $dataProviderSocialNet,
							'dataProviderHome' => $dataProviderHome,
							'dataProviderSettings'=>$dataProviderSettings
							]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin() {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
			if(Yii::$app->user->identity->role) {
				if(Yii::$app->user->identity->user_number == 101) {
					return $this->redirect('/product/index?Product%5Bsub_category%5D=0&Product%5Bstatus%5D=1&ProductAddress%5Bstate%5D=232&ProductAddress%5Bcity%5D=&ProductAddress%5Baddress%5D=&addr_1=&addr_2=&Attribute%5Bpath%5D=&Attribute%5Bname%5D=&Attribute%5Bcategory_id%5D=&floor-from=0&floor-to=0&size-from=0&size-to=0&price-from=0&price-to=0&Product%5Bbroker_id%5D=&product_sku=&appartment-number-show=0&land-size-from=0&land-size-to=0');
				} else {
					return $this->redirect('/product/index?Product%5Bsub_category%5D=1&Product%5Bstatus%5D=1&ProductAddress%5Bstate%5D=232&ProductAddress%5Bcity%5D=&ProductAddress%5Baddress%5D=&addr_1=&addr_2=&Attribute%5Bpath%5D=&Attribute%5Bname%5D=&Attribute%5Bcategory_id%5D=&floor-from=0&floor-to=0&size-from=0&size-to=0&price-from=0&price-to=0&Product%5Bbroker_id%5D=&product_sku=&appartment-number-show=0&land-size-from=0&land-size-to=0');
				}
			}
            return $this->goBack();
        } else {
            return $this->renderPartial('login', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

}
