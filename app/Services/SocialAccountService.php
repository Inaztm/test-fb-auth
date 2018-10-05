<?php

namespace App\Services;
use App\SocialAccount;
use App\User;
use Laravel\Socialite\Contracts\User as ProviderUser;
use File;

class SocialAccountService
{
    public function createOrGetUser(ProviderUser $providerUser)
    {
        $account = SocialAccount::whereProvider('facebook')
            ->whereProviderUserId($providerUser->getId())
            ->first();

        if ($account) {
            return $account->user;
        } else {

            $account = new SocialAccount([
                'provider_user_id' => $providerUser->getId(),
                'provider' => 'facebook'
            ]);

            $user = User::whereEmail($providerUser->getEmail())->first();

            if (!$user) {
                $user = User::create([
                    'email' => $providerUser->getEmail(),
                    'name' => $providerUser->getName(),
                    'avatar' => $providerUser->getAvatar(),
                    'password' => md5(rand(1,10000)),
                ]);

                $avatr_path = 'uploads/profile/' . $user->id . '.jpg';
                $fileContents = file_get_contents($providerUser->getAvatar());
                File::put(public_path() .'/'. $avatr_path, $fileContents);

                $user->avatar = $avatr_path;
                $user->save();
            }

            $account->user()->associate($user);
            $account->save();

            return $user;
        }
    }
}