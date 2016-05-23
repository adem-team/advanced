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
            [['MESSAGE','SORT', 'MESSAGE_ATTACH', 'GROUP', 'UPDATED_TIME','CREATED_BY'], 'safe'],
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
	  $profile = Yii::$app->getUserOpt->profile_user()->emp;
    $id = $profile->EMP_ID;


		$query = Chat::find()->JoinWith('employee',true,'LEFT JOIN')
                        ->where(['sc0003a.CREATED_BY'=>$id])
                        ->orwhere(['sc0003a.GROUP'=>$id]);

		// $query = Chat::find()->innerJoinWith('chat', false)
		// 					 //->JoinWith('employee',true,'LEFT JOIN')
		// 									->Where(['GROUP'=>$id])
		// 									->Where('CREATED_BY = :CREATED_BY', [':CREATED_BY' => $id])
		// 									->orWhere('SORT = :SORT', [':SORT' => $data]);




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
            'sc0003a.GROUP' => $this->GROUP,
            'UPDATED_TIME' => $this->UPDATED_TIME,
        ]);

        $query->andFilterWhere(['like', 'MESSAGE', $this->MESSAGE])
            ->andFilterWhere(['like', 'MESSAGE_ATTACH', $this->MESSAGE_ATTACH])
            ->andFilterWhere(['like', 'sc0003a.GROUP', $this->GROUP]);
            // ->andFilterWhere(['like', 'sc0003a.CREATED_BY', $this->CREATED_BY]);

        return $dataProvider;
    }






	 public function searchonline($params)
    {
        //$Id = Yii::$app->user->identity->id;
//        print_r($Id);
//        die();
        $query = \lukisongroup\sistem\models\Userlogin::find()->where(['ONLINE'=>1]);

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
