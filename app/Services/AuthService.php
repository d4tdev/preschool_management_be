<?php

namespace App\Services;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Repositories\Criteria\User\SortAndFilterUserCriteria;
use App\Repositories\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthService extends AbstractService
{
    protected Repository $userRepo;

    public function __construct(protected User $user)
    {
        $this->userRepo = new Repository($user);
    }

    public function login(LoginRequest $request): string|null
    {
        return auth()->attempt($request->validated());
    }

    public function register(Request $request)
    {
        $check = $this->userRepo->getInstance()->where('email', $request->email)
                                ->count();

        if (!empty($check)) {
            throw new \Exception('errors.email_exist');
        }

        $data = array_merge($request->toArray(), ['password' => bcrypt($request->password)]);
        return $this->userRepo->create($data);
    }


    public function updatePassword($user, Request $request)
    {
        if (!Hash::check($request->current_password, $user->password)) {
            throw new \Exception('errors.current_password_is_not_correct');
        }

        try {
            $data = [
                'password' => bcrypt($request->new_password),
            ];

            $user->update($data);

            return true;
        } catch (\Exception $e) {
            report($e);

            return false;
        }
    }

    public function listUser($filters, $sorts, $search, $limit)
    {
        return $this->userRepo->pushCriteria(
            new SortAndFilterUserCriteria($filters, $sorts, $search)
        )->paginate($limit);
    }

    public function getUser($id)
    {
        return $this->userRepo->find($id);
    }

    public function deleteUser($id)
    {
        $user = $this->getUser($id);
        return $user->delete();
    }
}
