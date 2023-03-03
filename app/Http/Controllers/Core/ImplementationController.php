<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Core\Controller;
use Illuminate\Http\Request;

class ImplementationController extends Controller
{
    public function newImplementation(Request $request){

        // $this->valueSearchInArray();
        // $this->arrayToObjectConvertion();

        if(app()->environment('production')){
            abort(404);
        }

        dd('IMPLEMENTATION DONE');
    }

    private function valueSearchInArray(){
        $test_value = 2;
        $make_collection = 0;
        $array_key = 'onetest';
        $value = null;
        $get_first_or_last_value = true;
        $get_all_values = false;

        $dummy_data_1 = [
            'title' => 'Dashboard',
            'subtitle' => 'Welcome to Dashboard',
            'content' => 'This is content',
        ];

        $dummy_data_2 = [
            'title' => [
                'test2' => [
                    'test3' => 'Welcome to Dashboard',
                    'contentsss' => 'This is content',
                ],
                'test' => 'Dashboard',

                'test4' => 'Welcome to Dashboard',
                'test5' => [
                    'onetest' => [
                        1 => 'test 1',
                        'ki' => [
                            'chas',
                        ],
                    ],
                ],
            ],
            'subtitle' => [
                'sex' => 'Welcome to Dashboar ok',
            ],
            'content' => 'This is content2',
        ];


        if($test_value === 1){
            $take_data = $dummy_data_1;
        }else{
            $take_data = $dummy_data_2;
        }

        if($make_collection){
            $take_data = \collect($dummy_data_2);
        }

        // CHECK ARRAY SINGLE DIMENTIONAL OR MULTI ARRAY
        // dd($take_data);
        $value = findValueFormArray($take_data, $array_key);
        dd($value, $array_key);

        dd($take_data);

        $result = array_fetch($take_data, 'title');

        dd($result);

    }


    private function arrayToObjectConvertion(){

        $test_value = 2;
        $make_array = 1;

        $dummy_data_1 = [
            'title' => 'Dashboard',
            'subtitle' => 'Welcome to Dashboard',
            'content' => 'This is content',
        ];

        $dummy_data_2 = [
            'title' => [
                'test' => 'Dashboard',
                'test2' => [
                    'test3' => 'Welcome to Dashboard',
                    'content' => 'This is content',
                ],
                'test4' => 'Welcome to Dashboard',
                'content' => 'This is content',
                'test5' => [
                    'onetest' => [
                        1 => 'test 1',
                        'ki' => [
                            'chas',
                        ],
                    ],
                ],
            ],
            'subtitle' => [
                'sex' => 'Welcome to Dashboar ok',
            ],
            'content' => 'This is content2',
        ];

        if($test_value === 1){
            $take_data = $dummy_data_1;
        }else{
            $take_data = $dummy_data_2;
        }
        // dd($make_array, 'ok');
        if($make_array == 0){

            $take_data = collect([
                    $take_data
                    ])->first();

            // $take_data = collect($take_data);
        }

        // TEST CASE
        // $convert = arrayToObjectConvertion($take_data);
        // $convert = arrayToObjectConvertion($take_data)->title->test5->onetest->{1};
        // $convert = arrayToObjectConvertion($take_data)->title->test5->onetest->ki->chas;
        // $convert = arrayToObjectConvertion($take_data)->title->test5->onetest->ki->{0};

        // TEST CASE COLLECTION MECRO ADD


        // $convert = collect([
        //     $take_data
        // ])->arrayToCollection();

        // $convert = (collect(
        //     $take_data
        // )->arrayToCollection())->collectionToObject($take_data);

        // $convert = collect($take_data)->arrayToCollection()->collectionToObject();
        // $convert = collect($take_data)->collectionToObject();
        $convert = collectionToObjectConvertion($take_data);
        // $convert =
        dd($convert);

        dd( $convert , 'result');
    }
}
