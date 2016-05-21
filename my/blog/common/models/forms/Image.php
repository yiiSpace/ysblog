<?php
/**
 * Created by PhpStorm.
 * User: yiqing
 * Date: 2016/5/21
 * Time: 22:05
 */

namespace my\blog\common\models\forms;


use yii\base\Model;

/**
 * Class Image
 * @package my\blog\common\models\forms
 */
class Image extends Model
{
    public $file;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        $rules = [];
        //
        $rules[] = [['file',], 'file', 'extensions' => 'jpeg,jpg, gif, png',
            'skipOnEmpty' => false
        ];
        return $rules;
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'file' => '请上传图片',
        ];
    }

}