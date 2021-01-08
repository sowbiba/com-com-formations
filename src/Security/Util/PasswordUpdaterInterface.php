<?php

namespace App\Security\Util;

use Symfony\Component\Security\Core\User\UserInterface;

interface PasswordUpdaterInterface
{
    /**
     * Updates the hashed password in the user when there is a new password.
     *
     * The implement should be a no-op in case there is no new password (it should not erase the
     * existing hash with a wrong one).
     *
     * @return void
     */
    public function hashPassword(UserInterface $user);
}
