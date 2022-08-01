<?php

namespace console\controllers;

use Yii;

class ParseController extends \yii\console\Controller {

	public function actionIndex() {
		Yii::$app->googleSpreadsheet->parse();
		return 1;
	}
}