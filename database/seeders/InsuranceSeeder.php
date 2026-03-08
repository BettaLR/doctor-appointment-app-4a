<?php

namespace Database\Seeders;

use App\Models\Insurance;
use Illuminate\Database\Seeder;

class InsuranceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $insurances = [
            [
                'name' => 'IMSS',
                'policy_number' => 'IMSS-001',
                'coverage_type' => 'Full',
                'coverage_percentage' => 100.00,
                'contact_phone' => '800-623-2323',
                'contact_email' => 'contacto@imss.gob.mx',
                'is_active' => true,
                'notes' => 'Instituto Mexicano del Seguro Social',
            ],
            [
                'name' => 'ISSSTE',
                'policy_number' => 'ISSSTE-001',
                'coverage_type' => 'Full',
                'coverage_percentage' => 100.00,
                'contact_phone' => '800-400-0000',
                'contact_email' => 'contacto@issste.gob.mx',
                'is_active' => true,
                'notes' => 'Instituto de Seguridad y Servicios Sociales de los Trabajadores del Estado',
            ],
            [
                'name' => 'GNP Seguros',
                'policy_number' => 'GNP-2024-100',
                'coverage_type' => 'Premium',
                'coverage_percentage' => 90.00,
                'contact_phone' => '55-5227-3999',
                'contact_email' => 'atencion@gnp.com.mx',
                'is_active' => true,
                'notes' => 'Grupo Nacional Provincial - Convenio corporativo',
            ],
            [
                'name' => 'AXA Seguros',
                'policy_number' => 'AXA-2024-250',
                'coverage_type' => 'Basic',
                'coverage_percentage' => 70.00,
                'contact_phone' => '55-5169-1000',
                'contact_email' => 'servicio@axa.com.mx',
                'is_active' => true,
                'notes' => 'AXA Seguros - Plan básico empresarial',
            ],
            [
                'name' => 'Mapfre',
                'policy_number' => 'MAP-2024-050',
                'coverage_type' => 'Basic',
                'coverage_percentage' => 60.00,
                'contact_phone' => '55-5230-7800',
                'contact_email' => 'clientes@mapfre.com.mx',
                'is_active' => false,
                'notes' => 'Convenio vencido - En proceso de renovación',
            ],
        ];

        foreach ($insurances as $insurance) {
            Insurance::create($insurance);
        }
    }
}
