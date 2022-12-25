<?php

namespace app\models;

use Yii;

class Role extends \yii\db\ActiveRecord
{
public static function tableName(){
	return 'role';
}


public function  rules(){
	return[
		[['title'], 'required'],
		[['title'], 'string', 'max' => 255],
	];
}

public function attributeLabels(){
	return [
		'id' => 'ID',
		'title' => 'Title',
	];
}

public function getUsers(){
	return $this->hasMany(User::className(), ['role_id' => 'id']);
}

public static function getRoleId($role){
	return static::findOne(['title' => $role])->id;
}
}