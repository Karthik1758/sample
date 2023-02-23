<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Form;
use App\Models\FormType;
use App\Models\Hoa;
use App\Models\HoaFormTypeMapping;
use App\Models\IfscCode;
use App\Models\ScrutinyItem;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        IfscCode::firstOrCreate([
            'ifsc_code' => "SBIN0020199",
            'bank_name' => "State Bank of India",
            'state' => "Telangana",
            'branch' => "shadnagar"
        ]);

        IfscCode::firstOrCreate([
            'ifsc_code' => "HDFC0004330",
            'bank_name' => "HDFC",
            'state' => "Telangana",
            'branch' => "shadnagar"
        ]);
        IfscCode::firstOrCreate([
            'ifsc_code' => "CNRB0000843",
            'bank_name' => "Canara",
            'state' => "Telangana",
            'branch' => "shadnagar"
        ]);

        Form::firstOrCreate([
            'form_number' => '58',
        ]);

        Form::firstOrCreate([
            'form_number' => '59',
        ]);

        FormType::firstOrCreate([
            'form_type'=>'WATER CHARGES',
            'form_number_id'=>"1",
        ]);
        FormType::firstOrCreate([
            'form_type'=>'STATIONARY CHARGES',
            'form_number_id'=>"2",
        ]);
        FormType::firstOrCreate([
            'form_type'=>'ELECTRICITY CHARGES',
            'form_number_id'=>"1",
        ]);
        Hoa::firstOrCreate([
            'mjh'=>'2055',
            'mjh_desc'=>'Police',
            'smjh'=>'00',
            'smjh_desc'=>'NA',
            'mih'=>'108',
            'mih_desc'=>'State Headquarters Police',
            'gsh'=>'00',
            'gsh_desc'=>'NA',
            'sh'=>'05',
            'sh_desc'=>'City Police Force',
            'dh'=>'130',
            'dh_desc'=>'Office Expenses',
            'sdh'=>'133',
            'sdh_desc'=>'Water and  Electricity Charges',
            'hoa'=>'2055001080005130133NVN',
            'hoa_tier'=>'2055-00-108-00-05-130-133-NVN'
        ]);
        ScrutinyItem::firstOrCreate([
            'description'=>'Whether corresponding vouchers are enclosed',
            'form_type_id'=>'1'
        ]);
        ScrutinyItem::firstOrCreate([
            'description'=>'Whether the bill is signed by theD D O, head of a/c is noted in 7 tier system, disccharge endorsement and non-drawl certificate with official seal in original(corbon copy not accepted)',
            'form_type_id'=>'1'
        ]);
        ScrutinyItem::firstOrCreate([
            'description'=>'Whether the specimen signature on record is matching with the specimen signature on the bill and covered under proper(ink signed) sanction by a competent with corrections and alterations are attested with full signature of the DDO',
            'form_type_id'=>'2'
        ]);
        ScrutinyItem::firstOrCreate([
            'description'=>"Whether the sanction proceeding enclosed is given by the competant authority and it is within the financial powers delegated in G.O 148 and other G.O'",
            'form_type_id'=>'3'
        ]);
        ScrutinyItem::firstOrCreate([
            'description'=>"Whether all sub vouchers or Invoices exceeding 1,000/-(proforma invoce not acceptable) are passed for payment with full siganture of the DDO and enclosed to the bill in support sanction amount",
            'form_type_id'=>'2'
        ]);
        ScrutinyItem::firstOrCreate([
            'description'=>"Whether the sales tax is recorded in the invoices and the income tax is recoverable at source on gross amount with prescribed rate",
            'form_type_id'=>'3'
        ]);
        ScrutinyItem::firstOrCreate([
            'description'=>"Whether the sales tax is recorded in the invoices and the income tax is recoverable at source on gross amount with prescribed rate",
            'form_type_id'=>'2'
        ]);
        ScrutinyItem::firstOrCreate([
            'description'=>"Whether the Bank details are enclosed",
            'form_type_id'=>'2'
        ]);

        HoaFormTypeMapping::firstOrCreate([
            'hoa'=>'2055001080005130133NVN',
            'form_type_id'=>'4'
        ]);
    }

}