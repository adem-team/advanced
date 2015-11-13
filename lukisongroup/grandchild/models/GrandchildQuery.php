<?php

namespace lukisongroup\grandchild\models;

/**
 * This is the ActiveQuery class for [[Grandchild]].
 *
 * @see Grandchild
 */
class GrandchildQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Grandchild[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Grandchild|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}