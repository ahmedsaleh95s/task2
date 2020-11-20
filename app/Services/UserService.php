<?php

namespace App\Services;

use App\Repositories\UserRepositories;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgetPassword;
use App\Repositories\AdminRepositories;
use App\Repositories\ServiceProviderRepositories;
use App\Repositories\WorkingHoursRepositories;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\HasAuthentication;
use Kreait\Firebase\DynamicLinks;
use Kreait\Firebase\DynamicLink\CreateDynamicLink\FailedToCreateDynamicLink;
use App\Traits\FileTrait;
use Carbon\Carbon;
use Illuminate\Support\Arr;

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
        $data['from'] = Carbon::parse($data['from']);
        $data['to'] = Carbon::parse($data['to']);
        $dateFrom = clone $data['from'];
        $dateTo = clone $data['to'];
        $workingHours = app(ServiceProviderRepositories::class)->workingHours($serviceProvider, (string)$dateFrom->dayOfWeek);
        $workingHour = $this->getInterval($workingHours, $serviceProvider, $dateFrom, $dateTo);
        $data['working_hour_id'] = $workingHour->id;
        $reservationCounts = app(WorkingHoursRepositories::class)->getWorkingHoursReservations($workingHour, $data['from'], $data['to']);
        if ($reservationCounts == 0) {
            $data['total'] = $this->calculateTotal($serviceProvider->price);
            $this->userRepo->reservation($data);
            return;
        }
        return abort(response()->json(["error" => ["Reservation Failed"]]));
    }

    public function getInterval($workingHours, $serviceProvider, $dateFrom, $dateTo)
    {
        if (count($workingHours) > 0) {
            foreach ($workingHours as $workingHour) {
                $start = $workingHour->from;
                while ($start < $workingHour->to) {
                    $intervals['from'] = $start;
                    $intervals['to'] = $start =
                        Carbon::parse($start)
                        ->addMinutes($serviceProvider->allowed_time)
                        ->format('h:i A');
                    if ($dateTo->format('h:i A') == $intervals['to'] && $dateFrom->format('h:i A') == $intervals['from']) {
                        return  $workingHour;
                    }
                }
            }
            return abort(response()->json(["error" => ["This Interval not matched"]], 422));
        }
        return abort(response()->json(["error" => ["No Working Hours exists"]], 422));
    }

    public function calculateTotal($price)
    {
        return $price + $price * (app(AdminRepositories::class)->getCommission() / 100);
    }

    public function all()
    {
        return $this->userRepo->all();
    }
}
