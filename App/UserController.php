<?php
namespace App;

use Core\Auth;
use Core\DB;

class UserController
{
    function __construct()
    {
    }

    public function login(string $login, string $password, bool $remember = false)
    {
        $token = Auth::login($login,$password,$remember);

        return [
          "code" => 200,
          "response" => $token
        ];
    }

    public function getListPaginated(int $page = 1, int $count = 5)
    {
        Auth::auth();
        $students = DB::queryAll( sprintf("SELECT * FROM `students` LIMIT %s OFFSET %s", $count, ($page - 1) * $count));
        $total = DB::query( "SELECT COUNT(*) as c FROM `students`");
        return [
            "code" => 200,
            "response" => $students,
            "total" => $total["c"]
        ];
    }

    public function logout()
    {
        return [
            "code" => 200,
            "response" => Auth::logout(),
        ];
    }
}
