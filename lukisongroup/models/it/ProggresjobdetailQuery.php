<?php

namespace lukisongroup\models\it;

/**
 * This is the ActiveQuery class for [[Proggresjobdetail]].
 *
 * @see Proggresjobdetail
 */
class ProggresjobdetailQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Proggresjobdetail[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Proggresjobdetail|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}