<?php
/**
 * NOTE: Nama Class harus diawali Hurup Besar
 * Server Linux 	: hurup besar/kecil bermasalah -case sensitif-
 * Server Windows 	: hurup besar/kecil tidak bermasalah
 * Author: -ptr.nov-
*/

namespace lukisongroup\sistem\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
  * Option user, employe, modul, permission
  * @author ptrnov  <piter@lukison.com>
  * @since 1.1
*/
class UserloginSearch extends Userlogin
{
	public $emp;
	public $salesNm;
	public $salesHp;
	//public $mdlakses;
	/*	[1] FILTER */
    public function rules()
    {
        return [
            [['username','EMP_ID','email'], 'string'],
            [['email','avatar','avatarImage'], 'string'],
			[['id','status','created_at','updated_at'],'integer'],
			[['POSITION_SITE','POSITION_LOGIN','salesNm','salesHp'], 'safe'],
        ];
    }

	/*	[4] SCNARIO */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

	/*	[5] SEARCH dataProvider -> SHOW GRIDVIEW */
    public function search($params)
    {
		/*[5.1] JOIN TABLE */
		$query = Userlogin::find();
        $dataProvider_Userlogin = new ActiveDataProvider([
            'query' => $query,
			'pagination'=>[
				'pageSize'=>100,
			]   
        ]);

		/*[5.3] LOAD VALIDATION PARAMS */
			/*LOAD FARM VER 1*/
			$this->load($params);
			if (!$this->validate()) {
				return $dataProvider_Userlogin;
			}

		/*[5.4] FILTER WHERE LIKE (string/integer)*/
			/* FILTER COLUMN Author -ptr.nov-*/
			 $query->andFilterWhere(['like', 'username', $this->username]);

        return $dataProvider_Userlogin;
    }


    /*	[5] SEARCH dataProvider -> SHOW GRIDVIEW */
    public function searchgroupplan($params)
    {
		/*[5.1] JOIN TABLE */
		$query = Userlogin::find()->where('POSITION_SITE="CRM" AND POSITION_ACCESS = 2 AND user.status <>1');

		$query->joinWith(['crmUserprofileTbl']);

        $dataProvider_Userlogin = new ActiveDataProvider([
            'query' => $query,
             'sort' =>false
        ]);

		/*[5.3] LOAD VALIDATION PARAMS */
			/*LOAD FARM VER 1*/
			$this->load($params);
			if (!$this->validate()) {
				
				return $dataProvider_Userlogin;
			}

			 // grid filtering conditions
        $query->andFilterWhere([
            'dbm001.user.status' => $this->status,
            // 'HP' => $this->salesHp,
            'NM_FIRST' => $this->salesNm,
        ]);

		/*[5.4] FILTER WHERE LIKE (string/integer)*/
			/* FILTER COLUMN Author -ptr.nov-*/

			 $query->andFilterWhere(['like', 'username', $this->username])
			    ->andFilterWhere(['like', 'dbm001.user.status', $this->status])
			     ->andFilterWhere(['like', 'user_profile.HP', $this->salesHp])
			      ->andFilterWhere(['like', 'user_profile.NM_FIRST', $this->salesNm]);

        return $dataProvider_Userlogin;
    }
	
	/*
	 * EMPTY CONDITION (SPEED LOAD CONTROLLER)
	 * LOAD BY TAB.
	*/
	public function searchEmpty($params)
    {
		$query = Userlogin::find()->where('status=100');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination'=>[
				'pageSize'=>0,
			]           
        ]);
        return $dataProvider;
    }
	
	public function attributes()
	{
		/*Author -ptr.nov- add related fields to searchable attributes */
		return array_merge(parent::attributes(), ['emp.EMP_IMG','emp.EMP_NM','emp.EMP_NM_BLK','Mdlpermission.ID','crmUserprofileTbl.HP']);
	}

	/**
	  * findUserAttr User and Employe
	  * @author ptrnov  <piter@lukison.com>
	  * @since 1.1
	*/
	public function findUserAttr($id)
    {
		$model = Userlogin::find()->select('*')
				->joinWith('emp',true,'LEFT JOIN')
				//->Where(['dbm001.user.id' => $id]);
				->Where("dbm001.user.id=".$id." AND EMP_STS<>'3'");

				//->one();
		if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

	/**
	  * findUserAttr User and Employe and Modul Permission
	  * @author ptrnov  <piter@lukison.com>
	  * @since 1.1
	*/
	public function findModulAcess($id,$modul_id)
    {
		$model = Userlogin::find()->select('*')
					->joinWith('emp',true,'LEFT JOIN')
					->joinWith('mdlpermission',true,'LEFT JOIN')
					->Where("dbm001.user.id=". $id ." AND modul_permission.MODUL_ID=" .$modul_id ." AND EMP_STS<>'3'");
		if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

	/*	CUST GROUP */
    public function searchCustGroup($params)
    {
		/*[5.1] JOIN TABLE */
		$query = Userlogin::find()
						->where("POSITION_SITE='CRM'");
        $dataProvider_Userlogin = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
				'pageSize' => 10,
			],
        ]);

		/*[5.3] LOAD VALIDATION PARAMS */
			/*LOAD FARM VER 1*/
			$this->load($params);
			if (!$this->validate()) {
				return $dataProvider_Userlogin;
			}

		/*[5.4] FILTER WHERE LIKE (string/integer)*/
			/* FILTER COLUMN Author -p	tr.nov-*/
			 $query->andFilterWhere(['like', 'username', $this->username]);
			 	 $query->andFilterWhere(['like', 'id', $this->id]);
        return $dataProvider_Userlogin;
    }


// searchCust

public function searchCust($params,$id)
{
/*[5.1] JOIN TABLE */
$query = Userlogin::find()->where(['id'=>$id]);
				// ->where("POSITION_SITE='CRM'");
		$dataProvider_Userlogin = new ActiveDataProvider([
				'query' => $query,
	'pagination' => [
		'pageSize' => 10,
	],
		]);

/*[5.3] LOAD VALIDATION PARAMS */
	/*LOAD FARM VER 1*/
	$this->load($params);
	if (!$this->validate()) {
		return $dataProvider_Userlogin;
	}

/*[5.4] FILTER WHERE LIKE (string/integer)*/
	/* FILTER COLUMN Author -ptr.nov-*/
	 $query->andFilterWhere(['like', 'username', $this->username]);
		return $dataProvider_Userlogin;
}
}
