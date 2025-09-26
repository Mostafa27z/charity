<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DemoFullSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // 1️⃣ الجمعيات
        DB::table('associations')->insert([
            [
                'name'               => 'جمعية الخير',
                'registration_number'=> 'REG-001',
                'address'            => 'القاهرة - مدينة نصر',
                'phone'              => '01012345678',
                'email'              => 'khair@example.com',
                'status'             => 'active',
                'created_at'         => $now,
                'updated_at'         => $now,
            ],
            [
                'name'               => 'جمعية النور',
                'registration_number'=> 'REG-002',
                'address'            => 'الإسكندرية - سموحة',
                'phone'              => '01022334455',
                'email'              => 'noor@example.com',
                'status'             => 'active',
                'created_at'         => $now,
                'updated_at'         => $now,
            ],
            [
                'name'               => 'جمعية البر',
                'registration_number'=> 'REG-003',
                'address'            => 'الجيزة - المهندسين',
                'phone'              => '01033445566',
                'email'              => 'bir@example.com',
                'status'             => 'active',
                'created_at'         => $now,
                'updated_at'         => $now,
            ],
        ]);

        // 2️⃣ المستخدمون (جميعهم بكلمة مرور 12345678)
        DB::table('users')->insert([
            [
                'association_id' => 1,
                'name'           => 'أحمد علي',
                'email'          => 'ahmed.admin@example.com',
                'phone'          => '01055555551',
                'password'       => Hash::make('12345678'),
                'role'           => 'admin',
                'status'         => 'active',
                'created_at'     => $now,
                'updated_at'     => $now,
            ],
            [
                'association_id' => 1,
                'name'           => 'منى محمد',
                'email'          => 'mona.user@example.com',
                'phone'          => '01055555552',
                'password'       => Hash::make('12345678'),
                'role'           => 'user',
                'status'         => 'active',
                'created_at'     => $now,
                'updated_at'     => $now,
            ],
            [
                'association_id' => 2,
                'name'           => 'خالد سعيد',
                'email'          => 'khaled.admin@example.com',
                'phone'          => '01055555553',
                'password'       => Hash::make('12345678'),
                'role'           => 'admin',
                'status'         => 'active',
                'created_at'     => $now,
                'updated_at'     => $now,
            ],
            [
                'association_id' => 2,
                'name'           => 'سارة حسن',
                'email'          => 'sara.user@example.com',
                'phone'          => '01055555554',
                'password'       => Hash::make('12345678'),
                'role'           => 'user',
                'status'         => 'active',
                'created_at'     => $now,
                'updated_at'     => $now,
            ],
            [
                'association_id' => 3,
                'name'           => 'ليلى أحمد',
                'email'          => 'laila.admin@example.com',
                'phone'          => '01055555555',
                'password'       => Hash::make('12345678'),
                'role'           => 'admin',
                'status'         => 'active',
                'created_at'     => $now,
                'updated_at'     => $now,
            ],
        ]);

        // 3️⃣ المستفيدون
        DB::table('beneficiaries')->insert([
            [
                'national_id'   => '29801011234567',
                'first_name'    => 'محمود',
                'last_name'     => 'عبدالله',
                'gender'        => 'male',
                'birth_date'    => '1985-05-10',
                'phone'         => '01099999991',
                'address'       => 'القاهرة - شبرا',
                'family_size'   => 5,
                'income'        => 3000,
                'notes'         => 'حالة مرضية مزمنة',
                'association_id'=> 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            [
                'national_id'   => '29801011234568',
                'first_name'    => 'فاطمة',
                'last_name'     => 'حسين',
                'gender'        => 'female',
                'birth_date'    => '1990-07-15',
                'phone'         => '01099999992',
                'address'       => 'الإسكندرية - سيدي جابر',
                'family_size'   => 4,
                'income'        => 2500,
                'notes'         => 'أرملة تعول أطفال',
                'association_id'=> 2,
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            [
                'national_id'   => '29801011234569',
                'first_name'    => 'يوسف',
                'last_name'     => 'علي',
                'gender'        => 'male',
                'birth_date'    => '1982-09-20',
                'phone'         => '01099999993',
                'address'       => 'الجيزة - فيصل',
                'family_size'   => 6,
                'income'        => 2000,
                'notes'         => 'يحتاج دعم تعليمي',
                'association_id'=> 3,
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
        ]);

        // 4️⃣ المساعدات
        DB::table('aids')->insert([
            [
                'beneficiary_id'=> 1,
                'association_id'=> 1,
                'aid_type'      => 'financial',
                'amount'        => 1500,
                'description'   => 'مساعدة مالية شهرية',
                'aid_date'      => '2025-09-20',
                'created_by'    => 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            [
                'beneficiary_id'=> 2,
                'association_id'=> 2,
                'aid_type'      => 'food',
                'amount'        => 700,
                'description'   => 'سلة غذائية',
                'aid_date'      => '2025-09-18',
                'created_by'    => 3,
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            [
                'beneficiary_id'=> 3,
                'association_id'=> 3,
                'aid_type'      => 'medical',
                'amount'        => 1200,
                'description'   => 'علاج مزمن',
                'aid_date'      => '2025-09-19',
                'created_by'    => 5,
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
        ]);
    }
}
