<?php

namespace lukisongroup\master\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\master\models\Scheduleheadertemp;
use lukisongroup\sistem\models\Userlogin;

/**
 * ScheduleheaderSearch represents the model behind the search form about `lukisongroup\master\models\Scheduleheader`.
 */
class ScheduleheadertempSearch extends Scheduleheadertemp
{

    public function attributes()
    {
        /*Author -ptr.nov- add related fields to searchable attributes */
        return array_merge(parent::attributes(), ['user.username','scdlgroup.SCDL_GROUP_NM']);
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['ID', 'SCDL_GROUP', 'STATUS'], 'integer'],
            [['TGL1','user.username','USER_ID', 'NOTE', 'CREATE_BY', 'CREATE_AT', 'UPDATE_BY', 'UPDATE_AT','TGL2','scdlgroup.SCDL_GROUP_NM'], 'safe'],
            [['USER_ID', 'NOTE', 'CREATE_BY', 'CREATE_AT', 'UPDATE_BY', 'UPDATE_AT'], 'safe'],
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
        $query = Scheduleheadertemp::find()->joinWith('scdlgroup',true,'JOIN')
                                        ->joinWith('user',true,'JOIN');

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
            'TGL1' => $this->TGL1,
            'SCDL_GROUP' => $this->SCDL_GROUP,
            'STATUS' => $this->STATUS,
            'CREATE_AT' => $this->CREATE_AT,
            'UPDATE_AT' => $this->UPDATE_AT,
        ]);

        $query->andFilterWhere(['like', 'USER_ID', $this->USER_ID])
            ->andFilterWhere(['like', 'NOTE', $this->NOTE])
            ->andFilterWhere(['like', 'CREATE_BY', $this->CREATE_BY])
            ->andFilterWhere(['like', 'UPDATE_BY', $this->UPDATE_BY])
            ->andFilterWhere(['like', 'username', $this->getAttribute('user.username')])
            ->andFilterWhere(['like','SCDL_GROUP_NM', $this->getAttribute('scdlgroup.SCDL_GROUP_NM')]);

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchid($params)
    {
        
        $params1 = $params['ScheduleheaderSearch']['USER_ID'] != '' ? $params['ScheduleheaderSearch']['USER_ID'] : '' ;

        $query = Userlogin::find()->where(['id'=>$params1]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // $query->andFilterWhere([
        //     'ID' => $this->ID,
        //     'TGL1' => $this->TGL1,
        //     'SCDL_GROUP' => $this->SCDL_GROUP,
        //     'STATUS' => $this->STATUS,
        //     'CREATE_AT' => $this->CREATE_AT,
        //     'UPDATE_AT' => $this->UPDATE_AT,
        // ]);

        $query->andFilterWhere(['like', 'id', $params1]);
            // ->andFilterWhere(['like', 'NOTE', $this->NOTE])
            // ->andFilterWhere(['like', 'CREATE_BY', $this->CREATE_BY])
            // ->andFilterWhere(['like', 'UPDATE_BY', $this->UPDATE_BY])
            // ->andFilterWhere(['like', 'username', $this->getAttribute('user.username')])
            // ->andFilterWhere(['like','SCDL_GROUP_NM', $this->getAttribute('scdlgroup.SCDL_GROUP_NM')]);

        return $dataProvider;
    }

    // public function searchheader($params,$id)
    // {
    //     $query = Scheduleheader::find()->where(['SCDL_GROUP'=>$id]);
    //
    //     $dataProvider = new ActiveDataProvider([
    //         'query' => $query,
    //     ]);
    //
    //     $this->load($params);
    //
    //     if (!$this->validate()) {
    //         // uncomment the following line if you do not want to return any records when validation fails
    //         // $query->where('0=1');
    //         return $dataProvider;
    //     }
    //
    //     $query->andFilterWhere([
    //         'ID' => $this->ID,
    //         'TGL1' => $this->TGL1,
    //         'SCDL_GROUP' => $this->SCDL_GROUP,
    //         'STATUS' => $this->STATUS,
    //         'CREATE_AT' => $this->CREATE_AT,
    //         'UPDATE_AT' => $this->UPDATE_AT,
    //     ]);
    //
    //     $query->andFilterWhere(['like', 'USER_ID', $this->USER_ID])
    //         ->andFilterWhere(['like', 'NOTE', $this->NOTE])
    //         ->andFilterWhere(['like', 'CREATE_BY', $this->CREATE_BY])
    //         ->andFilterWhere(['like', 'UPDATE_BY', $this->UPDATE_BY]);
    //
    //     return $dataProvider;
    // }
}
