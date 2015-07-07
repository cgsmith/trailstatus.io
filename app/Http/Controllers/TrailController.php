<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class TrailController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $date = new \DateTime('now', new \DateTimeZone('America/Chicago'));
        $trail['status'] = 'closed';
        $trail['date'] = $date->format('m-d-Y g:ia');
        if ('/json' === $request->getRequestUri()) {
            return response()->json([
                'name'=>'John Muir Trail',
                'coordinates'=>['42.821015','-88.601722'],
                'status'=>$trail['status'],
                'updated'=>$trail['date']
            ]);
        }
        return view('index',$trail);
    }

    /**
     * Initiate an outbound call and pull down John Muir trail info
     *
     * @param Request $request
     * @return string
     */
    public function update(Request $request, $token)
    {
        if ($token === config('UPDATE_TOKEN')) {
            abort(404);
        };
        $client = new \Services_Twilio(config('TWILIO_ACCOUNT_SID'), config('TWILIO_AUTH_TOKEN'));

        try {
            $call = $client->account->calls->create(config('CALL_FROM'), '2625946202', 'http://trailstatus.io/call.xml',
                array(
                    'Method' => 'GET',
                    'FallbackMethod' => 'GET',
                    'StatusCallbackMethod' => 'POST',
                    'StatusCallback' => 'http://trailstatus.io/recording',
                    'Timeout' => '60',
                    'Record' => 'true',
                ));
            echo 'Started call: ' . $call->sid;
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    /**
     * @param Request $request
     */
    public function persist(Request $request)
    {
        curl_setopt($ch, CURLOPT_URL, $request->input('RecordingUrl'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $out = curl_exec($ch);
        curl_close($ch);
        $fp = fopen('public/recording.wav', 'w');
        fwrite($fp, $out);
        fclose($fp);
    }

}