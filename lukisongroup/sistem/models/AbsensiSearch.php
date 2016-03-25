<?php

namespace lukisongroup\sistem\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\sistem\models\Absensi;

/**
 * AbsensiSearch represents the model behind the search form about `lukisongroup\sistem\models\Absensi`.
 */
class AbsensiSearch extends Absensi
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idno'], 'integer'],
            [['TerminalID', 'UserID', 'FunctionKey', 'Edited', 'UserName', 'FlagAbsence', 'DateTime', 'tgl', 'waktu'], 'safe'],
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
        $query = Absensi::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'idno' => $this->idno,
            'Edited' => $this->Edited,
            'DateTime' => $this->DateTime,
            'tgl' => $this->tgl,
            'waktu' => $this->waktu,
        ]);

        $query->andFilterWhere(['like', 'TerminalID', $this->TerminalID])
            ->andFilterWhere(['like', 'UserID', $this->UserID])
            ->andFilterWhere(['like', 'FunctionKey', $this->FunctionKey])
            ->andFilterWhere(['like', 'UserName', $this->UserName])
            ->andFilterWhere(['like', 'FlagAbsence', $this->FlagAbsence]);

        return $dataProvider;
    }
}
