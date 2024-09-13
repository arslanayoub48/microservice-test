<?php
namespace App\Services;

use App\Models\Role;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Exception;

class UserService
{
    use ApiResponse;
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register($data)
    {
        DB::beginTransaction();
        try {
            $data['password'] = Hash::make($data['password']);
            $user = $this->userRepository->create($data);
            $role = Role::find($data['role_id']);
            $user->roles()->attach($data['role_id']);
//            $user->assignRole($role->name);
            DB::commit();
            return $this->successResponse($user, 'User registered successfully');
        } catch (Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Failed to register user', $e->getMessage(), 500);
        }
    }

    public function login($data)
    {
        try {
            $token = $this->userRepository->authenticate($data);
            if ($token) {
                return $this->successResponse(['token' => $token], 'Login successful');
            }
            return $this->errorResponse('Unauthorized', null, 401);
        } catch (Exception $e) {
            return $this->errorResponse('Failed to login', $e->getMessage(), 500);
        }
    }

    public function logout($user)
    {
        try {
            $user->token()->revoke();
            return $this->successResponse(null, 'User logged out successfully');
        } catch (Exception $e) {
            return $this->errorResponse('Failed to logout user', $e->getMessage(), 500);
        }
    }
}
