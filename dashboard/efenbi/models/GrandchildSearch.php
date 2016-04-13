<?php

namespace lukisongroup\front\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use lukisongroup\front\models\Grandchild;
use lukisongroup\front\models\Child;

/**
 * GrandchildSearch represents the model behind the search form about `lukisongroup\grandchild\models\Grandchild`.
 */
class GrandchildSearch extends Grandchild
{
    /**
     * @inheritdoc
     */
    public $ParentsName;
    public $ChildName;
    public function rules()
    {
        return [
            [['GRANDCHILD_ID', 'CHILD_ID', 'PARENT_ID'], 'integer'],
            [['GRANDCHILD'], 'safe'],
            [['ParentsName'], 'safe'],
            [['ChildName'], 'safe'],
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
     public function search($params) {
    $query = Grandchild::find();
    $dataProvider = new ActiveDataProvider([
        'query' => $query,
    ]);
 
    /**
     * Setup your sorting attributes
     * Note: This is setup before the $this->load($params) 
     * statement below
     */
     $dataProvider->setSort([
        'attributes' => [
            'parent_id',
            'ParentsName' => [
                'asc' => ['fr001.parent' => SORT_ASC],
                'desc' => ['fr001.parent' => SORT_DESC],
                'label' => 'Parent Name'
            ],
            'ChildName' => [
                'asc' => ['fr000.CHILD_NAME' => SORT_ASC],
                'desc' => ['fr000.CHILD_NAME' => SORT_DESC],
                'label' => 'Child Name'
            ],

        ]
    ]);
 
    if (!($this->load($params) && $this->validate())) {
        /**
         * The following line will allow eager loading with country data 
         * to enable sorting by country on initial loading of the grid.
         */ 
        $query->joinWith(['parents']);
        $query->joinWith(['child']);
        return $dataProvider;
    }
 
   
  
    /* Add your filtering criteria */
 

    // filter by parent name
    $query->joinWith(['parents' => function ($q) {
        $q->where('fr001.parent LIKE "%' . $this->ParentsName . '%"');
    }]);
 
    return $dataProvider;
}
}