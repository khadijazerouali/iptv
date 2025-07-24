<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Devicetype;
use Illuminate\Support\Str;

class ApplicationtypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        // Truncate table (reset auto-increment and clear)
        DB::table('applicationtypes')->truncate();

        // Get all devicetype UUIDs
        $devicetypeUuids = Devicetype::pluck('uuid')->toArray();

        // If no device types exist, we cannot proceed
        if (empty($devicetypeUuids)) {
            $this->command->error('No devicetypes found. Please seed devicetypes table first.');
            return;
        }

        // List of application names
        $applications = [
            'IPTV Smarters pro',
            'TiviMate iptv player',
            'Duplex Play',
            'Xciptv Player',
            'ibo player',
            'IPTV Extreme pro',
            'Gse smart iptv',
            'Nanomid Player',
        ];

        // Prepare the data
        $data = [];
        foreach ($applications as $name) {
            $data[] = [
                'uuid' => Str::uuid(), // assuming applicationtypes table has uuid PK
                'devicetype_uuid' => $devicetypeUuids[array_rand($devicetypeUuids)],
                'name' => $name,
                'deviceid' => 0,
                'devicekey' => 0,
                'otpcode' => 0,
                'smartstbmac' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert data
        DB::table('applicationtypes')->insert($data);
    }
}