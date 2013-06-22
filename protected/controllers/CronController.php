<?php

class CronController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		if(!Yii::app()->user->isGuest && Yii::app()->user->gid==1)
			$this->redirect('index.php?r=admin/general');
		elseif(!Yii::app()->user->isGuest && Yii::app()->user->gid==2)
			$this->redirect('index.php?r=index/general');
		else
			$this->redirect('index.php?r=default/login');
	}
}