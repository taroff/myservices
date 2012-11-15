<?php

class UserController extends Controller
{
	public function actions()
	{
		return array( 'captcha'=>array('class'=>'CCaptchaAction', 'backColor'=>0xFFFFFF) );		
	}
	
	public function actionActivate()
	{
		$id = (int)( isset($_GET['id']) ) ? $_GET['id'] : 0;
		$code = ( isset($_GET['code']) ) ? $_GET['code'] : 0;
		
		if ($id && $code) {
			$modUser = new User();
			$oCriteria = new CDbCriteria();
			$oCriteria->select = 'activate_code,id';
			$row = $modUser->findByPk( $id, $oCriteria );
			
			if ( $row->activate_code === $code ) {
				$row->activate_code = null;
				$row->save(0);
			} else {
				throw new Exception('Хреновый код хахахахаха!');
			}
		}
		
		$this->render('activate');
	}

	public function actionLogin()
	{
	    $model = new User('login');
	    
		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		
		// process request
	    if( isset($_POST['User']) )
	    {
	        $model->attributes = $_POST['User'];

			if( $model->validate() && $model->login() )
				$this->redirect( Yii::app()->user->returnUrl );				    
	    }
	    
	    $this->render('login',array('model'=>$model));
	}

	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
	
	public function actionRegister()
	{
	    $model = new User('register');
	
	    // uncomment the following code to enable ajax-based validation
	    /*
	    if(isset($_POST['ajax']) && $_POST['ajax']==='user-register-form')
	    {
	        echo CActiveForm::validate($model);
	        Yii::app()->end();
	    }
	    */
	
	    if(isset($_POST['User']))
	    {
	        $model->attributes=$_POST['User'];
	          
	        if($model->validate())
	        {		        
	            if ( $model->save(0) ) {
	            	
	            	// send confirmatino link to user email
	            	// XXX: change this
	            	$name='=?UTF-8?B?'.base64_encode('My services website').'?=';
					$subject='=?UTF-8?B?'.base64_encode('Confirmation email').'?=';
					$headers=	"From: $name <noreply@myservices.com>\r\n".
								"Reply-To: {noreply@myservices.com}\r\n".
								"MIME-Version: 1.0\r\n".
								"Content-type: text/html; charset=UTF-8";
					$body = "Thank you for register. Activation link = <a href='/user/activate/?id={$model->id}&code={$model->activate_code}' target='_blank'>Click here</a>";
	            	@mail( $model->email, $subject, $body, $headers );	
	            
	            	$this->redirect('/user/activate/'); return;	
	            }
	        }
	    }
	    $this->render('register',array('model'=>$model));
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}