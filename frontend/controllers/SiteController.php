<?php

namespace frontend\controllers;

use frontend\models\Category;
use frontend\models\Product;
use Yii;
use yii\base\InvalidParamException;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use backend\models\TrProduct;
use backend\models\ProductImage;
use common\models\User;
use common\models\Language;
use backend\models\Pages;
use backend\models\Aboutus;

/**
 * Site controller
 */
class SiteController extends Controller
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
                    'logout' => ['get'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'successCallback'],
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        if (!Yii::$app->session->has('language') && Yii::$app->language != "am") {
            Yii::$app->session->set('language', 'am');
            header('Location: ' . Yii::$app->params['baseUrlHome'] . 'am');
        } elseif (!Yii::$app->session->has('language')) {
            Yii::$app->session->set('language', 'am');
            header('Location: ' . Yii::$app->params['baseUrlHome'] . 'am');
        }

        return $this->render('index', [
            //'products' => $products,
        ]);
    }

    public function actionComing()
    {
        return $this->renderPartial('contact-us');
    }

    public function actionBrands()
    {
        $filter = [];
        $letters = Yii::$app->request->get('letter');
        if ($letters) {
            $filter = ['letter' => Yii::$app->request->get('letter')];
        }
        $brands = Brand::findList(null, $filter);
        foreach ($brands as $key => $br) {
            $brands[$key]['countProduct'] = Brand::getProductCountByBrand($br['id'], true);
            $brands[$key]['products'] = Brand::getProductCountByBrand($br['id']);
        }
        return $this->render('brands', [
            'brands' => $brands
        ]);
    }

    public function actionChangeCurrency($currency)
    {
        $currency = Currency::find()->where(['id' => $currency])->one();
        $session = Yii::$app->session;
        if (!empty($currency)) {
            $currencySession = ['currenncyID' => $currency->id, 'exchange' => $currency->exchange_value];
            if ($session->has('currency')) {
                $currncyArray = $session->remove('currency');
            }
            $session->set('currency', $currencySession);
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function createTree(&$list, $parent)
    {
        $tree = array();
        foreach ($parent as $k => $l) {
            if (isset($list[$l['id']])) {
                $l['child'] = $this->createTree($list, $list[$l['id']]);
            }
            $tree[] = $l;
        }
        return $tree;
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin($authkey = null)
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goBack();
        }

        $model = new LoginForm();
        $modelSignup = new SignupForm();
        if (!is_null($authkey)) {
            $customer = Customer::findByPasswordResetToken($authkey);
            if ($customer) {
                $modelSignup->name = $customer->name;
                $modelSignup->surname = $customer->surname;
                $modelSignup->email = $customer->email;
                $modelSignup->name = $customer->name;
                $modelSignup->verifyToken = $authkey;
                Yii::$app->session->setFlash('notvalid', 'You have successfuly verified your email!');
                Yii::$app->session->setFlash('notvalid', 'Please type new password on Signup form to alow to enter your account');
            } else {
                Yii::$app->session->setFlash('error', 'Wrong password reset token.');
            }
        }

        if ($model->load(Yii::$app->request->post())) {
            $email = Yii::$app->request->post('LoginForm')['email'];
            if ($model->login()) {
                return $this->redirect(Url::previous());
            } elseif (User::$notverified) {
                Yii::$app->session->setFlash('notvalid', 'Please enter your email acocunt and verify your email');
                $model->sendEmailVerify($email);
                return $this->redirect('/site/login');
            } else {
                Yii::$app->session->setFlash('error', 'You typed not correct email or password');
                return $this->redirect('/site/login');
            }
        } else {
            return $this->render('login', [
                'model' => $model,
                'modelSignup' => $modelSignup,
            ]);
        }
    }

    public function actionZapolnitEmail()
    {
        if (Yii::$app->request->post()) {
            $user = User::findOne(Yii::$app->user->identity->id);
            if ($user->email != '') {
                return $this->redirect('/' . Yii::$app->language);
            }
            $customer = Customer::find()->where(['user_id' => Yii::$app->user->identity->id])->one();
            $user->email = Yii::$app->request->post('email');
            if ($user->save()) {
                $customer->email = $user->email;
                $customer->save();
            }
            return $this->redirect('/' . Yii::$app->language);
        }
        $model = new LoginForm();
        return $this->render('fill-email', ['model' => $model]);
    }

    public function actionLoginUser()
    {
        if (Yii::$app->request->isAjax) {
            $userInfo = Yii::$app->request->post('user_info');
            $userData = [];
            $socialId = isset($userInfo['response']) ? $userInfo['response'][0]['id'] : $userInfo['id'];
            $email = isset($userInfo['response']) ? $userInfo['response'][0]['email'] : $userInfo['email'];
            $userLogin = User::find()->where(['social_id' => $socialId])->one();
            if (empty($userLogin)) {
                $userLogin = User::find()->where(['email' => $email])->one();
            }
            if (!empty($userLogin)) {
                if (!empty($userLogin)) {
                    Yii::$app->user->login($userLogin);
                    echo json_encode(['redirectUrl' => Url::previous(), 'success' => true]);
                    exit();
                }
            } else {
                if (isset($userInfo['response'])) {
                    $userData['name'] = $userInfo['response'][0]['first_name'];
                    $userData['surname'] = $userInfo['response'][0]['last_name'];
                    $userData['email'] = isset($userData['response'][0]['email']) ? $userData['response'][0]['email'] : '';
                    $user = new User();
                    $user->username = mb_strtolower($userData['name']) . $userInfo['response'][0]['id'];
                    $user->role = 20;
                    $user->email = isset($userData['response'][0]['email']) ? $userData['response'][0]['email'] : '';
                    $user->social_type = 'facebook';
                    $user->social_id = $userInfo['response'][0]['id'];
                    $password = Yii::$app->security->generateRandomString(6);
                    $user->setPassword($password);
                    $user->generateAuthKey();
                    $userData['social_user_name'] = $userInfo['response'][0]['first_name'] . ' ' . $userInfo['response'][0]['last_name'];
                } else {
                    $user_fio = explode(' ', $userInfo['name']);
                    $userData['name'] = $user_fio[0];
                    $userData['email'] = $userInfo['email'];
                    $userData['surname'] = $user_fio[1];
                    $userData['social_user_name'] = $userInfo['name'];
                    $user = new User();
                    $user->username = mb_strtolower($userData['name']) . $userInfo['id'];
                    $user->role = 20;
                    $user->email = isset($userData['email']) ? $userData['email'] : '';
                    $user->social_type = 'facebook';
                    $user->social_id = $userInfo['id'];
                    $password = Yii::$app->security->generateRandomString(6);
                    $user->setPassword($password);
                    $user->generateAuthKey();
                }

                if ($user->save()) {
                    $customer = new Customer();
                    $customer->name = $userData['name'];
                    $customer->surname = $userData['surname'];
                    $customer->email = isset($userData['email']) ? $userData['email'] : '';
                    $customer->user_id = $user->id;
                    $customer->last_ip = \Yii::$app->request->userIP;
                    $customer->status = 0;
                    $customer->social_user_name = $userData['social_user_name'];
                    $customer->auth_token = '';
                    if ($customer->save(false)) {
                        $userLogin = User::find()->where(['id' => $user->id])->one();
                        if (!empty($userLogin)) {
                            Yii::$app->user->login($userLogin);
                            if ($customer->email != '') {
                                echo json_encode(['redirectUrl' => Url::previous(), 'success' => true]);
                                exit();
                            } else {
                                echo json_encode(['redirectUrl' => '/site/zapolnit-email', 'success' => true]);
                                exit();
                            }
                        }
                        /* $userData = ['email' => $customer->email, 'password' => $password];
                          if ($this->sendEmail($customer->email, 'Invite', $userData)) {
                          Yii::$app->session->setFlash('success', "Your login data sent to your email, please enter to your email to see");
                          } */
                    }
                } else {
                    echo json_encode(['redirectUrl' => Url::previous(), 'success' => false]);
                    exit();
                }
            }
        }
    }

    public function sendEmail($to, $subject, $data)
    {
        $username = ucfirst($data['email']);
        $password = $data['password'];
        $name = preg_replace("/[0-9]+/", '', $username);
        $message = "Hello $name!<br/><br/>
        Your username is $username,<br/>
             password is $password<br/>
         You was added as Customer in our site. You'll love it!";
        return Yii::$app
            ->mailer
            ->compose('email-layout', ['content' => $message])
            ->setFrom(['admin-odenson@test.com' => Yii::$app->name])
            ->setTo($to)
            ->setSubject($subject)
            ->send();
    }

    public function actionCart()
    {
        return $this->render('/cart/list');
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail('')) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionPage($tag)
    {
        $page = Pages::find()->where(['route_name' => $tag])->one();
        return $this->render('page', ['page' => $page]);
    }

    public function actionAboutUs()
    {
        $page = Aboutus::findOne(1);
        return $this->render('about-us', ['page' => $page]);
    }

    public function actionNews()
    {
        return $this->render('news');
    }

    /**
     * Displays faq page.
     *
     * @return mixed
     */
    public function actionFaq()
    {
        return $this->render('/faq/faq');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if (Yii::$app->request->post()) {
            $verifyToken = Yii::$app->request->post('verifyToken');
            $customer = Customer::findByPasswordResetToken($verifyToken);
            $model->load(Yii::$app->request->post());
            $model->username = $model->name . time();;
            if ($customer) {
                $customer->auth_token = "";
                if ($customer->save()) {
                    $user = $model->getNewUser();
                    if (Yii::$app->getUser()->login($user)) {
                        Yii::$app->session->setFlash('success', 'You should type your contact info');
                        return $this->redirect('/user/profile');
                    }
                }
            } else {
                if ($user = $model->signup()) {
                    if (Yii::$app->getUser()->login($user)) {
                        Yii::$app->session->setFlash('success', 'You should type your contact info');
                        return $this->redirect('/user/profile');
                    }
                }
            }
        }
        $modelLogin = new LoginForm();
        return $this->render('login', [
            'model' => $modelLogin,
            'modelSignup' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

}
