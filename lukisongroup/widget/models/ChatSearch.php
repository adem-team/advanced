<?php

namespace lukisongroup\widget\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\widget\models\Chat;

/**
 * ChatSearch represents the model behind the search form about `lukisongroup\widget\models\Chat`.
 */
class ChatSearch extends Chat
{
    /**
     * @inheritdoc
     */
	 public $SORT;
   public $id;
    public function rules()
    {
        return [
            [['ID', 'MESSAGE_STS', 'MESSAGE_SHOW'], 'integer'],
            [['MESSAGE','SORT', 'MESSAGE_ATTACH', 'GROUP_ID', 'UPDATED_TIME','CREATED_BY'], 'safe'],
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
  
      // / componen user
          $profile = Yii::$app->getUserOpt->profile_user()->emp;
          $emp_id = $profile->EMP_ID;


          $query = Chat::find()->where(['CREATED_BY'=>$emp_id])
                        ->orwhere(['GROUP_ID'=>$emp_id]);


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
            'ID' => $this->ID,
            'MESSAGE_STS' => $this->MESSAGE_STS,
            'MESSAGE_SHOW' => $this->MESSAGE_SHOW,
            'GROUP_ID' => $this->GROUP_ID,
            'UPDATED_TIME' => $this->UPDATED_TIME,
        ]);

        $query->andFilterWhere(['like', 'MESSAGE', $this->MESSAGE])
            ->andFilterWhere(['like', 'MESSAGE_ATTACH', $this->MESSAGE_ATTACH])
            ->andFilterWhere(['like', 'GROUP_ID', $this->GROUP_ID]);
            // ->andFilterWhere(['like', 'sc0003a.CREATED_BY', $this->CREATED_BY]);

        return $dataProvider;
    }






	 public function searchonline($params)
    {
        $query = \lukisongroup\sistem\models\Userlogin::find()->where('status<>1');

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
           'id' => $this->id,
       ]);
//
       $query->andFilterWhere(['like', 'id', $this->id]);
//            ->andFilterWhere(['like', 'MESSAGE_ATTACH', $this->MESSAGE_ATTACH])
//            ->andFilterWhere(['like', 'GROUP', $this->GROUP]);

        return $dataProvider;
    }
}
