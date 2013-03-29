<?php

class ShareController extends Controller {
    
    public function actionShare() {
        $user_id = Yii::app()->user->id;
        $res = false;

        if (Yii::app()->request->isAjaxRequest && !empty($user_id)) {
            $item_id = Yii::app()->getRequest()->getPost('item_id');

            $sharedEntry = Posts::model()->findByPk($item_id);
            $newEntry = new Posts;

            $newEntryHash = md5($sharedEntry->author_type.$sharedEntry->author_id.$user_id.$sharedEntry->creation_date);

            if ($sharedEntry->owner_id == $user_id || $sharedEntry->author_id == $user_id || $sharedEntry->status != 1) { // если запись уже есть на стене или если запись заблочена то не добавляем
                echo json_encode(array('status' => 'error', 'data' => 'Ошибка при копировании записи'));
                exit();
            }

            $newEntry->parent_id = $sharedEntry->id; // поле parent_id устанавливаем отличное от нуля (id расшариваемого поста)
            $newEntry->post_type = 'userwall'; // Все основные поля копируем как есть
            $newEntry->author_type = $sharedEntry->author_type;
            $newEntry->owner_type = 'user';
            $newEntry->content = $sharedEntry->content;
            $newEntry->multimedia = $sharedEntry->multimedia;
            $newEntry->status = $sharedEntry->status;
            $newEntry->creation_date = time();
            $newEntry->author_id = $sharedEntry->author_id;
            $newEntry->owner_id = $user_id;
            $newEntry->hash = $newEntryHash;

            // сохраняем новую и старую записи
            $transaction = $sharedEntry->dbConnection->beginTransaction();

            try {
                $newEntry->save();
                $sharedEntry->shares = intval($sharedEntry->shares)+1; // увеличиваем счетчик share у копируемой записи
                $sharedEntry->save();
                $transaction->commit();
                $res = true;
            }
            catch(Exception $e)                {
                $transaction->rollback();
                $res = false;
            }

            if ($res == true) {
                echo json_encode(array('status' => 'ok', 'data' => 'shared'));
            }
            else {
                echo json_encode(array('status' => 'error', 'data' => 'Ошибка подключения к БД'));
            }
        }
        else {
            throw new CException('Not Found', 404);
        }
    }

}
