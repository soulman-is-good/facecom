<?php

class MyController extends Controller {

    public $layout = 'profile';

    public function init() {
        Yii::app()->clientScript->registerPackage('main');
    }

    public function actionIndex() {
        if (!Yii::app()->user->isGuest)
            $this->redirect($this->createUrl('profile/profile',array('id'=>Yii::app()->user->id)));
        // Вывод представления
        $this->render('my', array(
            'content1' => 'variable 11',
            'var2' => 'variable 2',
        ));
    }

    public function actionSendmessage() {
        $q = isset($_GET['q']) ? $_GET['q'] : false;
        $fs = fsockopen('127.0.0.1', 8000) or die('No connection');
        fwrite($fs, json_encode(array('user_id' => Yii::app()->user->id, 'message' => $q)));
        echo fread($fs, 1024);
        fclose($fs);
        exit;
    }

    public function actionError() {
        $this->layout = 'main';
        $this->render('error404');
    }

    public function actionCities($cid) {
        if (!Yii::app()->user->isGuest && Yii::app()->request->isAjaxRequest && $cid > 0) {
            $data = CHtml::listData(City::model()->findAll(array(
                                'select' => 'name',
                                'condition' => 'country_id=:cid', 'params' => array(':cid' => $cid)))
                            , 'name', 'name');
            echo CJSON::encode($data);
            Yii::app()->end();
        }
        throw new CException('Not Found', 404);
    }

    public function actionCitiesassoc() {

        if (!Yii::app()->user->isGuest && Yii::app()->request->isAjaxRequest && isset($_GET['cid']) && $_GET['cid'] > 0) {
            $cid = (int) $_GET['cid'];
            $data = CHtml::listData(City::model()->findAll(array(
                                'select' => 'city_id, name',
                                'condition' => 'country_id=:cid', 'params' => array(':cid' => $cid)))
                            , 'city_id', 'name');
            echo CJSON::encode($data);
            Yii::app()->end();
        } elseif (!Yii::app()->user->isGuest && Yii::app()->request->isAjaxRequest) {
            $data = CHtml::listData(Country::model()->findAll(array(
                                'select' => 'country_id, name',
                            ))
                            , 'country_id', 'name');
            echo CJSON::encode($data);
            Yii::app()->end();
        }
        throw new CException('Not Found', 404);
    }

    public function actionCitiesWithAny($cid) {
        if (!Yii::app()->user->isGuest && Yii::app()->request->isAjaxRequest) {
            if ($cid > 0) {

                $base_cities = City::model()->findAll(array(
                    'select' => 'name',
                    'condition' => 'country_id=:cid', 'params' => array(':cid' => $cid)));
            } elseif ($cid == -1) {
                $base_cities = array();
            }
            else
                throw new CException('Not Found', 404);
            $any_city = new City;
            $any_city->name = 'любой город';
            $any_city->city_id = -1;
            $cities = array_merge(array($any_city), $base_cities);
            $data = CHtml::listData($cities, 'name', 'name');
            echo CJSON::encode($data);
            Yii::app()->end();
        }
        throw new CException('Not Found', 404);
    }

    public function actionCitiesWithAnyInCountry($cid) {
        if (!Yii::app()->user->isGuest && Yii::app()->request->isAjaxRequest) {
            if ($cid > 0) {
                $country = ' (' . Country::model()->find(array(
                            'select' => 'name',
                            'condition' => 'country_id=:cid', 'params' => array(':cid' => $cid)
                        ))->name . ')';
                $base_cities = City::model()->findAll(array(
                    'select' => 'name, city_id',
                    'condition' => 'country_id=:cid', 'params' => array(':cid' => $cid)));
            } elseif ($cid == -1) {
                $country = '';
                $base_cities = array();
            }
            else
                throw new CException('Not Found', 404);
            $any_city = new City;
            $any_city->name = 'любой город' . $country;
            $any_city->city_id = -$cid;
            $cities = array_merge(array($any_city), $base_cities);
            $data = CHtml::listData($cities, 'city_id', 'name');
            echo CJSON::encode($data);
            Yii::app()->end();
        }
        throw new CException('Not Found', 404);
    }

