<?php namespace App\Traits;

use Hackzilla\PasswordGenerator\Generator\ComputerPasswordGenerator;

/**
 * Password Trait
 */
trait PasswordTrait
{
  public static function getPassword ()
  {
      $generator = new ComputerPasswordGenerator();

      $generator ->setUppercase(false) ->setLowercase(false) ->setNumbers() ->setSymbols(false) ->setLength(6);

      $password = $generator->generatePasswords();

      return $password[0];
  }
}
