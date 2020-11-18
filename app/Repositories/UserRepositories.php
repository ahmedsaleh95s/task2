<?php

namespace App\Repositories;

use App\Enums\ProviderType;
use App\Interfaces\AuthInterface;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Admin;
use Carbon\Carbon;

class UserRepositories implements AuthInterface
{
    public $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    public function store($data)
    {
        $this->user = $this->user->create($data);
    }

    public function saveImage($link)
    {
        $this->user->image()->create($link);
    }

    public function resetPassword($data)
    {
        $user = $this->user->where('email', $data['email'])
        ->where('remember_token', $data['token'])->first();
        if (!$user) {
            return abort(response()->json(["error" => ["invalid credentials"]]));
        }
        $user->update(['password' => $data['password'], 'remember_token' => null]);
        $user->tokens()->delete();
    }

    public function getModel($username)
    {
        return $this->user->findForPassport($username);
    }

    public function getBy($column, $value)
    {
        return $this->user->where($column, $value)->first();
    }

    public function saveRememberToken($user)
    {
        $token = Str::random(60);
        $user->update(['remember_token' => $token]);
        return $token;
    }

    public function getProvider()
    {
        return ProviderType::USER;
    }

    public function reservation($data, $serviceProvider)
    {
        $dateFrom = $data['from'] = Carbon::parse($data['from']);
        $workingHours = $serviceProvider->workingHours()
        ->where('day', (string)$dateFrom->dayOfWeek) // from carbon
        ->where('from', '<=', $dateFrom->format('h:i A')) // from carbon
        ->first();
        if ($workingHours && !$workingHours->reservations()->where('from', '!=', $data['from'])->count()) {
            $data['working_hour_id'] = $workingHours->id;
            $data['to'] = $dateFrom->addMinutes($serviceProvider->allowed_time);
            $data['total'] = $serviceProvider->price + $serviceProvider->price * (Admin::first()->commission /100);
            auth()->user()->reservations()->create($data);
        }else {
            return abort(response()->json(["error" => ["no time avaiable"]]));
        }
    }

    public function all()
    {
        return $this->user->all();
    }
}