<?php

use common\models\User;
use common\rbac\Migration;

class m180321_102314_add_1c_role extends Migration {

    public function up() {

        $role = $this->auth->createRole(User::ROLE_API_USER);
        $this->auth->add($role);
        
        $this->auth->assign($role, 4);
        
        
    }

    public function down() {
        $this->auth->remove($this->auth->getRole(User::ROLE_API_USER));
    }

}
