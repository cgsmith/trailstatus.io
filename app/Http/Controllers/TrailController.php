<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Lumen\Routing\Controller;

class TrailController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $trails = DB::select('select * from trails where id = ?', [1]);
        $trail = $trails[0]; //stupid but will refactor after feedback
        $date = new \DateTime($trail->updated, new \DateTimeZone('America/Chicago'));
        $trail->updated = $date->format('m-d-Y g:ia');
        $trail->recording = 'recording.wav';
        if ('/john-muir/json' === $request->getRequestUri()) {
            return response()->json($trail);
        }else if ('/john-muir/xml' === $request->getRequestUri()) {
            return response(view('xml',['trail'=>$trail]),200,['Content-Type','application/rss+xml']);
        }
        return view('index',['trail'=>$trail]);
    }

    /**
     * Initiate an outbound call and pull down John Muir trail info
     *
     * @param Request $request
     * @param $token
     * @return string
     * @throws \Exception
     */
    public function update(Request $request, $token)
    {
        if ($token !== $_ENV['UPDATE_TOKEN']) {
            abort(404);
        };
        $client = new \Services_Twilio($_ENV['TWILIO_ACCOUNT_SID'], $_ENV['TWILIO_AUTH_TOKEN']);

        try {
            $call = $client->account->calls->create($_ENV['CALL_FROM'], '2625946202', 'http://trailstatus.io/call.xml',
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
            throw $e;
        }
    }

    /**
     * @param Request $request
     * @throws \Exception
     */
    public function persist(Request $request)
    {
        // Get transcription
        $client = new \Services_Twilio($_ENV['TWILIO_ACCOUNT_SID'], $_ENV['TWILIO_AUTH_TOKEN']);
        try {
            // The only way i currently know to efficiently get a transcript
            $transcriptions = $client->account->transcriptions->getIterator(0, 1);

            foreach ($transcriptions as $transcription) {
                // sanity check to make sure the recording is what we think
                if ($transcription->recording_sid == $request->input('RecordingSid')) {
                    $status = (preg_match('/open/i',$transcription->transcription_text)) ? 'open' : 'closed';
                    $date = new \DateTime('now', new \DateTimeZone('America/Chicago'));
                    DB::table('trails')
                        ->where('id', 1)
                        ->update([
                            'updated' => $date->format('Y-m-d H:i:s'),
                            'translation'=> $transcription->transcription_text,
                            'status' => $status,
                            'callId' => $request->input('CallSid');
                        ]);
                }
            }
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
            throw $e;
        }

        // Download recording
        $ch = curl_init();
        $fp = fopen(__DIR__.'/../../../public/recording.wav', 'w+');
        curl_setopt($ch, CURLOPT_URL, $request->input('RecordingUrl'));
        curl_setopt($ch, CURLOPT_TIMEOUT, 50);
        curl_setopt($ch, CURLOPT_FILE, $fp); // write curl response to file
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);
        return response()->json('success');
    }

}