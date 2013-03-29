<?php

class PostsController extends Controller {

	public function actionAdd()	{
        if (Yii::app()->request->isAjaxRequest) {
            $content = Yii::app()->getRequest()->getPost('content');
            $owner_type = Yii::app()->getRequest()->getPost('owner_type'); // тип владельца (у кого на стене запостили) поста - user|company
            $owner_id = Yii::app()->getRequest()->getPost('owner_id'); // id владельца поста
            $author_type = Yii::app()->getRequest()->getPost('author_type'); // тип автора поста

            if ($author_type == 'user') { // если постим от юзера
                $author_id = Yii::app()->user->id;
            }
            /*else { // иначе проверяем наличие компании у этого пользователя и постим от имени компании

            }*/

            $post_type = Yii::app()->getRequest()->getPost('post_type'); // тип поста (для их сортировки где либо) - userwall|companywall|communitywall
            $ts = time();

            // Создание JSON массива для прикрепления файлов к посту.
            $multimedia = array(); // Доработать в дальнейшем - либо получаем готовый массив, либо парсим тут в php
            if(isset($_POST['files'])){
                foreach($_POST['files'] as $ind => $files){
                    $multimedia[$ind]['nomber'] = $ind + 1;
                    $multimedia[$ind]['id'] = key($files);
                    $multimedia[$ind]['type'] = current($files);
                    $multimedia[$ind]['upload_date'] = time();
                }
            }else{$files = array();}

            if ($content == 'Что нового') { // если контент пуст, то выдём ошибку
                $content = '';
            }

            if (empty($content)) {
                echo json_encode(array('status' => 'error', 'data' => 'Заполните все обязательные поля!'));
                exit();
            }

            $postObj = new Posts; // создаём новый пост
            $postObj->parent_id = '0'; // 0 т.к. это новый пост и мы никого не расшариваем
            $postObj->post_type = $post_type;
            $postObj->author_type = $author_type;
            $postObj->owner_type = $owner_type;
            $postObj->author_id = $author_id;
            $postObj->owner_id = $owner_id;
            $postObj->creation_date = $ts;
            $postObj->content = $content;
            $postObj->multimedia = json_encode($multimedia);
            $postObj->hash = md5($author_type.$author_id.$owner_id.$ts); // уникальный ключ. Нужен для того что бы пользователь не репостил на свою страницу один и тот же пост

            $postObj->_owner_type = $owner_type; // С чьей стены будем получать последние записи
            $postObj->_owner_id = $owner_id;
            $postObj->_last_id = Yii::app()->getRequest()->getPost('lastEntryId'); // id последней "видимой" записи

            if ($postObj->save()) {
                $posts = $postObj->lastAfterId();
                if (!empty($posts)) {
                    $res = '';
                    $data = array('item' => $item, 'display' => 'none');
                    
                    if(isset($files))
                        $data['files'] = $files;

                    if(isset($id))
                        $data['owner'] = $id;

                    foreach ($posts as $key => $item) {
                        $res .= $this->renderPartial('//posts/_postItem', $data, true);
                    }

                    echo json_encode(array('status' => 'ok', 'data' => $res));
                }
                else {
                    echo json_encode(array('status' => 'error', 'data' => 'null'));
                }
            } else {
                echo json_encode(array('status' => 'error', 'data' => 'Не могу соединиться с БД'));
            }
        } else {
            throw new CException('Not Found', 404);
        }
	}

    public function actionDelete() {
        if (Yii::app()->request->isAjaxRequest) {
            $id = Yii::app()->getRequest()->getPost('item_id');
            $post = Posts::model()->findByPk($id);

            if ($post->author_id == Yii::app()->user->id || $post->owner_id == Yii::app()->user->id) { // удаляем только если автор поста == текущему авторизованному пользователю, либо если хозяин стены == текущему авторизованному пользователю
                // Удаление поста и его комментариев (в mysql триггере)
                $transaction = $post->dbConnection->beginTransaction();

                try {
                    if ($post->parent_id > 0) { // если удаляем расшаренную копию, то декрементим количество расшариваний у оригинала
                        $originalPost = Posts::model()->findByPk($post->parent_id);
                        $originalPost->shares = $originalPost->shares - 1;
                        $originalPost->save();
                    }

                    $post->delete();
                    $transaction->commit();
                    $res = true;
                }
                catch(Exception $e)                {
                    $transaction->rollback();
                    $res = false;
                }

                if ($res) {
                    echo json_encode(array('status' => 'ok'));
                }
                else {
                    echo json_encode(array('status' => 'error', 'data' => 'Не могу подключиться к БД'));
                }
            }
            else {
                throw new CException('Not Found', 404);
            }
        }
        else {
            throw new CException('Not Found', 404);
        }
    }

    public function actionLoadMore() {
        if (Yii::app()->request->isAjaxRequest) {
            $postsObj = new Posts;
            $postsObj->_owner_type = Yii::app()->getRequest()->getPost('owner_type');
            $postsObj->_owner_id = Yii::app()->getRequest()->getPost('owner_id');
            $postsObj->_post_type = Yii::app()->getRequest()->getPost('post_type');
            $postsObj->_limit = Yii::app()->params->maxPostPerRequest;
            $postsObj->_last_id = Yii::app()->getRequest()->getPost('lastEntryId');
            $posts = $postsObj->loadMore();

            foreach ($posts as $item) {
                $res .= $this->renderPartial('//posts/_postItem', array('item' => $item, 'display' => 'none'), true);
            }

            echo json_encode(array('status' => 'ok', 'data' => $res));
        }
        else {
            throw new CException('Not Found', 404);
        }
    }

}
