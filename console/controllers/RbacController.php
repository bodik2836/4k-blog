<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use common\rbac\PostRule;

/**
 * Manages application RBAC.
 */
class RbacController extends Controller {

    public $defaultAction = 'up';

    /**
     * Init RBAC structure.
     */
    public function actionUp()
    {
        $auth = Yii::$app->authManager;

        // -- Rules
        $auth->removeAllRules();

        $rulePost = new PostRule();
        $auth->add($rulePost);

        // -- Permissions
        $auth->removeAllPermissions();

        // post
        $permissionPostCreate = $auth->createPermission("post.create");
        $auth->add($permissionPostCreate);

        $permissionPostRead = $auth->createPermission("post.read");
        $auth->add($permissionPostRead);

        $permissionPostUpdate = $auth->createPermission("post.update");
        $permissionPostUpdate->ruleName = $rulePost->name;
        $auth->add($permissionPostUpdate);

        $permissionPostDelete = $auth->createPermission("post.delete");
        $permissionPostDelete->ruleName = $rulePost->name;
        $auth->add($permissionPostDelete);

        // user
        $permissionUserUpdate = $auth->createPermission("user.update");
        $auth->add($permissionUserUpdate);

        $permissionUserRead = $auth->createPermission("user.read");
        $auth->add($permissionUserRead);
        

        // -- Roles
        $auth->removeAllRoles();

        $roleUser = $auth->createRole("user");
        $auth->add($roleUser);

        $roleManager = $auth->createRole("manager");
        $auth->add($roleManager);

        $roleAdmin = $auth->createRole("admin");
        $auth->add($roleAdmin);


        // -- Relations
        $auth->addChild($roleUser, $permissionPostCreate);
        $auth->addChild($roleUser, $permissionPostRead);
        $auth->addChild($roleUser, $permissionPostUpdate);
        $auth->addChild($roleUser, $permissionPostDelete);

        $auth->addChild($roleManager, $permissionPostCreate);
        $auth->addChild($roleManager, $permissionPostRead);
        $auth->addChild($roleManager, $permissionPostUpdate);
        $auth->addChild($roleManager, $permissionPostDelete);

        $auth->addChild($roleAdmin, $roleManager);
        $auth->addChild($roleAdmin, $permissionUserUpdate);
        $auth->addChild($roleAdmin, $permissionUserRead);

        printf("Command completed successfully. code: %d\n", ExitCode::OK);
        return ExitCode::OK;
    }

    /**
     * Clear all RBAC tables.
     */
    public function actionDown()
    {
        Yii::$app->authManager->removeAll();

        printf("Command completed successfully. code: %d\n", ExitCode::OK);
        return ExitCode::OK;
    }
}
