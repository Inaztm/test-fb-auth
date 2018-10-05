<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use App\Services\SocialAccountService;

class SocialAuthController extends Controller
{
    /**
     * Redirect the user to the social provider authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from social provider.
     *
     * @return Response
     */
    public function handleProviderCallback(SocialAccountService $service)
    {
        $user = $service->createOrGetUser( Socialite::driver('facebook')->user() );

        auth()->login($user);

        return redirect()->to('/');
    }

    public function logout(Request $request)
    {
        auth()->logout();

        return response()->json([
            'isAuth' => false
        ]);
    }

}
