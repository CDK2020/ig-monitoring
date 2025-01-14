<?php
/**
 * Created for IG Monitoring.
 * User: jakim <pawel@jakimowski.info>
 * Date: 11.01.2018
 */

namespace app\commands;


use app\models\Account;
use app\models\Tag;
use yii\console\Controller;
use yii\console\widgets\Table;

class MonitoringController extends Controller
{
    public function actionIndex()
    {
        $this->actionAccounts();
        $this->actionTags();
    }

    public function actionAccounts()
    {
        echo Table::widget([
            'headers' => [
                'ID',
                'Username',
                'Proxy ID',
            ],
            'rows' => Account::find()
                ->select([
                    'id',
                    'username',
                    'proxy_id',
                ])
                ->monitoring()
                ->asArray()
                ->all(),
        ]);
    }

    public function actionTags()
    {
        echo Table::widget([
            'headers' => [
                'ID',
                'Tag',
                'Proxy ID',
            ],
            'rows' => Tag::find()
                ->select([
                    'id',
                    'name',
                    'proxy_id',
                ])
                ->monitoring()
                ->asArray()
                ->all(),
        ]);
    }
}