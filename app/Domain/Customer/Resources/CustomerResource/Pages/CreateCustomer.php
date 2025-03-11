<?php

namespace App\Domain\Customer\Resources\CustomerResource\Pages;

use App\Domain\Customer\Resources\CustomerResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomer extends CreateRecord
{
    protected static string $resource = CustomerResource::class;
}
