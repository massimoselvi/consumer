<?php

// routes/web.php

// use GuzzleHttp\Client;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

// Route::get('/', function () {
// 	return view('welcome');
// });

Route::get('/', function () {
	$query = http_build_query([
		'client_id' => 3,
		'redirect_uri' => 'http://consumer.dev/callback',
		'response_type' => 'code',
		'scope' => 'conference',
	]);

	return redirect('http://passport.dev/oauth/authorize?' . $query);
});

Route::get('callback', function (Request $request) {
	$http = new GuzzleHttp\Client;

	$response = $http->post('http://passport.dev/oauth/token', [
		'form_params' => [
			'grant_type' => 'authorization-code',
			'client_id' => 3, // from admin panel above
			'client_secret' => 'g61H22de2sSZNaXdiirPwp7ok2qcAzxkFMsx6WkU', // from admin panel above
			'redirect_uri' => 'http://consumer.dev/callback',
			'code' => $request->code,
		],
	]);

	return json_decode((string) $response->getBody(), true)['access_token'];
});
Auth::routes();

Route::get('/home', 'HomeController@index');
