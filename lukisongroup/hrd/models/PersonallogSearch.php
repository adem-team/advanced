<?php

namespace lukisongroup\hrd\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\hrd\models\Personallog;

/**
 * PersonallogSearch represents the model behind the search form about `lukisongroup\hrd\models\Personallog`.
 */
class PersonallogSearch extends Personallog
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idno'], 'integer'],
            [['TerminalID', 'UserID', 'FingerPrintID', 'FunctionKey', 'Edited', 'UserName', 'FlagAbsence', 'DateTime', 'tgl', 'waktu'], 'safe'],
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
    public function search($params)
    {
        $query = Personallog::find()->where("FunctionKey=0 OR FunctionKey=1");

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
		if(isset($this->DateTime) && $this->DateTime!=''){
				$date_explode = explode(" - ", $this->DateTime);
				$date1 = trim($date_explode[0]);
				$date2= trim($date_explode[1]);
				//$query->andFilterWhere(['between', date(DateTime), $date1,$date2]);
				$query->Where(" date(DateTime) between '".$date1 ."' and '".$date2."'");
			} 
        $query->andFilterWhere(['like', 'TerminalID', $this->TerminalID])
            ->andFilterWhere(['like', 'UserID', $this->UserID])
            ->andFilterWhere(['like', 'FingerPrintID', $this->FingerPrintID])
            ->andFilterWhere(['like', 'FunctionKey', $this->FunctionKey])
            ->andFilterWhere(['like', 'UserName', $this->UserName])
            ->andFilterWhere(['like', 'FlagAbsence', $this->FlagAbsence]);

        return $dataProvider;
    }
	
	/*Employe Log late*/
	public function searchLate($params)
    {
        $query = Personallog::find()->where("FunctionKey=0 AND time(DateTime)>'08:45:00'");

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
		if(isset($this->DateTime) && $this->DateTime!=''){
				$date_explode = explode(" - ", $this->DateTime);
				$date1 = trim($date_explode[0]);
				$date2= trim($date_explode[1]);
				//$query->andFilterWhere(['between', date(DateTime), $date1,$date2]);
				$query->Where(" date(DateTime) between '".$date1 ."' and '".$date2."'");
			} 
        $query->andFilterWhere(['like', 'TerminalID', $this->TerminalID])
            ->andFilterWhere(['like', 'UserID', $this->UserID])
            ->andFilterWhere(['like', 'FingerPrintID', $this->FingerPrintID])
            ->andFilterWhere(['like', 'FunctionKey', $this->FunctionKey])
            ->andFilterWhere(['like', 'UserName', $this->UserName])
            ->andFilterWhere(['like', 'FlagAbsence', $this->FlagAbsence]);

        return $dataProvider;
    }
}
