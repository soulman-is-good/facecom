<?php

class PlacemarksController extends Controller {

    public $layout = 'profile';

    public function init() {
//        Yii::app()->clientScript->registerPackage('main');
    }

    public function actionGet() {
        if(!Yii::app()->request->isAjaxRequest) 
            throw new CException('Page Not Found',404);
        $id = Yii::app()->user->id;
        $model = Filemarks::model();
        $cri = new CDbCriteria(array(
            'select'=>"t.lat, t.long, t.zoom, CONCAT('/id$id/photos/show/',a.id,'#',p.id) as id, CONCAT(f.id,'.',f.extension) `filename`",
            'join'=>"INNER JOIN photos p ON p.file=t.file_id INNER JOIN albums a ON a.id=p.album_id INNER JOIN files f ON f.id=t.file_id",
            'condition'=>"user_id=:uid",
            'params'=>array(':uid'=>$id)
            )
        );
        $placemarks = $model->getCommandBuilder()
               ->createFindCommand($model->tableSchema, $cri)
               ->queryAll();
        echo CJSON::encode($placemarks);
        exit;
    }
    
    public function actionSave() {
        $uid = Yii::app()->user->id;
        $pid = $_GET['pid'];
        $lat = $_GET['lat'];
        $lng = $_GET['lng'];
        $zoom = $_GET['zoom']==0?13:(int)$_GET['zoom'];
        if(NULL === ($fm = Filemarks::model()->find("file_id=:fid",array('fid'=>$pid))))
            $fm = new Filemarks;
        $fm->file_id = $pid;
        $fm->lat = $lat;
        $fm->long = $lng;
        $fm->zoom = $zoom;
        $fm->created_at = time();
        $fm->status = 1;
        $fm->save();
        exit;
    }

