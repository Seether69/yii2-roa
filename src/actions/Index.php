<?php

namespace tecnocen\roa\actions;

use Yii;
use yii\data\ActiveDataProvider;
use yii\base\InvalidConfigException;

class Index extends Action
{
    public $searchClass;

    public function init()
    {
        if (empty($this->searchClass)) {
            throw new InvalidConfigException(
                get_class($this) . '::$searchClass must be set.'
            );
        }
    }

    /**
     * @return ActiveDataProvider|ActiveRecord
     */
    public function run()
    {
        $searchClass = $this->searchClass;
        $searchModel = new $searchClass();
        $dataProvider = $searchModel->search(
            Yii::$app->request->queryParams,
            $this->searchFormName
        );
        $this->checkAccess($searchModel, $request->getQueryParams());

        return $dataProvider ?: $searchModel;
    }
}
