<?php

namespace app\forms;

use yii\base\Model;

class XmlForm extends Model
{
    public $file;

    public function formName()
    {
        return '';
    }

    public function rules()
    {
        return [
            [['file'], 'required']
        ];
    }

    public function upload()
    {
        return file_get_contents($this->file->tempName);
    }
}