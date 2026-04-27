<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DocumentType;

class DocumentTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            [
                'name'          => 'Barangay Clearance',
                'description'   => 'General clearance for employment, legal, and other purposes.',
                'template_path' => 'documents.barangay-clearance',
            ],
            [
                'name'          => 'Certificate of Residency',
                'description'   => 'Certifies that the individual is a bona fide resident.',
                'template_path' => 'documents.certificate-of-residency',
            ],
            [
                'name'          => 'Certificate of Indigency',
                'description'   => 'Certifies that the individual belongs to an indigent family.',
                'template_path' => 'documents.certificate-of-indigency',
            ],
            [
                'name'          => 'Business Clearance',
                'description'   => 'Barangay-level clearance for business permit applications.',
                'template_path' => 'documents.business-clearance',
            ],
            [
                'name'          => 'Certificate of Good Moral Character',
                'description'   => 'Certifies the individual is of good moral character.',
                'template_path' => 'documents.good-moral-certificate',
            ],
            [
                'name'          => 'First Time Job Seeker Certification',
                'description'   => 'For first time job seekers per RA 11261.',
                'template_path' => 'documents.first-time-jobseeker',
            ],
            [
                'name'          => 'Solo Parent Certification',
                'description'   => 'Certifies the individual is a solo parent.',
                'template_path' => 'documents.solo-parent-certification',
            ],
            [
                'name'          => 'PWD Referral Letter',
                'description'   => 'Referral letter for persons with disability.',
                'template_path' => 'documents.pwd-referral',
            ],
        ];

        foreach ($types as $type) {
            DocumentType::create(array_merge($type, ['is_active' => 1]));
        }
    }
}