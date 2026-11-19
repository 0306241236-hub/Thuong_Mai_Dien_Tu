<?php
namespace App\Repositories;
use App\Models\User;

class UserRepository extends BaseRepository
{
    public function getModel()
    {
        return User::class;
    }
    
    // BaseRepository đã có sẵn hàm create() nên không cần viết lại ở đây
}