    public function actionEdit() {
        if (Yii::app()->user->isGuest)
            $this->redirect($this->createUrl('my/login'));

        $model = UserProfile::model()->with('universities', 'works')->find('t.user_id=:id', array(':id' => Yii::app()->user->id));
        if ($model == null) //so why we don't have a profile
            $model = new UserProfile;

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'userprofile-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        $bUniver = true;
        $universities = array();
        $schools = array();
        $works = array();
        //Storing user's universities
        if (FALSE !== ($userunivers = Yii::app()->request->getPost('UserUniversity', false))) {
            $delete_uid = array();
            foreach ($userunivers as $i => $uu) {
                if (isset($uu['delete']) && isset($uu['id']) && $uu['id'] > 0) {
                    $delete_uid[] = (int) $uu['id'];
                } elseif (!empty($uu['title']) && !empty($uu['faculty'])) {
                    if (isset($uu['id']) && $uu['id'] > 0) {
                        $univer = UserUniversity::model()->find("id=:uni AND user_id=:uid", array(':uni' => (int) $uu['id'], ':uid' => Yii::app()->user->id));
                        //no perverts!
                        if ($univer == null)
                            continue;
                    }else {
                        if (trim($uu['title']) == '' && trim($uu['faculty']) == '' && trim($uu['year_from']) == '' && trim($uu['year_till']) == '')
                            continue;
                        $univer = new UserUniversity();
                    }
                    $univer->attributes = $uu;
                    $univer->user_id = Yii::app()->user->id;
                    $bUniver = $bUniver && !$univer->hasErrors() && $univer->save();
                    $universities[] = $univer;
                }
            }
            if (!empty($delete_uid))
                UserUniversity::model()->deleteByPk($delete_uid);
        }else
            $universities = $model->universities;
        //Storing user's schools
        if (FALSE !== ($userschools = Yii::app()->request->getPost('UserSchool', false))) {
            $delete_uid = array();
            foreach ($userschools as $i => $uu) {
                if (isset($uu['delete']) && isset($uu['id']) && $uu['id'] > 0) {
                    $delete_uid[] = (int) $uu['id'];
                } elseif (!empty($uu['title'])) {
                    if (isset($uu['id']) && $uu['id'] > 0) {
                        $univer = UserSchool::model()->find("id=:uni AND user_id=:uid", array(':uni' => (int) $uu['id'], ':uid' => Yii::app()->user->id));
                        //no perverts!
                        if ($univer == null)
                            continue;
                    }else {
                        if (trim($uu['title']) == '' && trim($uu['year_from']) == '' && trim($uu['year_till']) == '')
                            continue;
                        $univer = new UserSchool();
                    }
                    $univer->attributes = $uu;
                    $univer->user_id = Yii::app()->user->id;
                    $bUniver = $bUniver && !$univer->hasErrors() && $univer->save();
                    $schools[] = $univer;
                }
            }
            if (!empty($delete_uid))
                UserSchool::model()->deleteByPk($delete_uid);
        }else
            $schools = $model->schools;
        //Storing user's works
        if (FALSE !== ($userworks = Yii::app()->request->getPost('UserWork', false))) {
            $delete_uid = array();
            foreach ($userworks as $i => $uu) {
                if (isset($uu['delete']) && isset($uu['id']) && $uu['id'] > 0) {
                    $delete_uid[] = (int) $uu['id'];
                } elseif (!empty($uu['work'])) {
                    if (isset($uu['id']) && $uu['id'] > 0) {
                        $work = UserWork::model()->find("id=:uni AND user_id=:uid", array(':uni' => (int) $uu['id'], ':uid' => Yii::app()->user->id));
                        //no perverts!
                        if ($work == null)
                            continue;
                    }else {
                        if (trim($uu['work']) == '' && trim($uu['state']) == '' && trim($uu['year_from']) == '' && trim($uu['year_till']) == '')
                            continue;
                        $work = new UserWork();
                    }
                    if (!empty($uu['city'])) {
                        $city = City::model()->find(array('select' => 'city_id', 'condition' => "`name` LIKE :city", 'params' => array(':city' => $uu['city'])));
                        if ($city != null)
                            $uu['city_id'] = $city->city_id;
                        else
                            $work->addError('city_id', Yii::t('errors', 'Такого города не существует'));
                    }else
                        $work->addError('city_id', Yii::t('errors', 'Нужно указать город'));
                    unset($uu['city']);
                    $work->attributes = $uu;
                    $work->year_from = $uu['year_from']; //some how it doesn't work... Yii?
                    $work->user_id = Yii::app()->user->id;
                    $bUniver = $bUniver && !$work->hasErrors() && $work->save();
                    $works[] = $work;
                }
            }
            if (!empty($delete_uid))
                UserWork::model()->deleteByPk($delete_uid);
        }else
            $works = $model->works;
        //updating User's profile
        if (FALSE !== ($userprofile = Yii::app()->request->getPost('UserProfile', false))) {
            $model->attributes = $userprofile;
            if ($model->isNewRecord)
                $model->user_id = Yii::app()->user->id;
            if (Yii::app()->request->getPost('city')) {
                $city = Yii::app()->request->getPost('city');
                $city = City::model()->find(array('select' => 'city_id', 'condition' => "`name` LIKE :city", 'params' => array(':city' => $city)));
                if ($city != null)
                    $model->city_id = $city->city_id;
                else
                    $model->addError('city_id', Yii::t('errors', 'Такого города не существует'));
            }else {
                $model->addError('city_id', Yii::t('errors', 'Нужно указать город'));
            }
            if (Yii::app()->request->getPost('birth_day') && Yii::app()->request->getPost('birth_month') && Yii::app()->request->getPost('birth_year')) {
                $model->birth_date = mktime(0, 0, 0, (int) Yii::app()->request->getPost('birth_month'), (int) Yii::app()->request->getPost('birth_day'), (int) Yii::app()->request->getPost('birth_year'));
            }
            if (!$model->hasErrors() && $model->save() && $bUniver) {
                $this->refresh();
            }
        }

        Yii::app()->clientScript->registerPackage('profile-edit');
        $this->render('edit', array('model' => $model, 'universities' => $universities, 'schools' => $schools, 'works' => $works));
    }

