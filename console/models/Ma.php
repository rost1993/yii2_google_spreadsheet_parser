<?php

namespace console\models;

use Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;

/*
	Class Ma - Google spreadsheet list
*/
class Ma extends \yii\db\ActiveRecord {

	public static function tableName() {
		return 'ma';
	}

	public function behaviors() {
		return [
			[
				'class' => TimestampBehavior::className(),
				'value' => new Expression('NOW()'),
			],
		];
	}
}