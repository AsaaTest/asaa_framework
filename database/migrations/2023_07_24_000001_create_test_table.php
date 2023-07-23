<?php

use Asaa\Database\DB;
use Asaa\Database\Migrations\Migration;

return new class() implements Migration {
    public function up() {
        DB::statement('CREATE TABLE test (id INT AUTO_INCREMENT PRIMARY KEY)');
    }

    public function down(){
        DB::statement('DROP TABLE test');
    }
};