    public function actionEditAvatar() {
        Yii::import('ext.iwi.Iwi');
        $id = Yii::app()->user->id;
        if (!$id > 0)
            throw new CException('Not Found', 404);
        $filev = new FileValidator();
        $filev->types = array('jpg', 'jpeg', 'png', 'gif');
        $filev->sizes = array('min' => array(190, 190), 'max' => array(656, 520));
        $upload = Images::model()->uploadFile('avatar', true, $filev);
        if ($upload !== false && !isset($upload['error'])) {
            echo CJSON::encode(array('message' => $upload['filename'] . '.' . $upload['extension'], 'status' => 'OK'));
        } else if (isset($upload['error'])) {
            echo CJSON::encode(array('message' => $upload['error'], 'status' => 'ERROR'));
        }

        if (Yii::app()->request->getPost('height') > 0) {
            $post = array(
                'height' => (int) Yii::app()->request->getPost('height'),
                'width' => (int) Yii::app()->request->getPost('width'),
                'left' => (int) Yii::app()->request->getPost('left'),
                'top' => (int) Yii::app()->request->getPost('top'),
                'image' => Yii::app()->request->getPost('image'),
            );
            $path = realpath(Yii::app()->basePath . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR);
            $basename = basename($post['image']);
            $image = new Iwi($path . $post['image']);
            $image
                    ->resize($post['width'], $post['height'])
                    ->crop(192, 192, $post['top'], $post['left']);
            if ($image->save($path . DIRECTORY_SEPARATOR . 'upload' . DIRECTORY_SEPARATOR . 'UserProfile' . DIRECTORY_SEPARATOR . $basename)) {
                $user = UserProfile::model()->find("user_id=:uid", array('uid' => $id));
                $oldavatar = false;
                if ($user->avatar != $basename)
                    $oldavatar = $user->avatar;
                $user->avatar = $basename;
                if ($user->save()) {
                    if ($oldavatar != false && $oldavatar != 'testAvatar.png' && is_file($path . DIRECTORY_SEPARATOR . 'upload' . DIRECTORY_SEPARATOR . 'UserProfile' . DIRECTORY_SEPARATOR . $oldavatar))
                        FileHelper::cleanUpload('UserProfile', $oldavatar);
                    echo CJSON::encode(array('message' => $post['image'], 'status' => 'OK'));
                }else {
                    echo CJSON::encode(array('message' => $user->getErrors(), 'status' => 'ERROR'));
                }
                exit;
            } else {
                //System error must be handled by administration.
                Yii::log("Ошибка при создании файла аватара '{$post['image']}'. Пользователь #$id", 'email');
                echo CJSON::encode(array('status' => 'ERROR', 'message' => 'Ну удалось сохранить аватар. Попробуйте позже.'));
            }
        }//else
        //echo CJSON::encode(array('status'=>'ERROR','message'=>'Не хватает параметров.'));
        //if(isset($_GET['ajax']))
        exit();
        //$this->render('edit_avatar');
    }

    public function actionEditBackground() {
        Yii::import('ext.iwi.Iwi');
        $id = Yii::app()->user->id;
        if (!$id > 0)
            throw new CException('Not Found', 404);
        $filev = new FileValidator();
        $filev->types = array('jpg', 'jpeg', 'png', 'gif');
        $filev->sizes = array('min' => 962, 250);
        $upload = Images::model()->uploadFile('avatar', true, $filev);
        if ($upload !== false && !isset($upload['error'])) {
            //$size = getimagesize(Yii::getPathOfAlias('webroot').'/upload/photos/'.$upload['filename'].'.'.$upload['extension']);
            //if($size[0]<962 || $size[1]<250){
            //    echo CJSON::encode(array('message'=>'Размер изображения должен быть не меньше 962 в ширине на 250 по высоте пикселей.','status'=>'ERROR'));
            //    exit();                        
            //}
            echo CJSON::encode(array('message' => $upload['filename'] . '.' . $upload['extension'], 'status' => 'OK'));
        } else if (isset($upload['error'])) {
            echo CJSON::encode(array('message' => $upload['error'], 'status' => 'ERROR'));
        }
        if (Yii::app()->request->getPost('height') > 0) {
            $post = array(
                'height' => (int) Yii::app()->request->getPost('height'),
                'width' => (int) Yii::app()->request->getPost('width'),
                'left' => (int) Yii::app()->request->getPost('left'),
                'top' => (int) Yii::app()->request->getPost('top'),
                'image' => trim(Yii::app()->request->getPost('image', ''), '/'),
            );
            $filename = basename($post['image']);
            $path = realpath(Yii::app()->basePath . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR);
            $userpath = $path . DIRECTORY_SEPARATOR . 'upload' . DIRECTORY_SEPARATOR . 'UserProfile' . DIRECTORY_SEPARATOR;
            $image = new Iwi($path . DIRECTORY_SEPARATOR . $post['image']);
            $image
                    ->resize($post['width'], $post['height'])
                    ->crop(962, 250, $post['top'], $post['left']);
            if ($image->save($userpath . $filename)) {
                $user = UserProfile::model()->find("user_id=:uid", array('uid' => $id));
                $oldavatar = false;
                if ($user->background != $filename)
                    $oldavatar = $user->background;
                $user->background = $filename;
                if ($user->save()) {
                    if ($oldavatar != false && $oldavatar != 'userTestBG.png' && is_file($userpath . $oldavatar))
                        FileHelper::cleanUpload('UserProfile', $oldavatar);
                    echo CJSON::encode(array('message' => $filename, 'status' => 'OK'));
                }else {
                    echo CJSON::encode(array('message' => $user->getErrors(), 'status' => 'ERROR'));
                }
                exit;
            } else {
                //System error must be handled by administration.
                Yii::log("Ошибка при создании файла аватара '{$post['image']}'. Пользователь #$id", 'email');
                echo CJSON::encode(array('status' => 'ERROR', 'message' => 'Ну удалось сохранить аватар. Попробуйте позже.'));
            }
        }//else
        //    echo CJSON::encode(array('status'=>'ERROR','message'=>'Не хватает параметров.'));
        //if(isset($_GET['ajax']))
        exit();
        //$this->render('edit_avatar');
    }

