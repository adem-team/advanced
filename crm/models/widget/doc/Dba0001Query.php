<?php

namespace lukisongroup\models\widget\doc;

/**
 * This is the ActiveQuery class for [[Docdba]].
 *
 * @see Docdba
 */
class Dba0001Query extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Docdba[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Docdba|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}