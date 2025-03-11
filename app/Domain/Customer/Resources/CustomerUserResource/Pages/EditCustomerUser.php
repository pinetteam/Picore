<?php

namespace App\Domain\Customer\Resources\CustomerUserResource\Pages;

use App\Domain\Customer\Resources\CustomerUserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCustomerUser extends EditRecord
{
    protected static string $resource = CustomerUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
