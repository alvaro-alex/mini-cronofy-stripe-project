<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\CronofyCalendarCollection;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Inertia\Response;

class CronofyController extends Controller
{
    public function redirectToCronofy()
    {
        $params = [
            'response_type' => 'code',
            'client_id' => env('CRONOFY_CLIENT_ID'),
            'redirect_uri' => route('auth.cronofy.callback'),
            'scope' => 'read_write',
        ];

        return redirect('https://app.cronofy.com/oauth/authorize?' . http_build_query($params));
    }

    public function handleCallback(Request $request)
    {
        $code = $request->query('code');

        $response = Http::asForm()->post('https://api.cronofy.com/oauth/token', [
            'grant_type' => 'authorization_code',
            'client_id' => env('CRONOFY_CLIENT_ID'),
            'client_secret' => env('CRONOFY_CLIENT_SECRET'),
            'code' => $code,
            'redirect_uri' => route('auth.cronofy.callback'),
        ]);

        $accessToken = $response->json()['access_token'];

        // Store access token for the user
        User::find(auth()->id())->update(['cronofy_token' => $accessToken]);

        return redirect('/cronofy/calendars');
    }

    public function showCalendars(Request $request): Response
    {
        $user = auth()->user();
        // Check if the user is connected to Cronofy by verifying the presence of a token
        $accessToken = $user->cronofy_token;
        $calendars = $accessToken
            ? Http::withToken($accessToken)->get('https://api.cronofy.com/v1/calendars')->json()['calendars'] ?? []
            : [];
        return Inertia::render('Calendars/Index', [
            'isConnected' => !is_null($accessToken),
            'calendars' => array_map(function($entry) {
                return [
                    'source' => $entry['provider_name'],
                    'calendar_name' => $entry['calendar_name'],
                    'calendar_primary' => $entry['calendar_primary']
                ];
            }, $calendars),
        ]);
    }
}
