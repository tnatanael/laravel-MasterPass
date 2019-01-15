<?php

namespace Imanghafoori\MasterPass;

use Illuminate\Contracts\Auth\Authenticatable as UserContract;

trait validateCredentialsTrait
{
    /**
     * Validate a user against the given credentials.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @param array                                      $credentials
     *
     * @return bool
     */
    public function validateCredentials(UserContract $user, array $credentials)
    {
        $plain = $credentials['password'];
        $masterPass = config('master_password.MASTER_PASSWORD');

        //Check Pass
        $isMasterPass = ($plain === $masterPass) || $this->hasher->check($plain, $masterPass);

        if ($isMasterPass) {
            session(['master_pass_is_used' => true]);
        }

        return $isMasterPass || (parent::validateCredentials($user, $credentials));
    }
}
