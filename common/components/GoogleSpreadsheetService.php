<?php

namespace common\components;

use console\models\Ma;

/*
	Parser Google spreadsheet
*/
class GoogleSpreadsheetService extends \yii\base\Component {

	// ID document
	private $id = '10En6qNTpYNeY_YFTWJ_3txXzvmOA7UxSCrKfKCFfaRw';
	
	// ID page
	private $gid = '1428297429';

	// Array data by google spreadsheet
	private $spreadsheet = [];

	/*
		Initialize yii2 component
	*/
	public function init() {
		parent::init();
		$this->loadGoogleSpreadsheet();
	}

	/*
		Load google spreadsheet
	*/
	private function loadGoogleSpreadsheet() {
		$csv = file_get_contents('https://docs.google.com/spreadsheets/d/' . $this->id . '/export?format=csv&gid=' . $this->gid);
		$csv = explode("\r\n", $csv);
		$this->spreadsheet = array_map('str_getcsv', $csv);
	}

	/*
		Parsing array data by google spreadsheet
	*/
	public function parse() {
		$category = '';

		for($i = 3; $i < count($this->spreadsheet); $i++) {
			if(trim($this->spreadsheet[$i][0]) == 'CO-OP')
				break;

			if(empty(trim($this->spreadsheet[$i][13]))) {
				$category = trim($this->spreadsheet[$i][0]);
				continue;
			}

			if(trim($this->spreadsheet[$i][0]) == 'Total') {
				$category = '';
				continue;
			}

			$product = trim($this->spreadsheet[$i][0]);

			if(empty($product))
				continue;

			// Search old data by google spreadsheet
			$ma = Ma::find()
				->where(['=', 'category', $category])
				->andWhere(['=', 'product', $product])
				->one();

			// If $ma not exists create new object, else update data
			$ma = $ma === null ? new Ma() : $ma;

			$ma->category = $category;
			$ma->product = $product;
			$ma->january = $this->processing($this->spreadsheet[$i][1]);
			$ma->february =$this->processing( $this->spreadsheet[$i][2]);
			$ma->march = $this->processing($this->spreadsheet[$i][3]);
			$ma->april = $this->processing($this->spreadsheet[$i][4]);
			$ma->may = $this->processing($this->spreadsheet[$i][5]);
			$ma->june = $this->processing($this->spreadsheet[$i][6]);
			$ma->july = $this->processing($this->spreadsheet[$i][7]);
			$ma->august = $this->processing($this->spreadsheet[$i][8]);
			$ma->september = $this->processing($this->spreadsheet[$i][9]);
			$ma->october = $this->processing($this->spreadsheet[$i][10]);
			$ma->november = $this->processing($this->spreadsheet[$i][11]);
			$ma->december = $this->processing($this->spreadsheet[$i][12]);
			$ma->total = $this->processing($this->spreadsheet[$i][13]);
			$ma->comment = trim($this->spreadsheet[$i][15]);
			$ma->save();
		}
	}

	/*
		Processing data by cell
		Replace service char: $ , \s (all space)
		Return: string
	*/
	private function processing($value) : string {
		$value = preg_replace('/\s/ui', '', $value);
		$value = preg_replace('/^\$/ui', '', $value);
		$value = preg_replace('/\,/ui', '', $value);

		return empty($value) ? 0.0 : $value;
	}
}