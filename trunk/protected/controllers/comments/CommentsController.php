<?php

class CommentsController extends CController
{

	public function actionAdd() { 
		$text = Yii::app()->getRequest()->getPost('text');
		$tbl = Yii::app()->getRequest()->getPost('tbl');
		$item_id = Yii::app()->getRequest()->getPost('item_id');
		$lastCommentId = Yii::app()->getRequest()->getPost('lastCommentId');
		$owner_id = Yii::app()->getRequest()->getPost('owner');

        if ($text == 'Добавить комментарий' || empty($text) || empty($tbl) || empty($item_id) || empty($owner_id)) {
            echo json_encode(array('status' => 'error', 'data' => 'Заполните все обязательные поля!'));
            exit();
        }

		$commentsObj = new Comments;
		$commentsObj->tbl = $tbl;
		$commentsObj->item_id = $item_id;
		$commentsObj->author_id = Yii::app()->user->id;
		$commentsObj->owner_id = $owner_id;
		$commentsObj->text = $text;
		$commentsObj->timestamp = time();

		if ($commentsObj->save()) {
			if (Yii::app()->request->isAjaxRequest) {
				$comments = array_reverse($commentsObj->lastAfterId($tbl, $item_id, $lastCommentId));
                $res = '';
                                
				foreach ($comments as $item) {
					$res .= $this->renderPartial('//comments/comments/_commentsItem', array('item' => $item, 'display' => 'none'), true);
				}

				echo json_encode(array('status' => 'ok', 'data' => $res));
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

	public function actionShowAll() {
		if (Yii::app()->request->isAjaxRequest) {
			$tbl = Yii::app()->getRequest()->getPost('_tbl');
			$item_id = Yii::app()->getRequest()->getPost('_item_id');
			$lastVisible = Yii::app()->getRequest()->getPost('_lastVisible');
			$comments = Comments::model()->showAll($tbl, $item_id, $lastVisible);

			foreach ($comments as $item) {
				$res .= $this->renderPartial('//comments/comments/_commentsItem', array('item' => $item, 'display' => 'none'), true);
			}

			echo json_encode(array('status' => 'ok', 'data' => $res));
		}
		else {
			throw new CException('Not Found', 404);
		}
	}

	public function actionDelete($id) {
		if (Yii::app()->request->isAjaxRequest) {
			//Comments::model()->deleteAll('');
			$comment = Comments::model()->findByPk($id);

			if ($comment->author_id == Yii::app()->user->id || $comment->owner_id == Yii::app()->user->id) { // удаляем только если автор комментария == текущему авторизованному пользователю, либо если хозяин стены == текущему авторизованному пользователю

				$res = $comment->delete($id);

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

}