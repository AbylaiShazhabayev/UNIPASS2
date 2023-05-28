<?php

namespace App\Models;

use BenSampo\Enum\Enum;

final class PasswordType extends Enum
{
    const ApiKey = 1;
    const ComputerAccounts = 2;
    const Ftp = 3;
    const Mail = 4;
    const SoftwareLicense = 5;
    const Database = 6;
    const Website = 7;

    public static function getDescription($value): string
    {
        if ($value === self::ApiKey) {
            return 'API key';
        }

        if ($value === self::ComputerAccounts) {
            return 'Computer account';
        }

        if ($value === self::Ftp) {
            return 'FTP';
        }

        if ($value === self::Mail) {
            return 'Email';
        }

        if ($value === self::SoftwareLicense) {
            return 'Software license';
        }

        if ($value === self::Database) {
            return 'Database';
        }

        if ($value === self::Website) {
            return 'Login';
        }

        return parent::getDescription($value);
    }
}
