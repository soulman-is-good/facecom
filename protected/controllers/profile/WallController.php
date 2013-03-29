<?php

class WallController extends CController
{

	// Добавление записей на стену
	public function actionAdd($id) {

		$model = new Wall;
		$model->text = Yii::app()->getRequest()->getPost('text');
		$model->timestamp = time();
		$model->author_id = Yii::app()->user->id;
		$model->user_id = $id;

		if ($model->save()) {
			if (Yii::app()->request->isAjaxRequest) {
				$wall = Wall::model()->getLast(0, 10, $id);
                                $res = '';
                                
				foreach ($wall as $item) {
					$res .= $this->renderPartial('//profile/profile/_wallItem', array('item' => $item), true);
				}

				echo json_encode(array('status' => 'ok', 'data' => $res));
			}
			else
				$this->redirect(Yii::app()->createUrl('id'.$id));
		}
		else {
			if (Yii::app()->request->isAjaxRequest) {
				echo json_encode(array('status' => 'error'));
			}
			else {
				throw new CException('Server error', 500);
			}
		}

	}

	// Показать следующие записи
	public function actionLoadNext($id, $last, $limit) {
		if (Yii::app()->request->isAjaxRequest) {

			$wall = Wall::model()->loadNext($last, $limit, $id);

			foreach ($wall as $item) {
				$res .= $this->renderPartial('//profile/profile/_wallItem', array('item' => $item), true);
			}

			echo json_encode(array('status' => 'ok', 'data' => $res));
		}
		else {
			throw new CException('Not Found', 404);
		}
	}

}