<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Mail\EmailServiceMail;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

class EmailServiceController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request)
    {
        // Extract inputs
        $to = $request->input('to');
        $cc = $request->input('cc');
        $bcc = $request->input('bcc');
        $from = $request->input('from');
        $text = $request->input('text');
        $html = $request->input('html');
        $attach = $request->input('attach');
        $subject = $request->input('subject');

        try
        {
            if(is_array($to))
            {
                foreach ($to as $recipient)
                {
                    // Build mailer
                    Mail::to($recipient)
                        ->cc($cc)
                        ->bcc($bcc)
                        ->send(new EmailServiceMail($from, $text, $html, $attach, $subject));
                }
            }
            else
            {
                // Build mailer
                Mail::to($to)
                    ->cc($cc)
                    ->bcc($bcc)
                    ->send(new EmailServiceMail($from, $text, $html, $attach, $subject));
            }
        }
        catch(Exception $exception)
        {
            // Response
            return response()->json([
                'data' => $exception,
                'status' => false,
                'message' => 'Mail not send',
            ]);
        }

        // Response
        return response()->json([
            'data' => null,
            'status' => true,
            'message' => 'Mail send successfully',
        ]);
    }
}
