<?php

namespace App\Services;

use App\Repositories\UserRepositories;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgetPassword;
use App\Repositories\AdminRepositories;
use App\Repositories\ServiceProviderRepositories;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\HasAuthentication;
use Kreait\Firebase\DynamicLinks;
use Kreait\Firebase\DynamicLink\CreateDynamicLink\FailedToCreateDynamicLink;
use App\Traits\FileTrait;
use Carbon\Carbon;

class UserService
{

    use HasAuthentication;
    use FileTrait;
    private $userRepo, $dynamicLinks, $serviceProviderRepo;

    public function __construct(UserRepositories $userRepo, DynamicLinks $dynamicLinks, ServiceProviderRepositories $serviceProviderRepo)
    {
        $this->userRepo = $userRepo;
        $this->dynamicLinks = $dynamicLinks;
        $this->serviceProviderRepo = $serviceProviderRepo;
    }


    public function store($data)
    {
        $this->userRepo->store($data);
        if (!empty($data['photo'])) {
            $link['image'] = $this->uploadFile($data['photo'], "users");
            $this->userRepo->saveImage($link);
        }
    }

    public function forgetPassword($data, $auth)
    {
        $user = $this->userRepo->getBy('email', $data['email']);
        if ($user) {
            $token = $this->userRepo->saveRememberToken($user);
            $link = $this->getDynamicLink($token);
            Mail::to($user)->send(new ForgetPassword($link['shortLink']));
        }
    }

    public function resetPassword($data)
    {
        $this->userRepo->resetPassword($data);
    }

    public function getDynamicLink($token)
    {
        $url = config('app.url') . ":" . config('app.port') . "?token=" . $token;
        $link = json_encode($this->dynamicLinks->createShortLink($url));
        return json_decode($link, true);
    }

    public function distance($data)
    {
        return $this->serviceProviderRepo->distance($data);
    }

    public function reservation($data, $serviceProvider)
    {
        $date = Carbon::parse($data['from']);
        $workingHours = $this->userRepo->getProviderWorkingHour($serviceProvider, (string)$date->dayOfWeek, $date->format('h:i A'), $date->addMinutes($serviceProvider->allowed_time)->format('h:i A'));
        $has_reservations = $this->userRepo->getWorkingHoursReservations($workingHours, Carbon::parse($data['from']));
        if ($workingHours && ! $has_reservations) {
            $data['working_hour_id'] = $workingHours->id;
            $data['total'] = $this->calculateTotal($serviceProvider->price);
            $data['from'] = Carbon::parse($data['from']);
            $data['to'] = Carbon::parse($data['from'])->addMinutes($serviceProvider->allowed_time);
            $this->userRepo->reservation($data);
            return ;
        }
        return abort(response()->json(["error" => ["Reservation Failed"]]));
    }

    public function calculateTotal($price)
    {
        return $price + $price * (app(AdminRepositories::class)->getCommission() /100);
    }
    public function all()
    {
        return $this->userRepo->all();
    }
}
