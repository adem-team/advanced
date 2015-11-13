<?php

namespace lukisongroup\models\it;
use lukisongroup\models\it\Proggresjob;
use lukisongroup\models\it\Proggresjobdetail;
use lukisongroup\models\it\User;

/**
 * This is the ActiveQuery class for [[Proggresjob]].
 *
 * @see Proggresjob
 */
class ProggresjobQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Proggresjob[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Proggresjob|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
    public function progressall($proggres_id)
    {
      $model = Proggresjob::find()->where(['proggres_id' =>$proggres_id])->one(); 
      return $model;
    }
     public function progressalldetail($proggres_id)
    {
      $model = Proggresjobdetail::find()->where(['progress_id' =>$proggres_id])->all(); 
      return $model;
    }
    public function GetUsername($proggres_id)
    {
      $model = User::find()->where(['id' =>$proggres_id])->one(); 
      return $model;
    }
}