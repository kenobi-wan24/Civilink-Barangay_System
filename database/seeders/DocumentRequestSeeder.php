<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DocumentRequest;
use App\Models\DocumentType;
use App\Models\Resident;
use App\Models\User;

class DocumentRequestSeeder extends Seeder
{
    public function run(): void
    {
        $kenneth = Resident::where('resident_code', 'BRY-2026-0001')->first();
        $bruce   = Resident::where('resident_code', 'BRY-2026-0002')->first();
        $harry   = Resident::where('resident_code', 'BRY-2026-0003')->first();
        $tony    = Resident::where('resident_code', 'BRY-2026-0004')->first();
        $grace   = Resident::where('resident_code', 'BRY-2026-0005')->first();

        $clearance  = DocumentType::where('name', 'Barangay Clearance')->first();
        $residency  = DocumentType::where('name', 'Certificate of Residency')->first();
        $indigency  = DocumentType::where('name', 'Certificate of Indigency')->first();
        $pwd        = DocumentType::where('name', 'PWD Referral Letter')->first();
        $jobseeker  = DocumentType::where('name', 'First Time Job Seeker Certification')->first();
        $soloParent = DocumentType::where('name', 'Solo Parent Certification')->first();
        $goodMoral  = DocumentType::where('name', 'Certificate of Good Moral Character')->first();

        $admin = User::where('role', 'admin')->first();

        $requests = [
            // Kenneth - Barangay Clearance - Released
            [
                'request_code'     => 'REQ-2026-0001',
                'resident_id'      => $kenneth?->id,
                'document_type_id' => $clearance?->id,
                'purpose'          => 'Employment',
                'status'           => 'released',
                'requested_at'     => now()->subDays(10),
                'approved_at'      => now()->subDays(8),
                'released_at'      => now()->subDays(6),
                'approved_by'      => $admin?->id,
            ],
            // Bruce - Certificate of Residency - Approved
            [
                'request_code'     => 'REQ-2026-0002',
                'resident_id'      => $bruce?->id,
                'document_type_id' => $residency?->id,
                'purpose'          => 'Loan Application',
                'status'           => 'approved',
                'requested_at'     => now()->subDays(5),
                'approved_at'      => now()->subDays(3),
                'released_at'      => null,
                'approved_by'      => $admin?->id,
            ],
            // Harry - Solo Parent Certification - Pending
            [
                'request_code'     => 'REQ-2026-0003',
                'resident_id'      => $harry?->id,
                'document_type_id' => $soloParent?->id,
                'purpose'          => 'Government Assistance',
                'status'           => 'pending',
                'requested_at'     => now()->subDays(2),
                'approved_at'      => null,
                'released_at'      => null,
                'approved_by'      => null,
            ],
            // Tony - Good Moral Certificate - Rejected
            [
                'request_code'     => 'REQ-2026-0004',
                'resident_id'      => $tony?->id,
                'document_type_id' => $goodMoral?->id,
                'purpose'          => 'School Requirement',
                'status'           => 'rejected',
                'requested_at'     => now()->subDays(7),
                'approved_at'      => null,
                'released_at'      => null,
                'approved_by'      => $admin?->id,
            ],
            // Grace - Certificate of Indigency - Pending
            [
                'request_code'     => 'REQ-2026-0005',
                'resident_id'      => $grace?->id,
                'document_type_id' => $indigency?->id,
                'purpose'          => 'Medical Assistance',
                'status'           => 'pending',
                'requested_at'     => now()->subDay(),
                'approved_at'      => null,
                'released_at'      => null,
                'approved_by'      => null,
            ],
        ];

        foreach ($requests as $data) {
            if (!$data['resident_id'] || !$data['document_type_id']) continue;

            DocumentRequest::updateOrCreate(
                ['request_code' => $data['request_code']],
                $data
            );
        }
    }
}