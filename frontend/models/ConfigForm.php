<?php

namespace frontend\models;

use common\models\User;
use Yii;
use yii\base\Model;

/**
 * Config form 用户设置
 */
class ConfigForm extends Model
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['email', 'trim'],
            ['email', 'required'],
        ];
    }


    /*
     * 更改用户信息
     */
    public function updateInfo($id)
    {
        //开启事务
        $transaction = Yii::$app->db->beginTransaction();

        try {
            $model = User::findOne($id);

            //用户改变了头像,解码base64图片
            if ($_POST['isChangeIcon']=="true") {
                $fileUrl = $this->base64_image_convert($_POST['icon'], "uploads/userIcon/");
                $model->icon = $fileUrl;
            }

            //修改文章表
            $model->email = $_POST['email'];
            $model->sign = $_POST['sign'];
            $model->save();
            if ($model->save()) {
                $transaction->commit();
                return $model;
            }

        } catch (\Exception $e) {
            $transaction->rollBack();
            return false;
        }
    }

    public function base64_image_convert($base64_image, $path)
    {
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image, $result)) {
            $type = $result[2];
            $new_file = $path . date('Ymd', time()) . "/";
            if (!file_exists($new_file)) {
                mkdir($new_file, 0700);
            }
            $new_file = $new_file . time() . ".${type}";
            if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image)))) {
                return $new_file;
            } else {
                return false;
            }

        }

    }
}
