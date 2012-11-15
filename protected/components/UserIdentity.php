<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    private $_id;
    
    public function authenticate()
    {
    	$modUser = User::model();
        //$record = $modUser->findByAttributes( array('email'=>$this->username) );
    	
        $userRow = Yii::app()->db->createCommand()
    				->select('*')->from('{{user}}')
    				->where('email=:id', array(':id'=>$this->username))
    				->queryRow();
    				
        if( $userRow === null )
            $this->errorCode=self::ERROR_USERNAME_INVALID;
            
        else if( $userRow['password'] !== $modUser->genPasswordHash( $this->password, $userRow['email'] ) )
            $this->errorCode=self::ERROR_PASSWORD_INVALID;
            
        else
        {
            $this->_id = $userRow['id'];
            $this->setState('name', $userRow['name']);
            $this->errorCode=self::ERROR_NONE;
            
            unset( $userRow['password'] );
            Yii::app()->user->setUserRow($userRow);
        }
        return !$this->errorCode;
    }
 
    public function getId()
    {
        return $this->_id;
    }
    
}