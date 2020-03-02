<?php
namespace frontend\models\forms;

use common\models\Organization;

/**
 * Bill form
 */
class BillForm extends \common\models\forms\BillForm
{
    protected function findOrCreateOrganization()
    {
        $attributes = $this->getAttributes(null, ['quantity']);

        $organization = Organization::findOne($attributes);

        if (!$organization) {
            $organization = new Organization($attributes);
            $organization->save(false);
        }

        return $organization;
    }
}
