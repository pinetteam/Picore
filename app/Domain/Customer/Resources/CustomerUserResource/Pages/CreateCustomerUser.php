<?php

namespace App\Domain\Customer\Resources\CustomerUserResource\Pages;

use App\Domain\Customer\Resources\CustomerUserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomerUser extends CreateRecord
{
    protected static string $resource = CustomerUserResource::class;
}
