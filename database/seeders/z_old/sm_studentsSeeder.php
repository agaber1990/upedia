<?php

namespace Database\Seeders;

use App\User;
use App\SmStaff;
use App\SmParent;
use App\SmVehicle;
use App\SmClassRoom;
use App\SmAssignVehicle;
use App\SmDormitoryList;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
// use DB;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class sm_studentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker   = Faker::create();
        $base_Id = ['Male', 'Female', 'Others', 'Islam', 'Hinduism', 'Sikhism', 'Buddhism', 'Protestantism', 'A+', 'O+', 'B+', 'AB+', 'A-', 'O-', 'B-', 'AB-'];

        for ($i = 1; $i <= 200; $i++) {

            for ($class_id = 1; $class_id <= 1; $class_id++) {
                for ($section_id = 1; $section_id <= 1; $section_id++) {
                    $gender_id = 1 + $i % 2;

                    $student_First_Name = $student_User_Name = $faker->firstName($gender = 'male');
                    $student_Last_Name  = $faker->lastName($gender = 'male');
                    $student_full_name  = $student_First_Name . ' ' . $student_Last_Name;

                    //parents name genarator
                    $Father_First_Name = $Father_User_Name = $faker->firstName($gender = 'male');
                    $Father_Last_Name  = $faker->lastName($gender = 'male');
                    $Father_full_name  = $Father_First_Name . ' ' . $Father_Last_Name;

                    $Mother_First_Name = $faker->firstName($gender = 'female');
                    $Mother_Last_Name  = $faker->lastName($gender = 'female');
                    $Mother_full_name  = $Mother_First_Name . ' ' . $Mother_Last_Name;

                    //guardians name gebarator
                    $Guardian_First_Name = $faker->firstName($gender = 'male');
                    $Guardian_Last_Name  = $faker->lastName($gender = 'male');
                    $Guardian_full_name  = $Guardian_First_Name . ' ' . $Guardian_Last_Name;

                    $studentEmail = strtolower($student_User_Name) . $i . '@upedia.com';

                    //insert student user & pass
                    $newUser            = new User();
                    $newUser->role_id   = 2;
                    $newUser->full_name = $student_full_name;
                    $newUser->email     = $studentEmail;
                    $newUser->username  = $studentEmail;
                    $newUser->password  = Hash::make(123456);

                    $newUser->created_at = date('Y-m-d h:i:s');
                    $newUser->save();
                    $newUser->toArray();
                    $student_id = $newUser->id;

                    //insert student user & pass
                    $newUser            = new User();
                    $newUser->role_id   = 3;
                    $newUser->full_name = $Guardian_full_name;
                    $newUser->email     = $Guardian_First_Name . $i . '@upedia.com';
                    $newUser->username  = $Guardian_First_Name . $i . '@upedia.com';
                    $newUser->password  = Hash::make(123456);

                    $newUser->created_at = date('Y-m-d h:i:s');
                    $newUser->save();
                    $newUser->toArray();
                    $parents_id = $newUser->id;

                    $parent          = new SmParent();
                    $parent->user_id = $parents_id;

                    $parent->fathers_name       = $Father_full_name;
                    $parent->fathers_mobile     = rand(1000, 9999) . rand(1000, 9999);
                    $parent->fathers_occupation = 'Teacher';
                    $parent->fathers_photo      = '';

                    $parent->mothers_name       = $Mother_full_name;
                    $parent->mothers_mobile     = rand(1000, 9999) . rand(1000, 9999);
                    $parent->mothers_occupation = 'Housewife';
                    $parent->mothers_photo      = '';

                    $parent->guardians_name       = $Guardian_full_name;
                    $parent->guardians_mobile     = rand(1000, 9999) . rand(1000, 9999);
                    $parent->guardians_email      = $Guardian_First_Name . $i . '@upedia.com';
                    $parent->guardians_occupation = 'Businessman';
                    $parent->guardians_relation   = 'Brother';
                    $parent->relation             = 'Son';
                    $parent->guardians_photo      = '';

                    $parent->guardians_address = 'Dhaka-1219, Bangladesh';
                    $parent->is_guardian       = 1;

                    $parent->created_at = date('Y-m-d h:i:s');
                    $parent->save();
                    $parent->toArray();
                    $parents_id = $parent->id;


                    $driver = SmStaff::whereRole(9)->where('active_status', 1)->first();
                    $vehicle = SmVehicle::where('driver_id', $driver->id)->first();
                    $route = SmAssignVehicle::where('vehicle_id', $vehicle->id)->first();
                    $room = SmClassRoom::first();
                    $dormitory = SmDormitoryList::first();


                    DB::table('sm_students')->insert([
                        [
                            'user_id'                 => $student_id,
                            'parent_id'               => $parents_id,
                            'admission_no'            => $faker->numberBetween($min = 10000, $max = 90000),
                            'roll_no'                 => $faker->numberBetween($min = 10000, $max = 90000),
                            'class_id'                => $class_id,
                            'student_category_id'     => 1,
                            'role_id'     => 2,
                            'section_id'              => $section_id,
                            'session_id'              => 1,
                            'caste'                   => 'Asian',
                            'bloodgroup_id'           => 8 + $i % 8,

                            //transport section
                            'route_list_id'           => $route->route_id,
                            'vechile_id'              => $route->vehicle_id,
                            'driver_id'               => $driver->id,

                            'room_id'                 => $room->id,
                            'dormitory_id'            => $dormitory->id,

                            'national_id_no'          => '237864238764' . $i * $i,
                            'local_id_no'             => '237864238764' . $i * $i,

                            'religion_id'             => 3 + $i % 5,
                            'height'                  => 56,
                            'weight'                  => 45,

                            'first_name'              => $student_First_Name,
                            'last_name'               => $student_Last_Name,
                            'full_name'               => $student_full_name,

                            'date_of_birth'           => $faker->date($format = 'Y-m-d', $max = 'now'),
                            'admission_date'          => $faker->date($format = 'Y-m-d', $max = 'now'),

                            'gender_id'               => $gender_id,
                            'email'                   => $studentEmail,
                            'mobile'                  => '+8801234567' . $i,
                            'bank_account_no'         => '+8801234567' . $i,

                            'bank_name'               => 'DBBL',
                            'student_photo'           => '',

                            'current_address'         => 'Bangladesh',
                            'previous_school_details' => 'Bangladesh',
                            'aditional_notes'         => 'Bangladesh',

                            'permanent_address'       => 'Bangladesh',
                            'created_at' => date('Y-m-d h:i:s')
                        ],

                    ]);
                } //end loop section
            } //end loop class
        }




        $sm_students = DB::table('sm_students')->get();
        foreach ($sm_students as $row) {
            $data = array(
                'userid' => $row->user_id,
                'checktime' => date('Y-m-d H:s'),
                'terminalid' => 1,
                'name' => 'test ' . $row->full_name,
                'area_id' => 1,
                'class_id' =>  $row->class_id,
                'role_id' =>  $row->role_id,
                'section_id' => $row->section_id,
                'profile_id' => $row->id,
                'device_ip' => '192.168.0.1',
                'cloud_upload' => 0,
                'is_attendance' => 0,
            );
            // $data = DB::table('device_log')->insert($data);
        }

        
    }
}