    public function actionAddFriend() {
        $id = Yii::app()->user->id;
        if (!$id > 0)
            throw new CException('Not Found', 404);

        $u_id = $_GET['id'];
        $f_id = $_GET['f_id'];

        $friendship_a = UserFriends::model()->find('status = 2 and user_id = ' . $u_id . ' and friend_id = ' . $f_id);
        $friendship_b = UserFriends::model()->find('status = 3 and user_id = ' . $f_id . ' and friend_id = ' . $u_id);

        $is_friends_a = UserFriends::model()->find('status = 1 and user_id = ' . $u_id . ' and friend_id = ' . $f_id);
        $is_friends_b = UserFriends::model()->find('status = 1 and user_id = ' . $f_id . ' and friend_id = ' . $u_id);

        if ($friendship_a && $friendship_b) {
            echo json_encode(array('status' => 'ok', 'data' => '<font class="blue">Запрос дружбы уже отправлен</font>'));
        } elseif ($is_friends_a && $is_friends_b) {
            echo json_encode(array('status' => 'ok', 'data' => '<font class="blue">Вы уже друзья</font>'));
        } else {
            $add_friend_a = new UserFriends;
            $add_friend_a->id = NULL;
            $add_friend_a->user_id = $u_id;
            $add_friend_a->friend_id = $f_id;
            $add_friend_a->status = '2';
            $add_friend_a->save();

            $add_friend_b = new UserFriends;
            $add_friend_b->id = NULL;
            $add_friend_b->user_id = $f_id;
            $add_friend_b->friend_id = $u_id;
            $add_friend_b->status = '3';
            $add_friend_b->save();

            echo json_encode(array('status' => 'ok', 'data' => '<font class="grey">Вы отправили заявку, </font><a onclick="deleteRequest(this,\'' . $this->createUrl('profile/profile/DeleteRequest', array('id' => $u_id, 'f_id' => $f_id)) . '\')" href="#" class="blue">' . Yii::t('site', 'Удалить вашу заявку?') . '<a>'));
        }
    }

    public function actionDeleteRequest() {
        $id = Yii::app()->user->id;
        if (!$id > 0)
            throw new CException('Not Found', 404);

        $u_id = $_GET['id'];
        $f_id = $_GET['f_id'];

        $is_my_request_a = UserFriends::model()->find('status = 2 and user_id = ' . $u_id . ' and friend_id = ' . $f_id);
        $is_my_request_b = UserFriends::model()->find('status = 3 and user_id = ' . $f_id . ' and friend_id = ' . $u_id);

        if ($is_my_request_a && $is_my_request_b) {
            $reject_request_a = UserFriends::model()->find('user_id = ' . $u_id . ' and friend_id = ' . $f_id);
            $reject_request_a->delete();

            $reject_request_b = UserFriends::model()->find('user_id = ' . $f_id . ' and friend_id = ' . $u_id);
            $reject_request_b->delete();

            echo json_encode(array('status' => 'ok', 'data' => '<a onclick="addFriend(this, \'' . $this->createUrl('profile/profile/AddFriend', array('id' => $u_id, 'f_id' => $f_id)) . '\')" href="#" class="blue">' . Yii::t('site', 'Добавить в друзья') . '</a>'));
        }
    }

