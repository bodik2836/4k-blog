<?php

namespace common\rbac;

use yii\rbac\Rule;
use common\models\User;

class PostRule extends Rule {

    public $name = 'rule.post';

    public function execute($currentUserId, $currentUserRole, $params)
    {
        $result = false;

        if (!isset($params['ref_user_id'])) return false;

        $currentUser = User::findOne($currentUserId);
        $refModel = User::findOne($params['ref_user_id']);
        
        if ($currentUserId == $refModel->getId()) {
            return true;
        }

        if ($currentUser->getRole() === 'manager') {
            $result = in_array($refModel->getRole(), ['user']);
        }

        if ($currentUser->getRole() === 'admin') {
            $result = in_array($refModel->getRole(), ['user', 'manager', 'admin']);
        }

        return $result;
    }

    
}