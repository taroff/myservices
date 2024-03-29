<?php
class Note extends CActiveRecord
{
	public $tags; 
	
	public function beforeSave()
	{
		if ( $this->isNewRecord ) {
		
		} else {
			
		}	
		
		$this->dt_update = date( "Y-m-d H:m:s" );
		$this->id_user = Yii::app()->user->getUserId();
		
		return parent::beforeSave();
	}
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Note the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{note}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title', 'required'),
	//		array('id_user', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>111),
			array('title', 'length', 'min'=>4),
			array('text', 'safe'),
			
	//		array('dt_update', 'safe'),
		//TODO:
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_user, title, text, dt_create, dt_update', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'title' => 'Header',
			'text' => 'Body',
			'tags' => 'Tags'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('id_user',$this->id_user);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('dt_create',$this->dt_create,true);
		$criteria->compare('dt_update',$this->dt_update,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	*/
}