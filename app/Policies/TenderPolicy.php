<?php

namespace App\Policies;

use App\Enums\Area;
use App\Models\Tender;
use App\Models\TenderFile;
use App\Models\User;

/** Staff see the areas their role works in (Role::areas()); administrators see everything. */
class TenderPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->works(Area::Tenders);
    }

    public function view(User $user, Tender $tender): bool
    {
        return $user->works(Area::Tenders);
    }

    public function create(User $user): bool
    {
        return $user->works(Area::Tenders);
    }

    public function update(User $user, Tender $tender): bool
    {
        return $user->works(Area::Tenders);
    }

    public function delete(User $user, Tender $tender): bool
    {
        return $user->works(Area::Tenders);
    }

    /** Tender documents: estimating and administrators, and only files of this tender. */
    public function openFile(User $user, Tender $tender, TenderFile $file): bool
    {
        return $file->tender_id === $tender->id && $this->view($user, $tender);
    }
}
