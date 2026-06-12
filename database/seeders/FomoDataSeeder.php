<?php

namespace Database\Seeders;

use App\Models\FomoData;
use Illuminate\Database\Seeder;

class FomoDataSeeder extends Seeder
{
    public function run(): void
    {
        $names = [
            'Priya', 'Ananya', 'Divya', 'Kavya', 'Sneha',
            'Pooja', 'Riya', 'Meera', 'Nisha', 'Sonal',
            'Deepa', 'Rekha', 'Sunita', 'Geeta', 'Lata',
            'Aisha', 'Fatima', 'Zara', 'Sara', 'Hina',
            'Rahul', 'Arjun', 'Vikram', 'Suresh', 'Rajan',
            'Amit', 'Rohan', 'Karan', 'Nikhil', 'Sanjay',
            'Deepak', 'Manoj', 'Ajay', 'Vijay', 'Ramesh',
            'Arun', 'Naveen', 'Sachin', 'Varun', 'Tarun',
            'Ishaan', 'Dhruv', 'Kabir', 'Aryan', 'Rehan',
            'Lakshmi', 'Parvati', 'Durga', 'Radha', 'Savita',
            'Mamta', 'Usha', 'Asha', 'Shobha', 'Kamla',
            'Harish', 'Dinesh', 'Sunil', 'Anil', 'Rakesh',
        ];

        $cities = [
            'Mumbai', 'Delhi', 'Bangalore', 'Hyderabad', 'Ahmedabad',
            'Chennai', 'Kolkata', 'Surat', 'Pune', 'Jaipur',
            'Lucknow', 'Kanpur', 'Nagpur', 'Indore', 'Thane',
            'Bhopal', 'Visakhapatnam', 'Pimpri', 'Patna', 'Vadodara',
            'Ludhiana', 'Agra', 'Nashik', 'Faridabad', 'Meerut',
            'Rajkot', 'Varanasi', 'Srinagar', 'Aurangabad', 'Dhanbad',
            'Amritsar', 'Allahabad', 'Ranchi', 'Gwalior', 'Coimbatore',
            'Vijayawada', 'Jodhpur', 'Madurai', 'Raipur', 'Kochi',
            'Chandigarh', 'Guwahati', 'Solapur', 'Hubli', 'Mysore',
            'Tiruchirappalli', 'Bareilly', 'Aligarh', 'Moradabad', 'Jabalpur',
            'Bhubaneswar', 'Salem', 'Warangal', 'Guntur', 'Bikaner',
            'Noida', 'Gurgaon', 'Navi Mumbai', 'Haridwar', 'Rishikesh',
        ];

        $karnatakaNames = [
            'Shruthi', 'Bhavana', 'Rashmi', 'Chaitra', 'Spoorthi',
            'Chandana', 'Spandana', 'Sindhu', 'Manjula', 'Nandini',
            'Suma', 'Veena', 'Geetha', 'Roopa', 'Sowmya',
            'Suresh', 'Prasad', 'Girish', 'Ravi', 'Srinivas',
            'Manjunath', 'Basavaraj', 'Shivaraj', 'Nagaraj', 'Siddarth',
            'Vinod', 'Mohan', 'Lokesh', 'Ganesh', 'Shiva',
            'Mahesh', 'Santosh', 'Praveen', 'Raghu', 'Krishna',
        ];

        $karnatakaPlaces = [
            'Bengaluru', 'Mysuru', 'Hubli', 'Dharwad', 'Mangaluru',
            'Belagavi', 'Kalaburagi', 'Ballari', 'Tumakuru', 'Shivamogga',
            'Davangere', 'Vijayapura', 'Bidar', 'Udupi', 'Raichur',
            'Chitradurga', 'Chikkamagaluru', 'Hassan', 'Mandya', 'Kolar',
            'Gadag', 'Koppal', 'Yadgir', 'Haveri', 'Bagalkot',
            'Chamarajanagar', 'Kodagu', 'Chikkaballapur', 'Ramanagara', 'Bengaluru Rural',
            'Kundapura', 'Sirsi', 'Bhadravati', 'Hospet', 'Gangavathi',
            'Ranebennur', 'Lakshmeshwar', 'Saundatti', 'Gokak', 'Nanjangud',
            'Channarayapatna', 'Arsikere', 'Kadur', 'Tarikere', 'Chintamani',
            'Robertsonpet', 'Hoskote', 'Nelamangala', 'Devanahalli', 'Anekal',
        ];

        $allNames = array_merge($names, $karnatakaNames);
        $allCities = array_merge($cities, $karnatakaPlaces);

        $newEntries = [];
        for ($i = 0; $i < 50; $i++) {
            $newEntries[] = [
                'fake_name' => $karnatakaNames[array_rand($karnatakaNames)],
                'fake_city' => $karnatakaPlaces[array_rand($karnatakaPlaces)],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        FomoData::insert($newEntries);
    }
}
