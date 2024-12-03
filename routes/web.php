<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {


    $token = cache()->remember('token', 7200, function () {
        return \App\Services\ConnectLoginService::login(
            config('cameconnect.username'),
            config('cameconnect.password'),
        )->getBearer();
    });


    dump($token);


//    $service = new \App\Services\ConnectService();
//    return $service->test();
//    return view('welcome');
});
https://app.cameconnect.net/api/oauth/auth-code?
//client_id=9c8cca985f50940a8de2f14537c43ea5&response_type=code&
//redirect_uri=https://www.cameconnect.net/role&
//state=85e6dg729r1utblfip7lj89gxfovcjgwnu7qj1xztunazfxbltcj2xo68v3q0lm8mtbo5iam179z8dkghjvsi7w11xj2mi0dxz9m&nonce=kntkaqnb38yro269xdzbb9b9k1424y7mdm8dkhnz3eqo6golte3gkj8p72ffomuoeqk6myhkbsczmrk13oscdb466jsgyyeyy1a2&
//code_challenge=K6HcwNk5VqN6kmDbFw0S9Iuco0KdX7Fnpv_7U3jzwbM&code_challenge_method=S256
