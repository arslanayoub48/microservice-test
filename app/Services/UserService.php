<?php
namespace App\Services;

use App\Enums\TokenAbility;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Models\User;
use App\Traits\ApiResponse;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;

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
        $data['password'] = Hash::make($data['password']);
        $user = $this->userRepository->create($data);
        return $this->successResponse($user, 'User registered successfully');
    }

    public function login($data)
    {
        $token = $this->userRepository->authenticate($data);
        if ($token) {
            return $this->successResponse(['token' => $token], 'Login successful');
        }
        return $this->errorResponse('Unauthorized', null,401);
    }

    public function logout($user)
    {
        $user->token()->revoke();
        return $this->successResponse('', 'User logout successfully');
    }
}
