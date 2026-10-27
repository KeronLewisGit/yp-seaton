<?php

namespace App\Policies;

use App\Enums\Area;
use App\Models\Vendor;
use App\Models\VendorDocument;
use App\Models\User;

/** Staff see the areas their role works in (Role::areas()); administrators see everything. */
class VendorPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->works(Area::Prequal);
    }

    public function view(User $user, Vendor $vendor): bool
    {
        return $user->works(Area::Prequal);
    }

    public function create(User $user): bool
    {
        return $user->works(Area::Prequal);
    }

    public function update(User $user, Vendor $vendor): bool
    {
        return $user->works(Area::Prequal);
    }

    public function delete(User $user, Vendor $vendor): bool
    {
        return $user->works(Area::Prequal);
    }

    /** Certificates (TCC, registration, insurance): procurement and administrators, only this vendor's. */
    public function openDocument(User $user, Vendor $vendor, VendorDocument $document): bool
    {
        return $document->vendor_id === $vendor->id && $this->view($user, $vendor);
    }
}
