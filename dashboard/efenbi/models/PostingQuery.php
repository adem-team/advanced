<?php

namespace lukisongroup\front\models;

/**
 * This is the ActiveQuery class for [[Posting]].
 *
 * @see Posting
 */
class PostingQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Posting[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Posting|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}