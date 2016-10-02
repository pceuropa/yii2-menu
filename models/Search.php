<?php
namespace pceuropa\menu\models;

use Yii;
use yii\data\ActiveDataProvider;
use pceuropa\menu\models\Model;
/**
 * Search represents the model behind the search form about `common\models\Model`.
 */
class Search extends Model {
    /**
     * @inheritdoc
     */
    public function rules(){
        return [
            [['menu_id'], 'integer'],
            [['menu'], 'string'],
        ];
    }

    /**
     * Creates data provider instance with search query applied
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Model::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'menu_id' => $this->menuId,
        ]);

        $query->andFilterWhere(['like', 'menu', $this->menu]);

        return $dataProvider;
    }
}
