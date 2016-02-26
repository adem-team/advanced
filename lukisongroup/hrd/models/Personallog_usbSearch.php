<?php

namespace lukisongroup\hrd\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\hrd\models\Personallog_usb;

/**
 * Personallog_usbSearch represents the model behind the search form about `lukisongroup\hrd\models\Personallog_usb`.
 */
class Personallog_usbSearch extends Personallog_usb
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['TerminalID'], 'integer'],
            [['FingerPrintID', 'FunctionKey', 'DateTime', 'FlagAbsence'], 'safe'],
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
        $query = Personallog_usb::find();

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
            'TerminalID' => $this->TerminalID,
            'DateTime' => $this->DateTime,
        ]);

        $query->andFilterWhere(['like', 'FingerPrintID', $this->FingerPrintID])
            ->andFilterWhere(['like', 'FunctionKey', $this->FunctionKey])
            ->andFilterWhere(['like', 'FlagAbsence', $this->FlagAbsence]);

        return $dataProvider;
    }
}
