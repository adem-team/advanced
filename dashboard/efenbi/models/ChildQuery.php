<?php

namespace lukisongroup\front\models;

/**
 * This is the ActiveQuery class for [[Child]].
 *
 * @see Child
 */
class ChildQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Child[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Child|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}