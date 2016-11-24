<?php

namespace lukisongroup\purchasing\models\salesmanorder;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\debug\components\search\Filter;
use yii\debug\components\search\matchers;

/**
 * Salesman Order Header.
 * @uthor piter novian [ptr.nov@gmail.com].
 */
class SoHeaderSearch extends Model
{	
	public $TGL;
	public $CUST_KD;
	public $KD_BARANG;
	public $USER_ID;
	
    /**
     * @inheritdoc	
     */
    public function rules()
    {
        return [
            [['TGL','CUST_KD','KD_BARANG','USER_ID','TerminalID'], 'safe'],
        ];
    }

   	/*
	 * Search Manual Query
	 * @author ptrnov [piter@lukison.com]
	 * @since 1.2
	 *
	*/
	public function searchHeader($params){
		$soQueryJoin= Yii::$app->db_esm->createCommand("
			SELECT x1.ID,x1.TGL,x1.WAKTU_INPUT_INVENTORY,x1.CUST_KD,x1.CUST_NM,x1.KD_BARANG,x1.NM_BARANG,x1.SO_QTY,x1.SO_TYPE,x1.POS,x1.STATUS,x1.ID_GROUP,
				#x1.HARGA_PABRIK,x1.HARGA_DIS,x1.HARGA_LG,x1.HARGA_SALES,
				x1.KODE_REF,x1.USER_ID,x2.username,x3.NM_FIRST,x1.SUBMIT_QTY,x1.SUBMIT_PRICE,x1.NOTED,x4.ISI_MESSAGES,x5.CHECKIN_TIME,x5.CHECKOUT_TIME,
				x6.PIC,x6.TLP1,x6.KTP,x6.NPWP,x6.SIUP,x6.ALAMAT,x6.JOIN_DATE,x6.TLP1,x6.TLP2,x8.NM_UNIT,x8.QTY AS UNIT_QTY,x7.HARGA_SALES,
				x1.KODE_REF
			FROM so_t2 x1 
				LEFT JOIN dbm001.user x2 ON x2.id=x1.USER_ID
				LEFT JOIN dbm_086.user_profile x3 ON x3.ID_USER=x2.id
				LEFT JOIN c0014 x4 on x4.TGL=x1.TGL AND x4.ID_USER=x1.USER_ID
				LEFT JOIN c0002scdl_detail x5 on x5.TGL=x1.TGL AND x5.CUST_ID=x1.CUST_KD
				LEFT JOIN c0001 x6 on x6.CUST_KD=x1.CUST_KD
				LEFT JOIN b0001 x7 on x7.KD_BARANG=x1.KD_BARANG
				LEFT JOIN ub0001 x8 on x8.KD_UNIT=x7.KD_UNIT
				LEFT JOIN so_0001 x9 on x9.KD_SO=x1.KODE_REF
			WHERE x1.SO_TYPE=10 AND (x1.KODE_REF IS NOT NULL OR x9.KD_SO IS NOT NULL)
			GROUP BY x1.TGL,x1.USER_ID,x1.CUST_KD		
		")->queryAll();  
		
		$dataProvider= new ArrayDataProvider([
			//'key' => 'ID',
			'allModels'=>$soQueryJoin,			
			'pagination' => [
				'pageSize' => 500,
			]
		]);
		if (!($this->load($params) && $this->validate())) {
 			return $dataProvider;
 		}
		
		$filter = new Filter();
 		$this->addCondition($filter, 'TGL', true);
 		$this->addCondition($filter, 'CUST_KD', true);	
 		$this->addCondition($filter, 'KD_BARANG', true);	
 		$this->addCondition($filter, 'USER_ID', true);	
 		$dataProvider->allModels = $filter->filter($soQueryJoin);
		
		return $dataProvider;
	}
	
	
	/*
	 * Search Manual Query - INBOX 
	 * @author ptrnov [piter@lukison.com]
	 * @since 1.2
	 * JIKA CREATE_BY=ID (OUTBOX) ELSE INBOX OR
	 * [SIGN1,SIGN2,SIGN3,SIGN4,SIGN5]=id (OUTBOX) ELSE INBOX 
	*/
	public function searchHeaderInbox($params){
		$userLogin=Yii::$app->user->id;
		$soQueryJoin= Yii::$app->db_esm->createCommand("
			SELECT  x1.ID,x1.KD_SO_HEADER,x1.KD_SO_DETAIL,x1.KODE_REF,x1.TGL,x1.CUST_KD,x1.USER_SIGN1,x1.CREATE_BY,x1.CREATE_AT,x1.STT_PROCESS
					,x1.USER_SIGN2,x1.USER_SIGN3,x1.USER_SIGN4,x1.USER_SIGN5
					,x2.NM_FIRST,x3a.SIG2_NM,x3b.SIG3_NM,x3c.SIG4_NM,x3d.SIG5_NM
					,x4.CUST_NM,x4.PIC,x4.TLP1,x4.KTP,x4.NPWP,x4.SIUP,x4.ALAMAT,x4.ALAMAT_KIRIM,x4.JOIN_DATE,x4.TLP1,x4.TLP2
					,x5.CHECKIN_TIME,x5.CHECKOUT_TIME
					,x6.ISI_MESSAGES
			FROM
				(	SELECT a1.id as ID,a1.KODE_REF as KD_SO_DETAIL, b1.KD_SO as KD_SO_HEADER,b1.CREATE_BY,b1.CREATE_AT,b1.STT_PROCESS
							,(CASE WHEN a1.KODE_REF IS NULL THEN b1.KD_SO ELSE a1.KODE_REF END) AS KODE_REF
							,(CASE WHEN a1.CUST_KD IS NULL THEN b1.CUST_ID ELSE a1.CUST_KD END) As CUST_KD
							,(CASE WHEN a1.TGL IS NULL THEN date(b1.TGL) ELSE a1.TGL END) As TGL
							,(CASE WHEN a1.USER_ID IS NULL THEN b1.USER_SIGN1 ELSE a1.USER_ID END) As USER_SIGN1				
							,b1.USER_SIGN2,b1.USER_SIGN3,b1.USER_SIGN4,b1.USER_SIGN5
					FROM so_t2 a1 
					RIGHT JOIN so_0001 b1 on b1.KD_SO=a1.KODE_REF
					WHERE (a1.SO_TYPE=10 OR  a1.SO_TYPE IS NULL)
					GROUP BY a1.TGL,date(b1.TGL),a1.USER_ID,a1.CUST_KD,b1.CUST_ID
					UNION
					SELECT a1.id as ID,a1.KODE_REF as KD_SO_DETAIL, b1.KD_SO as KD_SO_HEADER,b1.CREATE_BY,b1.CREATE_AT,b1.STT_PROCESS
							,(CASE WHEN a1.KODE_REF IS NULL THEN b1.KD_SO ELSE a1.KODE_REF END) AS KODE_REF
							,(CASE WHEN a1.CUST_KD IS NULL THEN b1.CUST_ID ELSE a1.CUST_KD END) As CUST_KD
							,(CASE WHEN a1.TGL IS NULL THEN date(b1.TGL) ELSE a1.TGL END) As TGL
							,(CASE WHEN a1.USER_ID IS NULL THEN b1.USER_SIGN1 ELSE a1.USER_ID END) As USER_SIGN1		
							,b1.USER_SIGN2,b1.USER_SIGN3,b1.USER_SIGN4,b1.USER_SIGN5
					FROM so_t2 a1 
					LEFT JOIN so_0001 b1 on b1.KD_SO=a1.KODE_REF
					WHERE (a1.SO_TYPE=10 OR  a1.SO_TYPE IS NULL)
					GROUP BY a1.TGL,date(b1.TGL),a1.USER_ID,a1.CUST_KD,b1.CUST_ID
				) x1 LEFT JOIN dbm_086.user_profile x2 ON x2.ID_USER=x1.USER_SIGN1
						 LEFT JOIN (SELECT u1.id,u1.username,u2.EMP_NM AS SIG2_NM FROM dbm001.user u1 LEFT JOIN dbm002.a0001 u2 ON u2.EMP_ID=u1.EMP_ID)	x3a on x3a.id=x1.USER_SIGN2
						 LEFT JOIN (SELECT u1.id,u1.username,u2.EMP_NM AS SIG3_NM FROM dbm001.user u1 LEFT JOIN dbm002.a0001 u2 ON u2.EMP_ID=u1.EMP_ID)	x3b on x3b.id=x1.USER_SIGN3
						 LEFT JOIN (SELECT u1.id,u1.username,u2.EMP_NM AS SIG4_NM FROM dbm001.user u1 LEFT JOIN dbm002.a0001 u2 ON u2.EMP_ID=u1.EMP_ID)	x3c on x3c.id=x1.USER_SIGN4
						 LEFT JOIN (SELECT u1.id,u1.username,u2.EMP_NM AS SIG5_NM FROM dbm001.user u1 LEFT JOIN dbm002.a0001 u2 ON u2.EMP_ID=u1.EMP_ID)	x3d on x3d.id=x1.USER_SIGN5
						 LEFT JOIN c0001 x4 on x4.CUST_KD=x1.CUST_KD
						 LEFT JOIN c0002scdl_detail x5 on x5.TGL=x1.TGL AND x5.CUST_ID=x1.CUST_KD
						 LEFT JOIN c0014 x6 on x6.TGL=x1.TGL AND x6.ID_USER=x1.USER_SIGN1
					WHERE 
						(x1.STT_PROCESS<>'105' AND  x1.CREATE_BY<>'".$userLogin."')
						AND (x1.USER_SIGN1 IS NULL OR x1.USER_SIGN1<>'".$userLogin."')
						AND (x1.USER_SIGN2 IS NULL OR x1.USER_SIGN2<>'".$userLogin."') 
						AND (x1.USER_SIGN3 IS NULL OR x1.USER_SIGN3<>'".$userLogin."') 
						AND (x1.USER_SIGN4 IS NULL OR x1.USER_SIGN4<>'".$userLogin."')
						AND (x1.USER_SIGN5 IS NULL OR x1.USER_SIGN5<>'".$userLogin."')
		")->queryAll();  
		
		$dataProvider= new ArrayDataProvider([
			//'key' => 'ID',
			'allModels'=>$soQueryJoin,			
			'pagination' => [
				'pageSize' => 500,
			]
		]);
		if (!($this->load($params) && $this->validate())) {
 			return $dataProvider;
 		}
		
		$filter = new Filter();
 		$this->addCondition($filter, 'TGL', true);
 		$this->addCondition($filter, 'CUST_KD', true);	
 		$this->addCondition($filter, 'KD_BARANG', true);	
 		$this->addCondition($filter, 'USER_ID', true);	
 		$dataProvider->allModels = $filter->filter($soQueryJoin);
		
		return $dataProvider;
	}	
	
	/*
	 * Search Manual Query - OUTBOX
	 * @author ptrnov [piter@lukison.com]
	 * @since 1.2
	 * JIKA CREATE_BY=ID (OUTBOX) ELSE INBOX OR
	 * [SIGN1,SIGN2,SIGN3,SIGN4,SIGN5]=id (OUTBOX) ELSE INBOX 
	*/
	public function searchHeaderOutbox($params){
		$userLogin=Yii::$app->user->id;
		$soQueryJoin= Yii::$app->db_esm->createCommand("
			SELECT  x1.ID,x1.KD_SO_HEADER,x1.KD_SO_DETAIL,x1.KODE_REF,x1.TGL,x1.CUST_KD,x1.USER_SIGN1,x1.CREATE_BY,x1.CREATE_AT,x1.STT_PROCESS
					,x1.USER_SIGN2,x1.USER_SIGN3,x1.USER_SIGN4,x1.USER_SIGN5
					,x2.NM_FIRST,x3a.SIG2_NM,x3b.SIG3_NM,x3c.SIG4_NM,x3d.SIG5_NM
					,x4.CUST_NM,x4.PIC,x4.TLP1,x4.KTP,x4.NPWP,x4.SIUP,x4.ALAMAT,x4.ALAMAT_KIRIM,x4.JOIN_DATE,x4.TLP1,x4.TLP2
					,x5.CHECKIN_TIME,x5.CHECKOUT_TIME
					,x6.ISI_MESSAGES
			FROM
				(	SELECT a1.id as ID,a1.KODE_REF as KD_SO_DETAIL, b1.KD_SO as KD_SO_HEADER,b1.CREATE_BY,b1.CREATE_AT,b1.STT_PROCESS
							,(CASE WHEN a1.KODE_REF IS NULL THEN b1.KD_SO ELSE a1.KODE_REF END) AS KODE_REF
							,(CASE WHEN a1.CUST_KD IS NULL THEN b1.CUST_ID ELSE a1.CUST_KD END) As CUST_KD
							,(CASE WHEN a1.TGL IS NULL THEN date(b1.TGL) ELSE a1.TGL END) As TGL
							,(CASE WHEN a1.USER_ID IS NULL THEN b1.USER_SIGN1 ELSE a1.USER_ID END) As USER_SIGN1				
							,b1.USER_SIGN2,b1.USER_SIGN3,b1.USER_SIGN4,b1.USER_SIGN5
					FROM so_t2 a1 
					RIGHT JOIN so_0001 b1 on b1.KD_SO=a1.KODE_REF
					WHERE (a1.SO_TYPE=10 OR  a1.SO_TYPE IS NULL)
					GROUP BY a1.TGL,date(b1.TGL),a1.USER_ID,a1.CUST_KD,b1.CUST_ID
					UNION
					SELECT a1.id as ID,a1.KODE_REF as KD_SO_DETAIL, b1.KD_SO as KD_SO_HEADER,b1.CREATE_BY,b1.CREATE_AT,b1.STT_PROCESS
							,(CASE WHEN a1.KODE_REF IS NULL THEN b1.KD_SO ELSE a1.KODE_REF END) AS KODE_REF
							,(CASE WHEN a1.CUST_KD IS NULL THEN b1.CUST_ID ELSE a1.CUST_KD END) As CUST_KD
							,(CASE WHEN a1.TGL IS NULL THEN date(b1.TGL) ELSE a1.TGL END) As TGL
							,(CASE WHEN a1.USER_ID IS NULL THEN b1.USER_SIGN1 ELSE a1.USER_ID END) As USER_SIGN1		
							,b1.USER_SIGN2,b1.USER_SIGN3,b1.USER_SIGN4,b1.USER_SIGN5
					FROM so_t2 a1 
					LEFT JOIN so_0001 b1 on b1.KD_SO=a1.KODE_REF
					WHERE (a1.SO_TYPE=10 OR  a1.SO_TYPE IS NULL)
					GROUP BY a1.TGL,date(b1.TGL),a1.USER_ID,a1.CUST_KD,b1.CUST_ID
				) x1 LEFT JOIN dbm_086.user_profile x2 ON x2.ID_USER=x1.USER_SIGN1
						 LEFT JOIN (SELECT u1.id,u1.username,u2.EMP_NM AS SIG2_NM FROM dbm001.user u1 LEFT JOIN dbm002.a0001 u2 ON u2.EMP_ID=u1.EMP_ID)	x3a on x3a.id=x1.USER_SIGN2
						 LEFT JOIN (SELECT u1.id,u1.username,u2.EMP_NM AS SIG3_NM FROM dbm001.user u1 LEFT JOIN dbm002.a0001 u2 ON u2.EMP_ID=u1.EMP_ID)	x3b on x3b.id=x1.USER_SIGN3
						 LEFT JOIN (SELECT u1.id,u1.username,u2.EMP_NM AS SIG4_NM FROM dbm001.user u1 LEFT JOIN dbm002.a0001 u2 ON u2.EMP_ID=u1.EMP_ID)	x3c on x3c.id=x1.USER_SIGN4
						 LEFT JOIN (SELECT u1.id,u1.username,u2.EMP_NM AS SIG5_NM FROM dbm001.user u1 LEFT JOIN dbm002.a0001 u2 ON u2.EMP_ID=u1.EMP_ID)	x3d on x3d.id=x1.USER_SIGN5
						 LEFT JOIN c0001 x4 on x4.CUST_KD=x1.CUST_KD
						 LEFT JOIN c0002scdl_detail x5 on x5.TGL=x1.TGL AND x5.CUST_ID=x1.CUST_KD
						 LEFT JOIN c0014 x6 on x6.TGL=x1.TGL AND x6.ID_USER=x1.USER_SIGN1
			WHERE	x1.STT_PROCESS<>'105' AND 
					( 	x1.CREATE_BY='".$userLogin."'
						OR x1.USER_SIGN1='".$userLogin."' 
						OR x1.USER_SIGN2='".$userLogin."' 
						OR x1.USER_SIGN3='".$userLogin."' 
						OR x1.USER_SIGN4='".$userLogin."' 
						OR x1.USER_SIGN5='".$userLogin."'
					)			 
		")->queryAll();  
		
		$dataProvider= new ArrayDataProvider([
			//'key' => 'ID',
			'allModels'=>$soQueryJoin,			
			'pagination' => [
				'pageSize' => 500,
			]
		]);
		if (!($this->load($params) && $this->validate())) {
 			return $dataProvider;
 		}
		
		$filter = new Filter();
 		$this->addCondition($filter, 'TGL', true);
 		$this->addCondition($filter, 'CUST_KD', true);	
 		$this->addCondition($filter, 'KD_BARANG', true);	
 		$this->addCondition($filter, 'USER_ID', true);	
 		$dataProvider->allModels = $filter->filter($soQueryJoin);
		
		return $dataProvider;
	}

	/*
	 * Search Manual Query - HISTORY
	 * @author ptrnov [piter@lukison.com]
	 * @since 1.2
	 * JIKA CREATE_BY=ID (OUTBOX) ELSE INBOX OR
	 * [SIGN1,SIGN2,SIGN3,SIGN4,SIGN5]=id (OUTBOX) ELSE INBOX 
	*/
	public function searchHeaderHistory($params){
		$userLogin=Yii::$app->user->id;
		$soQueryJoin= Yii::$app->db_esm->createCommand("
			SELECT  x1.ID,x1.KD_SO_HEADER,x1.KD_SO_DETAIL,x1.KODE_REF,x1.TGL,x1.CUST_KD,x1.USER_SIGN1,x1.CREATE_BY,x1.CREATE_AT,x1.STT_PROCESS
					,x1.USER_SIGN2,x1.USER_SIGN3,x1.USER_SIGN4,x1.USER_SIGN5
					,x2.NM_FIRST,x3a.SIG2_NM,x3b.SIG3_NM,x3c.SIG4_NM,x3d.SIG5_NM
					,x4.CUST_NM,x4.PIC,x4.TLP1,x4.KTP,x4.NPWP,x4.SIUP,x4.ALAMAT,x4.ALAMAT_KIRIM,x4.JOIN_DATE,x4.TLP1,x4.TLP2
					,x5.CHECKIN_TIME,x5.CHECKOUT_TIME
					,x6.ISI_MESSAGES
			FROM
				(	SELECT a1.id as ID,a1.KODE_REF as KD_SO_DETAIL, b1.KD_SO as KD_SO_HEADER,b1.CREATE_BY,b1.CREATE_AT,b1.STT_PROCESS
							,(CASE WHEN a1.KODE_REF IS NULL THEN b1.KD_SO ELSE a1.KODE_REF END) AS KODE_REF
							,(CASE WHEN a1.CUST_KD IS NULL THEN b1.CUST_ID ELSE a1.CUST_KD END) As CUST_KD
							,(CASE WHEN a1.TGL IS NULL THEN date(b1.TGL) ELSE a1.TGL END) As TGL
							,(CASE WHEN a1.USER_ID IS NULL THEN b1.USER_SIGN1 ELSE a1.USER_ID END) As USER_SIGN1				
							,b1.USER_SIGN2,b1.USER_SIGN3,b1.USER_SIGN4,b1.USER_SIGN5
					FROM so_t2 a1 
					RIGHT JOIN so_0001 b1 on b1.KD_SO=a1.KODE_REF
					WHERE (a1.SO_TYPE=10 OR  a1.SO_TYPE IS NULL)
					GROUP BY a1.TGL,date(b1.TGL),a1.USER_ID,a1.CUST_KD,b1.CUST_ID
					UNION
					SELECT a1.id as ID,a1.KODE_REF as KD_SO_DETAIL, b1.KD_SO as KD_SO_HEADER,b1.CREATE_BY,b1.CREATE_AT,b1.STT_PROCESS
							,(CASE WHEN a1.KODE_REF IS NULL THEN b1.KD_SO ELSE a1.KODE_REF END) AS KODE_REF
							,(CASE WHEN a1.CUST_KD IS NULL THEN b1.CUST_ID ELSE a1.CUST_KD END) As CUST_KD
							,(CASE WHEN a1.TGL IS NULL THEN date(b1.TGL) ELSE a1.TGL END) As TGL
							,(CASE WHEN a1.USER_ID IS NULL THEN b1.USER_SIGN1 ELSE a1.USER_ID END) As USER_SIGN1		
							,b1.USER_SIGN2,b1.USER_SIGN3,b1.USER_SIGN4,b1.USER_SIGN5
					FROM so_t2 a1 
					LEFT JOIN so_0001 b1 on b1.KD_SO=a1.KODE_REF
					WHERE (a1.SO_TYPE=10 OR  a1.SO_TYPE IS NULL)
					GROUP BY a1.TGL,date(b1.TGL),a1.USER_ID,a1.CUST_KD,b1.CUST_ID
				) x1 LEFT JOIN dbm_086.user_profile x2 ON x2.ID_USER=x1.USER_SIGN1
						 LEFT JOIN (SELECT u1.id,u1.username,u2.EMP_NM AS SIG2_NM FROM dbm001.user u1 LEFT JOIN dbm002.a0001 u2 ON u2.EMP_ID=u1.EMP_ID)	x3a on x3a.id=x1.USER_SIGN2
						 LEFT JOIN (SELECT u1.id,u1.username,u2.EMP_NM AS SIG3_NM FROM dbm001.user u1 LEFT JOIN dbm002.a0001 u2 ON u2.EMP_ID=u1.EMP_ID)	x3b on x3b.id=x1.USER_SIGN3
						 LEFT JOIN (SELECT u1.id,u1.username,u2.EMP_NM AS SIG4_NM FROM dbm001.user u1 LEFT JOIN dbm002.a0001 u2 ON u2.EMP_ID=u1.EMP_ID)	x3c on x3c.id=x1.USER_SIGN4
						 LEFT JOIN (SELECT u1.id,u1.username,u2.EMP_NM AS SIG5_NM FROM dbm001.user u1 LEFT JOIN dbm002.a0001 u2 ON u2.EMP_ID=u1.EMP_ID)	x3d on x3d.id=x1.USER_SIGN5
						 LEFT JOIN c0001 x4 on x4.CUST_KD=x1.CUST_KD
						 LEFT JOIN c0002scdl_detail x5 on x5.TGL=x1.TGL AND x5.CUST_ID=x1.CUST_KD
						 LEFT JOIN c0014 x6 on x6.TGL=x1.TGL AND x6.ID_USER=x1.USER_SIGN1
				WHERE  x1.STT_PROCESS='105'
		")->queryAll();  
		
		$dataProvider= new ArrayDataProvider([
			//'key' => 'ID',
			'allModels'=>$soQueryJoin,			
			'pagination' => [
				'pageSize' => 500,
			]
		]);
		if (!($this->load($params) && $this->validate())) {
 			return $dataProvider;
 		}
		
		$filter = new Filter();
 		$this->addCondition($filter, 'TGL', true);
 		$this->addCondition($filter, 'CUST_KD', true);	
 		$this->addCondition($filter, 'KD_BARANG', true);	
 		$this->addCondition($filter, 'USER_ID', true);	
 		$dataProvider->allModels = $filter->filter($soQueryJoin);
		
		return $dataProvider;
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
