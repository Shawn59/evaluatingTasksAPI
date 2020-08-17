<?php
namespace app\controllers;

use Yii;
use yii\rest\Controller;
use app\models\Users;

class UserController extends Controller
{
    /**
     * @inheritdoc
     */
    protected function verbs()
    {
        return [
            'registration' => ['post'],
        ];
    }

    /**
     * Регистрация для партнёра.
     */
    public function actionRegistration()
    {
        $result = [
            'result' => 'failed',
            'description' => ''
        ];
        $model = new Users();
        $model->setAttributes(Yii::$app->request->bodyParams);
        // клиент
        $model->role_id = 2;

        if ($model->save()) {
            $result['values'] = [
                'result' => 'success',
                'description' => 'Успешная регистрация'
            ];
        } elseif ($model->errorCode !== null) {
            $result['errors'] = $model->getErrors();
        }

        return $result;
    }
}
