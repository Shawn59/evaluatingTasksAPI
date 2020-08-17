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

    protected function generatePasswordHash(string $password, string $login): string
    {
        return md5($password . md5(strlen($login) . $login));
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
        $model->password = $this->generatePasswordHash($model->password, $model->login);

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
