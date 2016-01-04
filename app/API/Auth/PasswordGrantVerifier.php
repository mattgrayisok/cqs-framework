<?php

namespace App\API\Auth;

use Auth;

class PasswordGrantVerifier
{
  public function verify($username, $password)
  {
      $credentials = [
        'username'    => $username,
        'password' => $password,
      ];

      if (Auth::once($credentials)) {
          return Auth::user()->id;
      }

      return false;
  }
}