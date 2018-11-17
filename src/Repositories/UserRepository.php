<?php

namespace Quantox\Repositories;

use PDO;
use Quantox\DB;

class UserRepository

{
    public function getUsers()
    {
        $db = DB::getInstance();
        $stmt = $db->getConnection()->query("SELECT * FROM users");
        $r = [];
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $r[] = $row;
        }

        return $r;
    }
}