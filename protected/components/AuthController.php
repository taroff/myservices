<?php
class AuthController extends Controller
{
	protected function beforeAction($action) {
		
		if ( !Yii::app()->user->getRole() )
			throw new CHttpException(403, 'Forbidden');
		return parent::beforeAction($action);
	}
}