    public function actionConfirmRequest() {
        $id = Yii::app()->user->id;
        if (!$id > 0)
            throw new CException('Not Found', 404);

        $u_id = $_GET['id'];
        $f_id = $_GET['f_id'];

        $is_request_a = UserFriends::model()->find('status = 2 and user_id = ' . $f_id . ' and friend_id = ' . $u_id);
        $is_request_b = UserFriends::model()->find('status = 3 and user_id = ' . $u_id . ' and friend_id = ' . $f_id);

        if ($is_request_a && $is_request_b) {
            $reject_request_a = UserFriends::model()->find('user_id = ' . $f_id . ' and friend_id = ' . $u_id);
            $reject_request_a->status = '1';
            $reject_request_a->save();

            $reject_request_b = UserFriends::model()->find('user_id = ' . $u_id . ' and friend_id = ' . $f_id);
            $reject_request_b->status = '1';
            $reject_request_b->save();

            echo json_encode(array('status' => 'ok', 'data' => '<a onclick="deleteFriendship(this,\'' . $this->createUrl('profile/profile/DeleteFriendship', array('id' => $u_id, 'f_id' => $f_id)) . '\')" href="#" class="blue">' . Yii::t('site', 'Удалить из друзей') . '</a>'));
        }
    }

    public function actionRejectRequest() {
        $id = Yii::app()->user->id;
        if (!$id > 0)
            throw new CException('Not Found', 404);

        $u_id = $_GET['id'];
        $f_id = $_GET['f_id'];

        $is_request_a = UserFriends::model()->find('status = 2 and user_id = ' . $f_id . ' and friend_id = ' . $u_id);
        $is_request_b = UserFriends::model()->find('status = 3 and user_id = ' . $u_id . ' and friend_id = ' . $f_id);

        if ($is_request_a && $is_request_b) {
            $reject_request_a = UserFriends::model()->find('user_id = ' . $f_id . ' and friend_id = ' . $u_id);
            $reject_request_a->delete();

            $reject_request_b = UserFriends::model()->find('user_id = ' . $u_id . ' and friend_id = ' . $f_id);
            $reject_request_b->delete();

            echo json_encode(array('status' => 'ok', 'data' => '<a onclick="addFriend(this, \'' . $this->createUrl('profile/profile/AddFriend', array('id' => $u_id, 'f_id' => $f_id)) . '\')" href="#" class="blue">' . Yii::t('site', 'Добавить в друзья') . '</a>'));
        }
    }

    public function actionDeleteFriendship() {
        $id = Yii::app()->user->id;
        if (!$id > 0)
            throw new CException('Not Found', 404);

        $u_id = $_GET['id'];
        $f_id = $_GET['f_id'];

        $is_my_request_a = UserFriends::model()->find('status = 1 and user_id = ' . $f_id . ' and friend_id = ' . $u_id);
        $is_my_request_b = UserFriends::model()->find('status = 1 and user_id = ' . $u_id . ' and friend_id = ' . $f_id);

        if ($is_my_request_a && $is_my_request_b) {
            $reject_request_a = UserFriends::model()->find('user_id = ' . $f_id . ' and friend_id = ' . $u_id);
            $reject_request_a->status = '2';
            $reject_request_a->save();

            $reject_request_b = UserFriends::model()->find('user_id = ' . $u_id . ' and friend_id = ' . $f_id);
            $reject_request_b->status = '3';
            $reject_request_b->save();

            echo json_encode(array('status' => 'ok', 'data' => '<a onclick="confirmRequest(this, \'' . $this->createUrl('profile/profile/ConfirmRequest', array('id' => $u_id, 'f_id' => $f_id)) . '\')" href="#" class="blue">' . Yii::t('site', 'Принять заявку') . '</a>' . ' ' . '<a onclick="rejectRequest(this, \'' . $this->createUrl('profile/profile/RejectRequest', array('id' => $u_id, 'f_id' => $f_id)) . '\')" href="#" class="blue">' . Yii::t('site', 'Удалить заявку') . '</a>'));
        }
    }

}
