<?php

namespace console\controllers;

use Yii;

/*
	Parse controller
*/
class ParseController extends \yii\console\Controller {

	/*
		Action
	*/
	public function actionIndex() {
		Yii::$app->googleSpreadsheet->parse();
		return 1;
	}
}