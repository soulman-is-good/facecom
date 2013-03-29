<?php

class PostsController extends Controller {

	public function actionAdd($id)
	{
	    $text = Yii::app()->getRequest()->getPost('text');

        if($text == 'Что нового')
            $text = '';

        if (empty($text) && !isset($_POST['files'])) {
            echo json_encode(array('status' => 'error', 'data' => 'Заполните все обязательные поля!'));
            exit();
        }
        
        $timestamp = time();
        $postObj = new Posts;
        $postObj->content = $text;
        $postObj->status = 1;
        $postObj->create_time = $timestamp;
        $postObj->author_id = Yii::app()->user->id;
        $postObj->owner_id = $id;
        $postObj->unique_hash = md5(Yii::app()->user->id.$id.$timestamp);

        $postObj->_owner = $id; // С чьей стены будем получать последние записи
        $postObj->_last_id = Yii::app()->getRequest()->getPost('lastEntryId'); // id последней "видимой" записи
        $posts_files = PostsFiles::model();
        if ($postObj->save()) {
           
            if(isset($_POST['files'])){$posts_files->addFiles($postObj->id);}
            if (Yii::app()->request->isAjaxRequest) {

                $posts = $postObj->lastAfterId();

                if (!empty($posts)) {
                    $res = '';

                    foreach ($posts as $key => $item) {
                        $files = $posts_files->findAll('posts_id = :posts_id', array(':posts_id' => $item['id']));
                        $res .= $this->renderPartial('//profile/profile/_wallItem', array('item' => $item, 'files' => $files, 'owner' => $id, 'display' => 'none'), true);
                    }

                    echo json_encode(array('status' => 'ok', 'data' => $res));
                }
                else {
                    echo json_encode(array('status' => 'error', 'data' => 'null'));
                }
            }
            else {
                throw new CException('Not Found', 404);
            }
        }
        else {
            if (Yii::app()->request->isAjaxRequest) {
                echo json_encode(array('status' => 'error', 'data' => 'Не могу соединиться с БД'));
            }
            else {
                throw new CException('Server error', 500);
            }
        }
	}

    public function actionDelete($mid) {
        if (Yii::app()->request->isAjaxRequest) {
            $post = Posts::model()->findByPk($mid);

            if ($post->author_id == Yii::app()->user->id || $post->owner_id == Yii::app()->user->id) { // удаляем только если автор комментария == текущему авторизованному пользователю, либо если хозяин стены == текущему авторизованному пользователю
                // Удаление поста и его комментариев с использованием транзакций
                $transaction = $post->dbConnection->beginTransaction();
                PostsFiles::model()->deleteFiles($post->id);

                try {
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

    public function actionLoadMore($id) {
        if (Yii::app()->request->isAjaxRequest) {

            $postsObj = new Posts;
            $postsObj->_owner = $id;
            $postsObj->_limit = Yii::app()->params->maxPostPerRequest;
            $postsObj->_last_id = Yii::app()->getRequest()->getPost('lastEntryId');
            $posts = $postsObj->loadMore();
            $posts_files = PostsFiles::model();

            foreach ($posts as $item) {
                $files = $posts_files->findAll('posts_id = :posts_id', array(':posts_id' => $item['id']));
                $res .= $this->renderPartial('//profile/profile/_wallItem', array('item' => $item, 'files' => $files, 'display' => 'none'), true);
            }

            echo json_encode(array('status' => 'ok', 'data' => $res));
        }
        else {
            throw new CException('Not Found', 404);
        }
    }

}