    public function actionLogin() {
        if (!Yii::app()->user->isGuest)
            $this->redirect(Yii::app()->createUrl('id' . Yii::app()->user->id));
        $this->layout = 'authorization';
        $model = new LoginForm;

        $user = new User();
        $profile = new UserProfile();
        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'register-form') {
            echo CActiveForm::validate($user);
            Yii::app()->end();
        }
        if (isset($_POST['User'])) {
            $user->attributes = $_POST['User'];
            $user->salt = time();
            $user->login = $user->email;
            $password = $user->password;
            if ($_POST['password_repeat'] != $user->password)
                $user->addError('password', 'Пароли не совпадают');
            if (isset($_POST['UserProfile'])){
                $profile->attributes = $_POST['UserProfile'];
                $profile->birth_date = mktime(0, 0, 0, (int) $_POST['UserProfile']['birth_date'][1], (int) $_POST['UserProfile']['birth_date'][0], (int) $_POST['UserProfile']['birth_date'][2]);
            }
            $profile->scenario = 'register';
            if (!$user->hasErrors() && $profile->validate() && $user->save()) {//TODO: $user->validate()
                $profile->tryGravatar = true;
                $profile->third_name = '';
                $profile->city_id = '1';
                $profile->family = '0';
                $profile->user_id = $user->id;
                $profile->save();
            }
            $_POST['LoginForm'] = array('login' => $user->email, 'password' => $password);
        }
        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login()) {
                if (!isset($_GET['back']))
                    $this->redirect(Yii::app()->createUrl('id' . Yii::app()->user->id));
                else
                    $this->redirect(base64_decode(urldecode($_GET['back'])));
            }
        }
        // display the login form
        $this->render('login', array('model' => $model, 'user' => $user, 'profile' => $profile));
    }

    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    public function actionResize() {
        $image = Yii::app()->request->getPost('image', false);
        $type = Yii::app()->request->getPost('type', false);
        if ($image !== false && in_array($type, array('avatar'))) {
            $file = pathinfo($image,PATHINFO_FILENAME);
            $file = Files::model()->findByPk($file);
            if ($file != NULL) {
                $tmp = TemporaryFiles::model()->find('md5file=:md5f', array(':md5f' => $md5file));
                if ($tmp == null) {
                    $to = realpath(Yii::app()->basePath . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'upload'
                                    . DIRECTORY_SEPARATOR . 'TemporaryFiles') . DIRECTORY_SEPARATOR . $filename;
                    if ($to && @copy($image, $to)) {
                        $image = $to;
                        $size = getimagesize($image);
                        if ($size[0] > 656 || $size[1] > 520) {
                            Yii::import('ext.iwi.Iwi');
                            $img = new Iwi($image);
                            $img->resize(656, 520, 2);
                            $img->save();
                        }
                        $tmp = new TemporaryFiles();
                        $tmp->md5file = $md5file;
                        $tmp->filename = $filename;
                        $tmp->upload_date = time();
                        $tmp->save();
                    } else if (!is_file($to)) {
                        echo CJSON::encode(array('message' => 'Ошибка копирования файла!', 'status' => 'ERROR'));
                        exit;
                    } else {
                        echo CJSON::encode(array('message' => basename($to), 'status' => 'OK'));
                        exit;
                    }
                }
                echo CJSON::encode(array('message' => $tmp->filename, 'status' => 'OK'));
            }
                echo CJSON::encode(array('message' => 'Файл не найден', 'status' => 'ERROR'));
        }
        exit;
    }

    /**
     * Temporary method for clearing temp files linked with TempoaryFiles class
     * @todo remove!!!
     */
    public function actionCleartemp() {
        if (!YII_DEBUG)
            exit;
        $tmps = TemporaryFiles::model()->findAll('md5file IS NOT NULL');
        $path = realpath(Yii::app()->basePath . '/../upload/TemporaryFiles/');
        $result = true;
        if ($path !== FALSE) {
            //we will delete after successfully remove all data from database
            //though this is a transaction we couldn't know if the record where deleted or not
            //..not before commit
            $unlinks = array();
            $transaction = Yii::app()->db->beginTransaction();
            try {
                foreach ($tmps as $tmp) {
                    if (is_file($path . DIRECTORY_SEPARATOR . $tmp->filename)) {
                        $unlinks[] = $path . DIRECTORY_SEPARATOR . $tmp->filename;
                        $tmp->delete();
                    }
                }
                $transaction->commit();
                //$result = array_reduce($unlinks, function($res,$item){ return $res && @unlink($item);},$result);
            } catch (Exception $e) {
                $transaction->rollback();
            }
        }
        var_dump($result);
        exit;
    }

    public function actionGo($url) {
        if (!$url)
            throw new CException('Page not found', 404);
        $url = urldecode($url);
        //TODO: Make handle redirect page.
        header('Content-Type: text/html; charset=utf-8');
        echo 'Вы собираетесь перейти по внешней ссылке: <a href="' . $url . '">' . $url . '</a><br/>Нажмите на ней чтобы продолжить.';
        Yii::app()->end();
    }

    public function actionCart($item_id, $type, $count) {
        $cart = Yii::app()->user->getState('cart');
        if ($cart == null)
            $cart = array();
        if (!isset($cart[$item_id]))
            $cart[$item_id] = 0;
        $cart[$item_id] += $count;
        Yii::app()->user->setState('cart', $cart);
        exit;
    }

}