<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use Storage;

use App\SMS;
use App\User;
use App\Profile;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use AbuLoot\Sms\MobizonApi as Mobizon;

class AuthCustomController extends Controller
{
    protected function postRegister(Request $request)
    {
		$phone = preg_replace('/[^0-9]/', '', $request->phone);

		$request->merge(['phone' => $phone]);

        $this->validate($request, [
            'surname' => 'required|min:2|max:40',
            'name' => 'required|min:2|max:40',
            'phone' => 'required|min:11|max:11|unique:users',
            // 'email' => 'required|email|max:255|unique:users',
            // 'day' => 'required|numeric|between:1,31',
            // 'month' => 'required|numeric|between:1,12',
            // 'year' => 'required|numeric',
            'sex' => 'required',
            'password' => 'required|min:6|max:255',
            'rules' => 'accepted'
        ]);

        if ($request->phone[0] == 8) {
        	$request->merge(['phone' => substr_replace($request->phone, '7', 0, 1)]);
        }

        $code = rand(10000, 99999);

        $responseApi = $this->sendSms($request->phone, $code);

        if ($responseApi == true) {

            $user = User::create([
                'surname' => $request->surname,
                'name' => $request->name,
                'phone' => $request->phone,
                'password' => bcrypt($request->password),
                'ip' => $request->ip(),
                'location' => serialize($request->ips()),
            ]);

            $profile = new Profile;
            $profile->sort_id = $user->id;
            $profile->user_id = $user->id;
            $profile->phone = $request->phone;
            // $profile->birthday = $request['year'].'-'.$request['month'].'-'.$request['day'];
            $profile->sex = $request['sex'];
            $profile->save();

            $sms = new SMS();
            $sms->user_id = $user->id;
            $sms->phone = $request->phone;
            $sms->code = $code;
            $sms->save();

            return redirect('confirm-register')->withInput();            
        }
        else {
            return redirect()->back()->with('status', 'Неверный Номер Телефона')->withInput();
        }
    }

    public function getConfirmRegister()
    {
        return view('auth.confirm-register');
    }

    public function postConfirmRegister(Request $request)
    {
        $phone = preg_replace('/[^0-9]/', '', $request->phone);

        $request->merge(['phone' => $phone]);

        $this->validate($request, [
            'phone' => 'required|min:11|max:11|unique:users',
            'code' => 'required|numeric|min:5'
        ]);

        if ($request->phone[0] == 8) {
            $request->merge(['phone' => substr_replace($request->phone, '7', 0, 1)]);
        }

        $sms = SMS::where('phone', $request->phone)
            ->where('code', $request->code)
            ->orderBy('created_at', 'desc')
            ->first();

        dd($sms);

        return view('auth.confirm-register');
    }

    public function sendSms($phone, $code)
    {
        $apiKey = config('sms.key');
        $mobizonApi = new Mobizon($apiKey);

        $alphaname = 'abusoft.kz'; // KAZINFO - Default alphaname MobizonApi
        $smsData = [
            'recipient' => $phone,
            'text'      => $code . ' - ваш код для регистрации в AbuSport',
            'from'      => $alphaname, //Optional, if you don't have registered alphaname, just skip this param and your message will be sent with our free common alphaname.
        ];

        // Create sms-log.txt if not exists
        if (!Storage::exists('sms-log.txt')) {
            Storage::disk('local')->put('sms-log.txt', 'Start');
        }

        if ($mobizonApi->call('message', 'sendSMSMessage', $smsData)) {

            $messageId = $mobizonApi->getData('messageId');

            // Record to sms-log.txt
            Storage::prepend('sms-log.txt', 'Message created with ID:' . $messageId . PHP_EOL);

            if ($messageId) {

                $response = true;

                // return 'Get message info...' . PHP_EOL;
                $messageStatuses = $mobizonApi->call('message', 'getSMSStatus', [
                        'ids' => [$messageId, '13394', '11345', '4393']
                    ], [], true
                );

                if ($mobizonApi->hasData()) {

                    foreach ($mobizonApi->getData() as $messageInfo)
                    {
                        Storage::prepend('sms-log.txt', 'Message # ' . $messageInfo->id . " status:\t" . $messageInfo->status . PHP_EOL);
                    }
                }
            }
        }
        else {

            $response = false;

            // Record to sms-log.txt
            Storage::prepend('sms-log.txt', 'An error occurred while sending message: [' . $mobizonApi->getCode() . '] ' . $mobizonApi->getMessage());
            Storage::prepend('sms-log.txt', json_encode($mobizonApi->getData()));
        }

        Storage::prepend('sms-log.txt', '\r\n');

        return $response;
    }

}
