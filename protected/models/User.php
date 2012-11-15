<?php

/**
 * This is the model class for table "{{user}}".
 *
 * The followings are the available columns in table '{{user}}':
 * @property integer $id
 * @property string $name
 * @property string $password
 * @property string $email
 * @property string $activate_code
 * @property integer $role
 */
class User extends CActiveRecord
{
	public $password2, $verifyCode, $rememberMe;
	private $_identity;
	
	const ROLE_GUEST = 0;
	const ROLE_AUTH  = 1;
	const ROLE_ADMIN = 9;
	
	public function genPasswordHash( $password, $salt )
	{
		return sha1( md5($password).$salt );
	}
	
	protected function genActivateHash()
	{
		return sha1( md5('dmnfgbsd wqu34y').$this->email );
	}
		
	protected function beforeSave() {
			
		// on register scenarion must encrypt pass + create confirmation email hash
		if ( $this->scenario === 'register' ) {
			
			// TODO: в качестве соли нада что-то другое использовать, ибо мыло мона менять ?
			$this->password = $this->genPasswordHash($this->password, $this->email);     
			$this->activate_code = $this->genActivateHash();			
		}
		
		return parent::beforeSave();
	}
	
	public function authenticate($attribute,$params)
	{
		if( !$this->hasErrors() )
		{
			$this->_identity=new UserIdentity($this->email,$this->password);
			if(!$this->_identity->authenticate())
				$this->addError('password','Incorrect email or password.');
		}
	}

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		if( $this->_identity === null )
		{
			$this->_identity=new UserIdentity($this->email,$this->password);
			$this->_identity->authenticate();
		}
		
		if( $this->_identity->errorCode === UserIdentity::ERROR_NONE )
		{
			$duration = $this->rememberMe ? 3600*24*3 : 0; // 3
			Yii::app()->user->login( $this->_identity, $duration );
			return true;
		}
		else
			return false;
	}
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
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
		return '{{user}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('password, email', 'required'),
		//	array('name, password, email, password2', 'length', 'max'=>255),
			array('email', 'email'),
			
			array('password', 'authenticate', 'on'=>'login'),
			
			array('password, name', 'length', 'min'=>5, 'on'=>'register'),
			array('email', 'unique', 'on'=>'register'),
			array('password2, name, verifyCode', 'required', 'on'=>'register'),
			array('password', 'compare', 'compareAttribute'=>'password2', 'on'=>'register'),
			array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements(), 'on'=>'register'),
			
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, password, email, activate_code, role', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'name' => 'Name',
			'password' => 'Password',
			'password2'=> 'Repeat password',
			'email' => 'Email'
		);
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('email',$this->email,true);
	//	$criteria->compare('activate_code',$this->activate_code,true);
	//	$criteria->compare('role',$this->role);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}