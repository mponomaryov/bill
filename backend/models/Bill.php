<?php
namespace backend\models;

class Bill extends \common\models\Bill
{
    public function getPayerName()
    {
        return $this->payer->name;
    }

    public function getPayerItn()
    {
        return $this->payer->itn;
    }

    public function getPayerIec()
    {
        return $this->payer->iec;
    }
}
