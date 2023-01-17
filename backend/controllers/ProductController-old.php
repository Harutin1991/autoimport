<?php

namespace backend\controllers;

use backend\models\Attribute;
use backend\models\Cities;
use backend\models\States;
use backend\models\ProductsDetails;
use backend\models\Category;
use backend\models\ProductAttribute;
use backend\models\ProductAttributeSearch;
use backend\models\ProductImage;
use backend\models\ConnectedProducts;
use Yii;
use backend\models\TrProduct;
use backend\models\Product;
use backend\models\ProductSearch;
use backend\models\ProductsFilters;
use yii\base\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\imagine\Image;
use yii\helpers\BaseFileHelper;
use yii\filters\AccessControl;
use backend\models\User;
use common\models\Language;
use common\components\RuleHelper;
use backend\models\ProductAddress;
use backend\models\Address;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index' => ['GET', 'POST'],
                    'view' => ['GET'],
                    'create' => ['GET', 'POST'],
                    'update' => ['GET', 'POST'],
                    'delete' => ['POST'],
                    'fix-new-product' => ['GET', 'POST']
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
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex() {

		$defaultLanguage = Language::find()->where(['is_default' => 1])->one();
        $parentAttributes = Attribute::find()->where(['parent_id' => NUll])->asArray()->all();
        $childAttributes = Attribute::find()->where('parent_id IS NOT NULL')->asArray()->all();
        $attributes = [];

        foreach ($parentAttributes as $v) {

            $childAttr = array_filter(
                $childAttributes,
                function ($e) use ($v) {
                    return $e['parent_id'] == $v['id'];
                }
            );

            $attributes[$v['id']] = ['id' => $v['id'], 'name' => $v['name'], 'childAttributes' => $childAttr];
        }
		
	 	if(empty(Yii::$app->request->queryParams)) {
			$searchModel = new ProductSearch();
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams, true);
			
			return $this->render('index-empty', [
                    'attributes' => $attributes,
					'dataProvider' => $dataProvider,
                    'defoultId' => $defaultLanguage->id
			]);
		} else { 
			$searchModel = new ProductSearch();
			$model = new Product();
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
			
			return $this->render('index', [
						'searchModel' => $searchModel,
						'attributes' => $attributes,
						'dataProvider' => $dataProvider,
						'model' => $model,
						'defoultId' => $defaultLanguage->id
			]);
		}
        
    }

    /**
     * Lists all Brand models.
     * @return mixed
     */
    public function actionGetform() {
        $model = new Product();
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if (Yii::$app->request->isAjax) {
            $id = Yii::$app->request->post('id');
            $model = $this->findModel($id);
            $attributes = ProductAttribute::find()->where(['product_id' => $id])->all();
            echo $_form = $this->renderAjax('_form', [
        'model' => $model,
        'categories' => $model->getAllCategories(),
        'attributes' => $attributes
            ]);
            exit();
        }

        $_form = $this->renderPartial('_form', [
            'model' => $model,
            'categories' => $model->getAllCategories(),
            'attributes' => $attributes
        ]);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    '_Form' => $_form
        ]);
    }

    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $model = $this->findModel($id);

        $connProductsAll = ConnectedProducts::find()->where(['product_id' => $id])->asArray()->all();
        $connProducts = [];
        foreach ($connProductsAll as $productID) {
            $connProducts[$productID['product_id']][] = $productID['conn_product_id'];
        }
        $productAttr = ProductAttribute::find()->where(['product_id' => $id])->asArray()->all();
        $productDetails = ProductsDetails::find()->where(['product_id' => $id])->asArray()->all();

        $connection = Yii::$app->getDb();
        $command = $connection->createCommand("
                SELECT pf.product_id, pf.value,
                (SELECT a.name FROM attribute a WHERE pf.attribute_id = a.id ) as attribute,
                (SELECT a.name FROM attribute a WHERE pf.filter_id = a.id ) as filter
            FROM products_filters pf WHERE pf.product_id = :product_id
        ", [':product_id' => $model->id]);

        $filters = $command->queryAll();

        return $this->render('view', [
            'model' => $model,
            'productDetails' => $productDetails,
            'productAttr' => $productAttr,
            'connProducts' => $connProducts,
            'filters' => $filters,
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $defaultLanguage = Language::find()->where(['is_default' => 1])->one();
        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();
			//echo "<pre>";print_r($post);die;
            /* if ($post['Product']['in_slider']) {
              $post['Product']['in_slider'] = (int)$post['Product']['in_slider'];
              } */
            /* if ($post['Product']['commercial'] == 1) {
              Product::updateAll(['commercial'=> 0],['commercial'=> 1]);
              } */
            /* if ($post['Product']['popular'] == 1) {
              Product::updateAll(['popular'=> 0],['popular'=> 1]);
              } */
            $product = Product::find()->where(['product_sku' => $post['Product']['product_sku']])->asArray()->one();

            if($product) {
                $products = $productsCount = Product::find()->asArray()->all();
                $model = new Product();
                $model->load($post);
                $detailsModel = new ProductsDetails();
                return $this->render('create', [
                    'model' => $model,
                    'products' => $products,
                    'detailsModel' => $detailsModel,
                    'defoultId' => $defaultLanguage->id,
                    'categories' => $model->getAllCategories(),
                ]);
            }
            $model = new Product();
            $product_image_model = new ProductImage();
            $product_attribute_model = new ProductAttribute();
            $ProductsDetails_model = new ProductsDetails();
            // $product_filters = new ProductsFilters();
            $ProdDefImg = Yii::$app->request->post('defaultImage');
            $ProductAttributeItems = Yii::$app->request->post('ProductAttribute');
            $ProductAddress = Yii::$app->request->post('ProductAddress');
            $sub_attr_id = Yii::$app->request->post('sub_attr_id');
            $ProductsDetails = Yii::$app->request->post('ProductsDetails');
            $connectProductPost = Yii::$app->request->post('connectProduct');

            $model->load($post);
            $order = Product::find()// AQ instance
                    ->select('max(ordering)')// we need only one column
                    ->scalar();
            $model->ordering = $order ? $order + 1 : 1;
            $model->rate = 0;

			$address = Address::find()->where(['address' => $post['Product']['address'], 'city_id' => $post['ProductAddress']['city_id']])->asArray()->one();

			if(!$address) {
			    $a = new Address();
			    $a->address = $post['Product']['address'];
			    $a->city_id = $post['ProductAddress']['city_id'];
			    $a->save();

			    $address_id = (int) $a->getPrimaryKey();
            } else {
                $address_id = (int) $address['id'];
            }

            $model->address = $post['Product']['address'];

            $state = States::findOne($post['ProductAddress']['state_id']);
            $model->state = $state->name;

            $city = Cities::findOne($post['ProductAddress']['city_id']);
            $model->city = $city->name;
			
			if(!isset($post['Product']['is_allow_to_show'])) {
				$model->is_allow_to_show = 0;
			}

            if ($model->save()) {

                $category = Category::findOne($model->category_id);
                RuleHelper::setFile("product-routes.json");
                RuleHelper::setPath(Yii::$app->basePath . "/../frontend/config");
                RuleHelper::makeRule($category->route_name . '/' . $model->route_name, "product/view", $model->id);

                if (!empty($connectProductPost)) {
                    foreach ($connectProductPost as $conProduct) {
                        $connectProduct = new ConnectedProducts();
                        $connectProduct->product_id = $model->id;
                        $connectProduct->conn_product_id = $conProduct;
                        $connectProduct->save();
                    }
                }
				if(!empty($ProductAddress)) {
					$addressPlace = new ProductAddress();
					$addressPlace->state_id = $ProductAddress['state_id'];
					$addressPlace->city_id = $ProductAddress['city_id'];
					$addressPlace->address_id = $address_id;
					$addressPlace->product_id = $model->id;
					$addressPlace->save();
				}
                if (!empty($sub_attr_id)) {
                    $attrs = [4, 38, 3, 2, 1, 14];
                    $ids = [];
                    $attrsToEdit = [];


                    foreach ($sub_attr_id as $key => $filters) {
                        $product_filters = new ProductsFilters();
                        $product_filters->product_id = $model->id;
                        if (isset($filters['value'])) {
                            $product_filters->value = $filters['value'];
                        } else {
                            $product_filters->value = $filters['option'];
                        }

                        $filter_id = isset($filters['option']) ? $filters['option'] : null;

                        if(in_array($key, $attrs)) {
                            if($key == 3 || $key == 4 || $key == 38) {
                                $attrsToEdit[$key] = $filters['value'];
                            } else {
                                $ids[] = $filter_id;
                            }
                        }

                        $product_filters->filter_id = $filter_id;
                        $product_filters->attribute_id = $key;
                        $product_filters->save();
                    }

                    $attributes = Attribute::find()->where(['in', 'id', $ids])->asArray()->all();
                    foreach ($attributes as $k => $v) {
                        $attrsToEdit[$v['parent_id']] = $v['name'];
                    }

                    $model->json_attr = json_encode($attrsToEdit);
                    $model->save();
                }

                $objLang = new Language();
                $languages = $objLang->find()->asArray()->all();
                foreach ($languages as $value) {
                    $product = new TrProduct();
                    $product->name = $model->name;
                    $product->short_description = $model->short_description;
                    $product->description = $model->description;
                    $product->product_id = $model->id;
                    $product->language_id = $value['id'];
                    $product->save();
                }


                if (!empty($ProductAttributeItems)) {
                    foreach ($ProductAttributeItems as $key => $value) {
                        $product_attribute_model->saveData($value, $model->id);
                    }
                }

                if (!empty($ProductsDetails['name'])) {
                    $ProductsDetails_model->saveData($ProductsDetails['name'], $model->id);
                }
                $images = UploadedFile::getInstances($model, 'imageFiles');
                $paths = $this->upload($images, $model->id);
                $product_image_model->multiSave($paths, $model->id, $ProdDefImg, 1);

                Yii::$app->session->setFlash('success', 'Product successfully created');
                return $this->redirect(['product/update',
                            'id' => $model->id,
                            'defoultId' => $defaultLanguage->id,
                ]);
            } else {
                Yii::$app->session->setFlash('error', 'Somthing want wrong');
                $products = $productsCount = Product::find()->asArray()->all();
                $detailsModel = new ProductsDetails();
                return $this->render('create', [
                            'model' => $model,
                            'defoultId' => $defaultLanguage->id,
                            'products' => $products,
                            'detailsModel' => $detailsModel,
                            'categories' => $model->getAllCategories(),
                ]);
            }
        } else {
            $products = $productsCount = Product::find()->asArray()->all();
            $model = new Product();
            $detailsModel = new ProductsDetails();
            return $this->render('create', [
                        'model' => $model,
                        'products' => $products,
                        'detailsModel' => $detailsModel,
                        'defoultId' => $defaultLanguage->id,
                        'categories' => $model->getAllCategories(),
            ]);
        }
    }


    public function actionFixNewProduct() {
        if (Yii::$app->request->isAjax) {
            $model = new Product();

            $state = Yii::$app->request->post('state');
            $road = Yii::$app->request->post('road');
            $addr_1 = Yii::$app->request->post('building_number');
            $addr_2 = Yii::$app->request->post('app_number');
            $mobile = Yii::$app->request->post('mobile');
            $source = Yii::$app->request->post('source');
            $buyer = Yii::$app->request->post('buyer');
            $price = Yii::$app->request->post('price');
            //$level = Yii::$app->request->post('level');
            //$room = Yii::$app->request->post('room');


            $model->state = 'Երևան';

            $city = Cities::findOne($state);
            $model->city = $city->name;
            $model->rate = 0;

            $address = Address::findOne($road);
            $model->address = $address->address;
            $model->addr_1 = $addr_1;
            $model->addr_2 = $addr_2;
            $model->phone1 = $mobile;
            $model->source = $source;
            $model->price = $price;
            $model->client_name = $buyer; 
            $model->status = 1;
            $model->forbid = 1;

            if($model->save(false)) {

                $addressPlace = new ProductAddress();
                $addressPlace->state_id = 232;
                $addressPlace->city_id = $state;
                $addressPlace->address_id = $road;
                $addressPlace->product_id = $model->id;
                $addressPlace->save();

                echo json_encode(['success' => true]);

            } else {
                echo json_encode(['success' => false]);

            };
            exit();
        }
    }
    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $product_image_model = new ProductImage();
        $product_attribute_model = new ProductAttribute();
        $ProdDefImg = Yii::$app->request->post('defaultImage');
        $ProductAttributeItems = Yii::$app->request->post('ProductAttribute');
        $ProductsDetails = Yii::$app->request->post('ProductsDetails');
        $ProductAddress = Yii::$app->request->post('ProductAddress');
        $sub_attr_id = Yii::$app->request->post('sub_attr_id');
        $ProductsDetails_model = new ProductsDetails();
        if (Yii::$app->request->post()) {
            $oldRouteName = $model->route_name;
            $post = Yii::$app->request->post();
            $model->load($post);

            $address = Address::find()->where(['address' => $post['Product']['address'], 'city_id' => $post['ProductAddress']['city_id']])->asArray()->one();

            if(!$address) {
                $a = new Address();
                $a->address = $post['Product']['address'];
                $a->city_id = $post['ProductAddress']['city_id'];
                $a->save();

                $address_id = (int) $a->getPrimaryKey();
            } else {
                $address_id = (int) $address['id'];
            }

            $model->address = $post['Product']['address'];

            $state = States::findOne($post['ProductAddress']['state_id']);
            $model->state = $state->name;

            $city = Cities::findOne($post['ProductAddress']['city_id']);
            $model->city = $city->name;
            $model->updated_date = new \yii\db\Expression('NOW()');
			
			if (strpos($model->product_sku, 'Դ-') !== false) {
				$model->product_sku = str_replace('Դ-','',$model->product_sku);
			}
			if (strpos($model->product_sku, 'Վ-') !== false) {
				$model->product_sku = str_replace('Վ-','',$model->product_sku);
			}
			if (strpos($model->product_sku, 'X-') !== false) {
				$model->product_sku = str_replace('X-','',$model->product_sku);
			}
			
			if(!$model->status) {
				$model->product_sku = 'Դ-'.$model->product_sku;
				
			} elseif($model->status == 2){
				$model->product_sku = 'Վ-'.$model->product_sku;
			}elseif($model->status == 3){
				$model->product_sku = 'X-'.$model->product_sku;
			} 
			
			if (!isset($post['Product']['is_allow_to_show'])) {
				$model->is_allow_to_show = 0;
			} else {
				$model->is_allow_to_show = 1;
			}
			
			$model->forbid = 0;
            if ($model->save()) {
                $category = Category::findOne($model->category_id);
                RuleHelper::setFile("product-routes.json");
                RuleHelper::setPath(Yii::$app->basePath . "/../frontend/config");
                RuleHelper::updateRule($category->route_name . '/' . $model->route_name, "product/view", $model->id, $oldRouteName);
                if (!empty($sub_attr_id)) {
                    $filters = ProductsFilters::getDb()->createCommand()->
                            delete(ProductsFilters::tableName(), ['product_id' => $model->id])
                            ->execute();

                    $attrs = [4, 38, 3, 2, 1, 14];
                    $ids = [];
                    $attrsToEdit = [];

                    foreach ($sub_attr_id as $key => $filters) {
                        $product_filters = new ProductsFilters();
                        $product_filters->product_id = $model->id;

                        if (isset($filters['value'])) {
                            $product_filters->value = $filters['value'];
                        } else {
                            $product_filters->value = $filters['option'];
                        }
                        $filter_id = isset($filters['option']) ? $filters['option'] : null;

                        if(in_array($key, $attrs)) {
                            if($key == 3 || $key == 4 || $key == 38) {
                                $attrsToEdit[$key] = $filters['value'];
                            } else {
                                $ids[] = $filter_id;
                            }
                        }
                        // 4 - hark, 38 - harkayunutyun, 3 - makeres, 2 - senyakner, 1 - tip, 14 - vichak,
                        $product_filters->filter_id = $filter_id;
                        $product_filters->attribute_id = $key;
                        $product_filters->save();
                    }

                    $attributes = Attribute::find()->where(['in', 'id', $ids])->asArray()->all();
                    foreach ($attributes as $k => $v) {
                        $attrsToEdit[$v['parent_id']] = $v['name'];
                    }
                    $model->json_attr = json_encode($attrsToEdit);
                    $model->save();
                    
                }
				
				if(!empty($ProductAddress)) {
					$addressPlace = ProductAddress::findOne(['product_id'=>$model->id]);
					if(!$addressPlace) {
						$addressPlace = new ProductAddress();
					}
					$addressPlace->state_id = $ProductAddress['state_id'];
					$addressPlace->city_id = $ProductAddress['city_id'];
					$addressPlace->address_id = $address_id;
					$addressPlace->product_id = $model->id;
					$addressPlace->save();
				}

                $objLang = new Language();
                $languages = $objLang->find()->asArray()->all();
                foreach ($languages as $value) {
                    $trproduct = TrProduct::find()->where(['product_id' => $model->id, 'language_id' => $value['id']])->one();
					if(!$trproduct) {
						$trproduct = new TrProduct();
					}
                    $trproduct->name = $model->name;
                    $trproduct->short_description = $model->short_description;
                    $trproduct->description = $model->description;
                    $trproduct->save();
                }


                if (!empty($ProductAttributeItems)) {
                    foreach ($ProductAttributeItems as $key => $value) {
                        $product_attribute_model->saveData($ProductAttributeItems['value'], $model->id);
                    }
                }
                $detailsResult = [];
                if (isset($ProductsDetails['old_name']) && !empty($ProductsDetails['old_name'])) {
                    if (!empty($ProductsDetails['name'])) {
                        $detailsResult = array_merge_recursive($ProductsDetails['name'], $ProductsDetails['old_name']);
                    } else {
                        $detailsResult = $ProductsDetails['name'];
                    }
                    $ProductsDetails_model->saveData($detailsResult, $model->id);
                } elseif (!empty($ProductsDetails['name'])) {
                    $ProductsDetails_model->saveData($ProductsDetails['name'], $model->id);
                }

                $images = UploadedFile::getInstances($model, 'imageFiles');
                $paths = $this->upload($images, $model->id);
                $product_image_model->multiSave($paths, $model->id, '', 1);
                $model->updateDefaultTranslate();
                Yii::$app->session->setFlash('success', Yii::t('app', 'Product successfully updated'));
                return $this->redirect(['product/update',
                            'id' => $model->id,
                ]);
            } else {
                $products = Product::find()->where(['!=', 'id', $id])->asArray()->all();
                $connProducts = ConnectedProducts::find()->where(['product_id', $id])->asArray()->all();
                $detailsModel = new ProductsDetails();
                $productDetails = ProductsDetails::find()->where(['product_id' => $id])->asArray()->all();
                $addressPlace = ProductAddress::findOne(['product_id'=>$model->id]);

                return $this->render('update', [
                            'model' => $model,
                            'addressPlace' => $addressPlace,
                            'products' => $products,
                            'detailsModel' => $detailsModel,
                            'connProducts' => $connProducts,
                            'productDetails' => $productDetails,
                            'categories' => $model->getAllCategories(),
                            'product_attribute_model' => $product_attribute_model,
                ]);
            }
        } else {
            $products = Product::find()->where(['!=', 'id', $id])->asArray()->all();
            $connProductsAll = ConnectedProducts::find()->where(['product_id' => $id])->asArray()->all();
            $connProducts = [];
            foreach ($connProductsAll as $productID) {
                $connProducts[$productID['product_id']][] = $productID['conn_product_id'];
            }
            $productAttr = ProductAttribute::find()->where(['product_id' => $id])->asArray()->all();
            $detailsModel = new ProductsDetails();
            $productDetails = ProductsDetails::find()->where(['product_id' => $id])->asArray()->all();
            return $this->render('update', [
                        'model' => $model,
                        'products' => $products,
                        'detailsModel' => $detailsModel,
                        'productDetails' => $productDetails,
                        'productAttr' => $productAttr,
                        'connProducts' => $connProducts,
                        'categories' => $model->getAllCategories(),
                        'product_attribute_model' => $product_attribute_model,
            ]);
        }
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $Product = $this->findModel($id);
        if ($Product) {
            if ($Product->DeleteData($id)) {
                return $this->redirect(['index']);
            }
        }
    }

    public function actionRemoveDetails() {
        $details_id = Yii::$app->request->post('details_id');
        $detail = ProductsDetails::findOne($details_id);
        if ($detail) {
            $detail->delete();
            echo json_encode(['success' => true]);
            exit();
        } else {
            echo json_encode(['success' => false]);
            exit();
        }
    }

    public function actionDeleteByAjax() {
        if (Yii::$app->request->isAjax) {
            $product_ids = Yii::$app->request->post('ids');
            try {
                $forinkeys = [];
                $allow = true;
                foreach ($product_ids as $id) {
                    $model = Product::findOne($id);
                    $model->DeleteData();
                }
                if ($allow) {
                    echo true;
                    exit();
                }
                print_r(json_encode($forinkeys));
                exit();
            } catch (\mysqli_sql_exception $e) {
                Yii::$app->session->setFlash('error', 'you are not deleted');
                echo json_encode(['deleted' => 'error']);
                exit();
            }
        }
    }

    public function actionChangestatus() {
        if (Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post('data');
            $data = json_decode($post);
            $model = $this->findModel($data->id);
            $model->status = $data->status;
            if ($model->update()) {
                echo 'true';
                exit();
            } else {
                echo 'false';
                exit();
            }
        }
    }

    public function actionChangeitemsstatus() {
        if (Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post('data');
            $product_ids = $post['id'];
            $status = $post['status'];
            try {
                if (Product::updateAll(['status' => $status], ['in', 'id', $product_ids])) {
                    echo true;
                    exit();
                }
                echo false;
                exit();
            } catch (\mysqli_sql_exception $e) {
                echo false;
                exit();
            }
        }
    }

    public function actionAddinslider() {
        if (Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post('data');
            $product_ids = $post['id'];
            try {
                if (Product::updateAll(['in_slider' => 1], ['in', 'id', $product_ids])) {
                    echo true;
                    exit();
                }
                echo false;
                exit();
            } catch (\mysqli_sql_exception $e) {
                echo false;
                exit();
            }
        }
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
/*
    public function upload($imageFile, $id) {
        $directory = 'uploads/images/';
        $directoryThumb = 'uploads/images/thumbnail/';
        //$directoryThumbMin = 'uploads/images/thumbnail-min/';
        BaseFileHelper::createDirectory($directory);
        BaseFileHelper::createDirectory($directoryThumb);
        if (!is_dir($directory)) {
            mkdir($directory);
        }
        if ($imageFile) {
            $paths = [];
            foreach ($imageFile as $key => $image) {
                $uid = uniqid(time(), true);
                $fileName = $uid . '_' . $key . '.' . $image->extension;
                $filePath = $directory . $fileName;
                $filePathThumb = $directoryThumb . $fileName;
                if ($image->saveAs($filePath)) {
                    Image::thumbnail($filePath, 160, 300)->save(Yii::getAlias($directoryThumb . '/' . $fileName), ['quality' => 100]);
                    $paths[$key + 1] = $fileName;
                } else {
                    echo "<pre>";
                    print_r($directory);
                    die;
                }
            }
            return $paths;
        }
        return false;
    }
	*/
	
	public function upload($imageFile, $id) {
	  $directory = Yii::getAlias("@backend/web/uploads/images/");
	  $directoryThumb = Yii::getAlias("@backend/web/uploads/images/thumbnail");
	  $thumbnailproduct = Yii::getAlias("@backend/web/uploads/images/thumbnailproduct");
	  BaseFileHelper::createDirectory($directory);
	  BaseFileHelper::createDirectory($directoryThumb);
	  BaseFileHelper::createDirectory($thumbnailproduct);
	  if ($imageFile) {
		$paths = [];
		foreach ($imageFile as $key => $image) {
		    $uid = uniqid(time(), true);
		    $fileName = $uid . '_' . $key . '.' . $image->extension;
		    $fileName_return = $fileName;
		    $filePath = $directory . '/' . $fileName;
			
			$watermarkImage = Yii::getAlias("@backend/web/images/logo.png");
		    $image->saveAs($filePath);
			$autoImage = getimagesize($filePath);
			$marge_right = 3;
			$marge_bottom = 3;
			$sx = getimagesize($watermarkImage)[0];
			$sy = getimagesize($watermarkImage)[1];
			$newImage = Image::watermark($filePath, $watermarkImage,[$autoImage[0] - $sx - $marge_right, 0]);
			$newImage->save($filePath);
			
			$newImage2 = Image::watermark($filePath, $watermarkImage,[0,$autoImage[1] - $sy - $marge_bottom ]);
			$newImage2->save($filePath);
			
			
		    Image::thumbnail($filePath, 350, 600)->save(Yii::getAlias($thumbnailproduct . '/' . $fileName), ['quality' => 100]);
		    Image::thumbnail($filePath, 670, 820)->save(Yii::getAlias($directoryThumb . '/' . $fileName), ['quality' => 100]);
		    $paths[$key + 1] = $fileName_return;
		}
		return $paths;
	  }
	  return false;
    }

    /**
     * @return string
     */
    public function actionProductDetails() {
        if (Yii::$app->request->isAjax) {
            $category_id = Yii::$app->request->post('category_id');
            $attributes = TrAttribute::getAttributeByCategory($category_id);
            return json_encode($attributes);
        }
    }

    /**
     * @return false|int
     * @throws \Exception
     */
    public function actionDeleteImage() {
        if (Yii::$app->request->isAjax) {
            $model = new ProductImage();
            $id = Yii::$app->request->post('id');
            $model = $model->findOne($id);
            if (file_exists($model->name)) {
                unlink($model->name);
            }
            return $model->delete();
        }
    }

    /**
     * @return bool
     */
    public function actionDefaultImage() {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            return ProductImage::updatDefaultImage($data['newid'], $data['oldid']);
        }
    }

}
