<?php

namespace lukisongroup\hrd\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\debug\components\search\Filter;
use yii\debug\components\search\matchers;


use lukisongroup\hrd\models\Personallog;

/**
 * PersonallogSearch represents the model behind the search form about `lukisongroup\hrd\models\Personallog`.
 */
class PersonallogSearch extends Personallog
{	
	public $tgllog;
	public $tgllate;
	public $FingerPrintID;
	public $TerminalID;
	public $UserID;
	public $FunctionKey;
	public $Edited;
	public $UserName;
	public $FlagAbsence;
	public $DateTime;
	public $DateTimeLate;
	public $tgl;
	public $waktu;
	public $idno;
	public $NAMA;
	
    /**
     * @inheritdoc	
     */
    public function rules()
    {
        return [
            [['idno'], 'integer'],
            [['NAMA','tgllog','tgllate','TerminalID', 'UserID', 'FingerPrintID', 'FunctionKey', 'Edited', 'UserName', 'FlagAbsence', 'DateTime','DateTimeLate','tgl', 'waktu'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
	public function getScripts(){
		return Yii::$app->db2->createCommand("CALL personallog_Employe()")->queryAll();             
	}
	
    public function search($params)
    {
        /* $query = Personallog::find();//->where("FunctionKey=0 OR FunctionKey=1");

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]); */
	
		$dataProvider= new ArrayDataProvider([
			'key' => 'idno',
			'allModels'=>$this->getScripts(),
			 'pagination' => [
				'pageSize' => 200,
			],
			'sort'  => [
				'attributes' => ['FingerPrintID'],
            ],
		]);
		
		if (!($this->load($params) && $this->validate())) {
 			return $dataProvider;
 		}
        /* $this->load($params1);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            //$query->where('0=1');
            return $dataProvider;
        }  */
		
		
		/*
		 * Filter ArrayDataProvider
		 * @author ptrnov [piter@lukison.com]
		 * @since 1.2
		 *
		*/
		$filter = new Filter();
 		$this->addCondition($filter, 'idno', true);
 		$this->addCondition($filter, 'TerminalID', true);
 		$this->addCondition($filter, 'UserID', true);
 		$this->addCondition($filter, 'FingerPrintID');
 	    $this->addCondition($filter, 'FunctionKey', true);
 		$this->addCondition($filter, 'Edited', true);
 		$this->addCondition($filter, 'FlagAbsence', true);
 		$this->addCondition($filter, 'DateTime', true);
 		$this->addCondition($filter, 'tgl', true);
 		$this->addCondition($filter, 'waktu', true);
 		$this->addCondition($filter, 'UserName',true);
 		$this->addCondition($filter, 'NAMA', true);
 		$this->addCondition($filter, 'DateTimeLate', true);		
 		$dataProvider->allModels = $filter->filter($this->getScripts());
 
		
		
		
		
		

        /* $query->andFilterWhere([
            'idno' => $this->idno,
            'Edited' => $this->Edited,
            //'DateTime' => $this->DateTime,
            'tgl' => $this->tgl,
            'waktu' => $this->waktu,
        ]); */
		/* if(isset($this->DateTime) && $this->DateTime!=''){
				$date_explode = explode(" - ", $this->DateTime);
				$date1 = trim($date_explode[0]);
				$date2= trim($date_explode[1]);
				//$query->andFilterWhere(['between', 'DateTime',' like',$date1.'%',$date2.'%']);
				//$query->andFilterWhere(" date(DateTime) between '".$date1 ."' and '".$date2."'");
				$query->andFilterWhere(['between', 'DateTime', $date1,$date2]);
			}  */
        /* $query->andFilterWhere(['like', 'TerminalID', $this->TerminalID])
            ->andFilterWhere(['like', 'UserID', $this->UserID])
            ->andFilterWhere(['like', 'FingerPrintID', $this->FingerPrintID])
            ->andFilterWhere(['like', 'FunctionKey', $this->FunctionKey])
            ->andFilterWhere(['like', 'UserName', $this->UserName])
			//->andFilterWhere(['like', 'DateTime', $this->DateTime!=''?date("Y-m-d",strtotime($this->DateTime)):date("Y-m-d")])
			->andFilterWhere(['like', 'DateTime', $this->tgllog])
			//->andFilterWhere(['like', 'DateTime', $this->tgllog!=''?date("Y-m-d",strtotime($this->tgllog)):date("Y-m-d")])
            ->andFilterWhere(['like', 'FlagAbsence', $this->FlagAbsence]);
 */
        return $dataProvider;
		/* print_r(date("Y-m-d",strtotime($this->DateTime)));
		die(); */
    }
	
	/*Employe Log late*/
	public function search_telat($params)
    {		
		$dataProvider= new ArrayDataProvider([
			'key' => 'idno',
			'allModels'=>$this->getScripts(),
			 'pagination' => [
				'pageSize' => 200,
			],
			'sort'  => [
				'attributes' => ['FingerPrintID'],
            ],
		]);
		
		if (!($this->load($params) && $this->validate())) {
 			return $dataProvider;
 		}
		
		/*
		 * Filter ArrayDataProvider
		 * @author ptrnov [piter@lukison.com]
		 * @since 1.2
		 *
		*/
		$filter = new Filter();
 		$this->addCondition($filter, 'idno', true);
 		$this->addCondition($filter, 'TerminalID', true);
 		$this->addCondition($filter, 'UserID', true);
 		$this->addCondition($filter, 'FingerPrintID');
 	    $this->addCondition($filter, 'FunctionKey', true);
 		$this->addCondition($filter, 'Edited', true);
 		$this->addCondition($filter, 'FlagAbsence', true);
 		$this->addCondition($filter, 'DateTime', true);
 		$this->addCondition($filter, 'tgl', true);
 		$this->addCondition($filter, 'waktu', true);
 		$this->addCondition($filter, 'UserName',true);
 		$this->addCondition($filter, 'NAMA', true);
 		$this->addCondition($filter, 'DateTimeLate', true);		
 		$dataProvider->allModels = $filter->filter($this->getScripts());
		
		return $dataProvider;
		
		
		
	   /* //$query = Personallog::find(['machine_nm','FingerPrintID','UserName','Keys_nm',['DateTime as DateTime1']])->where("FunctionKey=0 AND time(DateTime)>'08:45:00'");
	   //$query = Personallog::find()->select('TerminalID,FingerPrintID,UserName,DateTime as DateTime1')->where("FunctionKey=0 AND time(DateTime)>'08:45:00'");
      // $query = Personallog::find()->where("FunctionKey=0 AND time(DateTime)>'08:45:00'")->groupby('DateTime,FingerPrintID');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        } 

        $query->andFilterWhere([
            'idno' => $this->idno,
            'Edited' => $this->Edited,
            //'DateTime' => $this->DateTime,
            'tgl' => $this->tgl,
            'waktu' => $this->waktu,
        ]);
		 // if(isset($this->DateTime) && $this->DateTime!=''){
				// $date_explode = explode(" - ", $this->DateTime);
				// $date3 = trim($date_explode[0]);
				// $date4= trim($date_explode[1]);
				//$query->andFilterWhere(['between', 'DateTime',' like',$date1.'%',$date2.'%']);
				//$query->andFilterWhere(['between', 'DateTime', $date3,$date4]);
				//$query->andFilterWhere(" date(DateTime) between '".$date3 ."' and '".$date4."'");
			// }  
        $query->andFilterWhere(['like', 'TerminalID', $this->TerminalID])
            ->andFilterWhere(['like', 'UserID', $this->UserID])
            ->andFilterWhere(['like', 'FingerPrintID', $this->FingerPrintID])
            ->andFilterWhere(['like', 'FunctionKey', $this->FunctionKey])
            ->andFilterWhere(['like', 'UserName', $this->UserName])
			->andFilterWhere(['like', 'DateTime', $this->tgllate])
            ->andFilterWhere(['like', 'FlagAbsence', $this->FlagAbsence]);

        return $dataProvider;
		*/
    }
	
	
	
	
	
	public function addCondition(Filter $filter, $attribute, $partial = false)
    {
        $value = $this->$attribute;

        if (mb_strpos($value, '>') !== false) {
            $value = intval(str_replace('>', '', $value));
            $filter->addMatcher($attribute, new matchers\GreaterThan(['value' => $value]));

        } elseif (mb_strpos($value, '<') !== false) {
            $value = intval(str_replace('<', '', $value));
            $filter->addMatcher($attribute, new matchers\LowerThan(['value' => $value]));
        } else {
            $filter->addMatcher($attribute, new matchers\SameAs(['value' => $value, 'partial' => $partial]));
        }
    }
	
	
	
	
	
	
	
	
	
	
	
	
	
}
