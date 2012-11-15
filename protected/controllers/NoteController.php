<?php

class NoteController extends AuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

	/**
	 * @return array action filters
	 
	public function filters()
	{
        return array(
            'ajaxOnly + save',
        );
	}
*/
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete', 'AddEditForm'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 
	public function actionCreate()
	{
		$model=new Note;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Note']))
		{
			$model->attributes=$_POST['Note'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Note']))
		{
			$model->attributes=$_POST['Note'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider = new CActiveDataProvider('Note', array(
		    'criteria'=>array(
		        'condition'=>'id_user='.Yii::app()->user->getUserId(),
		        'order'=>'dt_create DESC'
		    ),
		    'pagination'=>array(
		        'pageSize'=>20,
    		)
    	));
    		
    	$arrData = $dataProvider->getData();
		$this->render( 'index', array('model'=> new Note(), 'data'=>$arrData) );
		
		
		// $modNote = new Note();

	}
	
	/**
	 * Ajax add/edit note-form handler
	 */
	public function actionSave()
	{
		$modNote = new Note();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if( isset($_POST['Ajax']) )
		{
			
			$modNote->attributes = $_POST['Ajax'];
			
			if( !$modNote->save() ) die( 'Ошибка добавления записи!' );
			else die( 'Ok' );
			
			//Yii::app()->end();
			
		}
		
		if( isset($_POST['Note']) )
		{
			
			$modNote->attributes = $_POST['Note'];
			
			if( $modNote->save() )
				$this->redirect( '/note' );
			
		}

		//$this->render( 'index', array('model'=>$modNote) );
		$this->redirect( '/note' );		
	}
	
	/**
	 * Manages all models.
	 
	public function actionAdmin()
	{
		$model=new Note('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Note']))
			$model->attributes=$_GET['Note'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 
	public function loadModel($id)
	{
		$model=Note::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='note-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	*/
}
