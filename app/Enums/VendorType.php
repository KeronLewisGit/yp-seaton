<?php

namespace App\Enums;

enum VendorType: string
{
    case Subcontractor = 'subcontractor';
    case Supplier = 'supplier';
    case PlantHire = 'plant';
    case Consultant = 'consultant';

    public function label(): string
    {
        return match ($this) {
            self::Subcontractor => 'Subcontractor',
            self::Supplier => 'Materials supplier',
            self::PlantHire => 'Plant and equipment hire',
            self::Consultant => 'Professional services',
        };
    }

    /** @return list<DocumentKind> */
    public function requiredDocuments(): array
    {
        return match ($this) {
            self::Subcontractor => [DocumentKind::Tcc, DocumentKind::Registration, DocumentKind::Insurance],
            self::Supplier, self::PlantHire, self::Consultant => [DocumentKind::Tcc, DocumentKind::Insurance],
        };
    }
}
