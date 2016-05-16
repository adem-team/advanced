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
    public function rules()
    {
        return [
            [['ID', 'MESSAGE_STS', 'MESSAGE_SHOW', 'CREATED_BY'], 'integer'],
            [['MESSAGE','SORT', 'MESSAGE_ATTACH', 'GROUP', 'UPDATED_TIME'], 'safe'],
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
		$id = Yii::$app->user->identity->id;
		
		$SORT = Chatroom::find()->one();
		$data = $SORT->SORT;
		// print_r($SORT);
		// die();
		
		$query = Chat::find()->innerJoinWith('chat', false)
							 //->JoinWith('employee',true,'LEFT JOIN')
											->Where(['GROUP'=>$id])
											->orWhere('CREATED_BY = :CREATED_BY', [':CREATED_BY' => $id])
											->orWhere('SORT = :SORT', [':SORT' => $data]);
										
											

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
            'CREATED_BY' => $this->CREATED_BY,
            'UPDATED_TIME' => $this->UPDATED_TIME,
        ]);

        $query->andFilterWhere(['like', 'MESSAGE', $this->MESSAGE])
            ->andFilterWhere(['like', 'MESSAGE_ATTACH', $this->MESSAGE_ATTACH])
            ->andFilterWhere(['like', 'GROUP', $this->GROUP]);

        return $dataProvider;
    }
	
	
	  
	
	
	
	 public function searchonline($params)
    {
        //$Id = Yii::$app->user->identity->id;
//        print_r($Id);
//        die();
        $query = \lukisongroup\sistem\models\Userlogin::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }


//    $query->andFilterWhere([
//            'ID' => $this->ID,
//            'MESSAGE_STS' => $this->MESSAGE_STS,
//            'MESSAGE_SHOW' => $this->MESSAGE_SHOW,
//            'CREATED_BY' => $this->CREATED_BY,
//            'UPDATED_TIME' => $this->UPDATED_TIME,
//        ]);
//
//        $query->andFilterWhere(['like', 'MESSAGE', $this->MESSAGE])
//            ->andFilterWhere(['like', 'MESSAGE_ATTACH', $this->MESSAGE_ATTACH])
//            ->andFilterWhere(['like', 'GROUP', $this->GROUP]);

        return $dataProvider;
    }
}
