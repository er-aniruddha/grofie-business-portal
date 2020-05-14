<?php

namespace Grofie\Http\Controllers\admin;

use Illuminate\Http\Request;
use Grofie\Http\Controllers\Controller;
use Grofie\Store;

class StoreController extends Controller
{
	
    public function index()
    {
    	$stores = Store::orderBy('store_id','DESC')->get();
    	return view('admin_v2.store.index',['stores' => $stores]);
    }
    public function create(Request $request)
    {
    	$validator = \Validator::make($request->all(), [
            'store_name' => 'required',
            'city' => 'required|max:255',
            'address' => 'required|max:255',
            'lat' => 'required|max:255|numeric',
            'long' => 'required|max:255|numeric',
        ]);
        
        if ($validator->fails())
        {
          return response()->json(['errors' => $validator->errors()]);
        }
        $store = new Store;
        $store->store_name = $request->store_name;
        $store->address = $request->address;
        $store->city = $request->city;
        $store->lat = $request->lat;
        $store->long = $request->long;
        $is_saved = $store->save();

       	if($is_saved){
            $tmessage = array('tmessage' => 'Store added successfully');
            return response()->json($tmessage); 
           }

    }
    public function delete($store_id)
    {
        Store::find($store_id)->delete();
        $tmessage = array('tmessage' => 'Store Deleted successfully');
        return response()->json($tmessage);  
    }
    //Show store name on address page in app
    public function show()
    {
        $stores = Store::orderBy('store_id','DESC')->get();
        return response()->json($stores);
    } 
}
// $geocode = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$long&sensor=false";
        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, $geocode);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        // $response = curl_exec($ch);
        // curl_close($ch);
        // $output = json($response);
        // $dataarray = get_object_vars($output);
        // if ($dataarray['status'] != 'ZERO_RESULTS' && $dataarray['status'] != 'INVALID_REQUEST') {
        //     if (isset($dataarray['results'][0]->formatted_address)) {

        //         $address = $dataarray['results'][0]->formatted_address;

        //     } else {
        //         $address = 'Not Found';

        //     }
        // } else {
        //     $address = 'Not Found';
        // }
        // $latx = $lat - 0.012;
        // $longx = $long + 0.006;
        // return $output;
        // $url = "https://api.mapbox.com/geocoding/v5/mapbox.places/$longx,$latx.json?access_token=pk.eyJ1IjoiYW5pcnVkZGhhc2luaGEiLCJhIjoiY2s0MDZ1aG9kMDA1czNtcnM2dDBoNHc1bSJ9.o3LprQ2ywvN1_QQGUTL1uQ";

        // Make the HTTP request
        // $data = @file_get_contents($url);
        // Parse the json response
        // $jsondata = json_decode($data,true);

        // If the json data is invalid, return empty array
        // if (!check_status($jsondata))   return array();

        // $address = array(
        //     'country' => google_getCountry($jsondata),
        //     'province' => google_getProvince($jsondata),
        //     'city' => google_getCity($jsondata),
        //     'street' => google_getStreet($jsondata),
        //     'postal_code' => google_getPostalCode($jsondata),
        //     'country_code' => google_getCountryCode($jsondata),
        //     'formatted_address' => google_getAddress($jsondata),
        // );

         // return $jsondata;
        // $apiKey = 'HZCMCBPDJJ1QUOVO499UWH4HR4GAUAYC';
        // $params['format']   = 'json';
        // $params['lat']      = $lat;
        // $params['lng']      = $long;

        // $query = '';

        // foreach($params as $key=>$value){
        //     $query .= '&' . $key . '=' . rawurlencode($value);
        // }

        ////////////
        //For https request, please make sure you have enabled php_openssl.dll extension.
        //
        //How to enable https
        //- Uncomment ;extension=php_openssl.dll by removing the semicolon in your php.ini, and restart the apache.
        //
        //In case you have difficulty to modify the php.ini, you can always make the http request instead of https.
        ////////////
        // $result = file_get_contents('https://api.geodatasource.com/city?key=' . $apiKey . $query);

        // $data = json_decode($result);

        // print_r($data);