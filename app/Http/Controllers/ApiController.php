<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Response;
use DB;
use Auth;
use Storage;

use App;
use App\User;
use App\SMS;   
use App\Profile;
use App\Sport;  
use App\Area; 
use App\MatchUser; 
use App\Match; 
use App\Feedback;
use App\Http\Controllers\Controller;
use AbuLoot\Sms\MobizonApi as Mobizon;
class ApiController extends Controller
{
	public function requestprofile(Request $request)
	{
	$response=array();						
						
			if(isset($request->userid) && $request->userid!=''){
			 $user= User::find($request->userid);
						$user->name = $request->name;
						$user->surname =$request->surname;
						$user->email = $request->email;
						$user->save();
						$response['profile']=$user;
						$response['error']=false;						 				
			}else{
			
				$response['error']=true;	
			}
			
			return Response::json($response);
			
   }
	public function requestcallbacklist($userid)
	{
	   try {   
            $callbacks = DB::table('feedbacks')->where('user_id', '=', $userid)->get();	       
            $response['callbacks']= $callbacks;
            $response['error']=false;
        }catch (Exception $e){
            $response['error']=true;
        }finally{
            return Response::json($response);
        }
	}
	public function requestnewcallback(Request $request)
	{
	$response=array();						
						
			if(isset($request->userid) && $request->userid!=''){
			    $response['error']=false;
			    $feedback = new Feedback;				
				$feedback->user_id = $request->userid;
				$feedback->email = $request->email;	
				$feedback->text = $request->text;
						if($feedback->save()){ 
							$response['error']=false;
						}
						else{  	 	     
						     $response['error']=true;
						}						 				
			}else{
			
				$response['error']=true;	
			}
			
			return Response::json($response);
			
   }
	public function requestsms($mobile,$name,$surname,$email,$password,$sex)
	{
		  
		  $response = array();

			if(isset($mobile) && $mobile!=''){
			
				 $user=User::wherePhone($mobile)->first();
				 $code = rand(10000, 99999);
				 if($user==true){		
					            if ($user->status == 0) {
									$response['error']=true;
									$response['message']="Такой номер уже зарегестрирован, но не подтвержден. Проверьте sms сообщение или запросите повторное подтверждение номера.";
									return redirect()->back()->withInput()->withErrors('');
								}
								else {
								    $response['error']=true;
									$response['message']="Пользователь с таким номером уже зарегестрирован.";

								}
					
				 }else{				    
				     $responseApi = $this->sendSms($mobile, $code);
					 if($responseApi){					    
						$user = new User();
						$user->surname = $surname;
						$user->name = $name;
						$user->phone = $mobile;
						$user->email = $email;
						$user->password = bcrypt($password);
						$user->ip = \Request::ip();
						$user->location = serialize(\Request::ips());
						$user->status = 0;
						$user->balance="0";
						$user->save();

						$profile = new Profile;
						$profile->sort_id = $user->id;
						$profile->user_id = $user->id;
						$profile->phone = $mobile;
						$profile->sex = $sex;
						$profile->save();

						$sms = new SMS();
						$sms->user_id = $user->id;
						$sms->phone = $mobile;
						$sms->code = $code;
						$sms->save();					 					 					 					 
						$response['error']=false;
						$response['message']="На ваш номер был отправлен sms c кодом, введите его для подтверждение регистрации.";  												 
					 }else{
					      $response['error']=true;
						  $response['message']="Неверный номер телефона";
					 
					 }
				 }	
			}else{
			  
			 $response['error']=true;
	         $response['message']="Sorry!mobile number is missing";
			
			}
            
          return Response::json($response);
        
	}		
	public function requestverifyotp($otp)
	{
	$response=array();						
						
			if(isset($otp) && $otp!=''){
			
			 $sms= DB::table('sms')
              ->where('code', '=', $otp)
              ->first();
				    if(count($sms)>0){
			
						$user= User::find($sms->user_id);
						$user->status = 1;
						$user->save();
						$response['profile']=$user;
						$response['error']=false;
					}else{
					
						$response['error']=true;
							
					}
			}else{
			
				$response['error']=true;	
			}
			
			return Response::json($response);
			
   }
    public function requestlogin($phone,$password)
	{
		  $response = array();
			if(isset($phone) && $phone!=''){	
               if (Auth::attempt(['phone' => $phone, 'password' => $password, 'status' => 1])) {
                    $user=User::wherePhone($phone)->first();
					 if($user==true){		
							$response['profile']=$user;
							$response['error']=false;
					 }else{				    
						$response['error']=true;
					 }	
                }		
				else{			  
			      $response['error']=true;			
				}				  
				
			}else{			  
			 $response['error']=true;			
			}
            
          return Response::json($response);
			
   }
    public function requestsports()
	{
	   try{           
            $sports = Sport::all();    
            $response['sports']= $sports;
            $response['error']=false;
        }catch (Exception $e){
            $response['error']=true;
        }finally{
            return Response::json($response);
        }
	}
	public function requestplaygrounds($sportid)
	{
	   try{   
            $playgrounds = DB::table('areas')->where('sport_id', '=', $sportid)->get();	       
            $response['areas']= $playgrounds;
            $response['error']=false;
        }catch (Exception $e){
            $response['error']=true;
        }finally{
            return Response::json($response);
        }
	}	
	public function requestmatches($areaid)
	{		
	   try {   
	     $matches = DB::table('fields')
            ->join('matches', 'fields.id', '=', 'matches.field_id')
            ->select('matches.*')
			->whereIn('matches.field_id',DB::table('fields')->select('fields.id')->from('fields')->where('fields.area_id', '=', $areaid))					  
            ->get();       
            $response['matches']= $matches;
            $response['error']=false;
        }catch (Exception $e){
            $response['error']=true;
        }finally{
            return Response::json($response);
        }
	}
	public function requestmatchplayers($matchid)
	{	
     $res=array();		
	 try {   
	     $organizer = DB::table('matches')->select('matches.user_id')->where('matches.id', '=', $matchid)->first();
		 $org=DB::table('users')->select('users.id','users.name','users.email','users.phone')
				  ->where('users.id', '=', $organizer->user_id)
				  ->first();
		 array_push($res,$org);	 
	     $mplayers = DB::table('match_user')->select('match_user.user_id')->where('match_user.match_id', '=', $matchid)->get();
		 foreach($mplayers as $d){
		   $user=DB::table('users')->select('users.id','users.name','users.email','users.phone')
				  ->where('users.id', '=', $d->user_id)
				  ->first();
		   array_push($res,$user);	  
		}   
        $response['players']= $res;
        $response['error']=false;
        }catch (Exception $e){
            $response['error']=true;
        }finally{
            return Response::json($response);
        }
	}
	public function requestjoinmatch($matchid,$userid)
	{	
		        $match_user = new MatchUser;				
				$match_user->sort_id = 1;
				$match_user->user_id = intval($userid);	
				$match_user->match_id = intval($matchid);
				$match_user->status = 1;
				if($match_user->save()){ 
							$response['error']=false;
							$response['message']="Player joined success";  
						}
						else{  	 	     
						     $response['error']=true;
						     $response['message']="Player failed";
				}
						 
				return Response::json($response);
			
	}
	public function requestexitmatch($matchid,$userid)
	{	
		$deletedRows=DB::table('match_user')->where('user_id', '=', $userid)->where('match_id', '=', $matchid)->delete();
				if($deletedRows>0){ 
					$response['error']=false;
					$response['message']="Player deleted success";  
				}
				else{  	 	     
				    $response['error']=true;
				    $response['message']="Player failed";
				}				 
				return Response::json($response);
			
	}
	public function requestweekdays($playgroundid,$selecteddate){
									//$schedules = DB::table('schedules')->select('schedules.field_id','schedules.start_time','schedules.end_time','schedules.price','schedules.status','schedules.date')->where('schedules.field_id', '=', 1)->where('schedules.week', '=', 1)->get();
		try{   
		     $days=array();
			 $result=array();
			 $schresult=array();
			 $fullschedule=array();
			 $month_r = array();
			 $date_min= date("Y-m-d");
			 $date_max= date("Y-m-d",strtotime($date_min." + 7 day"));
			 $start = new \DateTime($date_min);
             $end = new \DateTime($date_max);   
		     $interval = \DateInterval::createFromDateString("1 day");
			 $period   = new \DatePeriod($start, $interval, $end);
		   foreach($period as $dt){
						$month_r=array(
						"01" => "Янв",	
						"02" => "Фев", 
						"03" => "Март", 
						"04" => "Апр", 
						"05" => "Май", 
						"06" => "Июнь", 
						"07" => "Июль", 
						"08" => "Авг", 
						"09" => "Сен", 
						"10" => "Окт", 
						"11" => "Ноя", 
						"12" => "Дек"); 
						$day_r = array( 
						"1" => "Пнд", 
						"2" => "Втр", 
						"3" => "Срд", 
						"4" => "Чтв", 
						"5" => "Птн", 
						"6" => "Сбт", 
						"0" => "Вск"); 
							  $result["year"] = $dt->format("Y-m-d");					
							  $result["month"] = $month_r[$dt->format("m")];												  						  						  
							  $result["day"]= $dt->format("d");     
							  $result["weekday"]=$day_r[$dt->format("w")];
							  array_push($days,$result);							  
			}	
		$hours=array(
					'0' => '05:00',
					'1' => '06:00',
					'2' => '07:00',
					'3' => '08:00',
					'4' => '09:00',
					'5' => '10:00',
					'6' => '11:00',
					'7' => '12:00',
					'8' => '13:00',
					'9' => '14:00',
					'10' => '15:00',
					'11' => '16:00',
					'12' => '17:00',
					'13' => '18:00',
					'14' => '19:00',
					'15' => '20:00',
					'16' => '21:00',
					'17' => '22:00',
					'18' => '23:00',
					'19' => '00:00',
					'20' => '01:00',
					'21' => '02:00',
					'22' => '03:00',
					'23' => '04:00');
            $response['days'] =$days;
			$week = new \DateTime($selecteddate);			
			$fields = DB::table('fields')->select('fields.id','fields.title')->where('fields.area_id','=',$playgroundid)->where('fields.status','=',1)->get();			
			foreach($fields as $field){
				$schedules = DB::table('schedules')->select('schedules.field_id','schedules.start_time','schedules.end_time','schedules.price','schedules.status','schedules.date')->where('schedules.field_id', '=', $field->id)->where('schedules.week', '=', $week->format("w"))->get();
				$times = DB::table('matches')->select('matches.field_id','matches.start_time','matches.end_time')->where('matches.field_id','=',$field->id)->where('matches.date','=',$selecteddate)->get();							
				foreach($hours as $hour){
						$schresult['start_time']=$hour;
						//$endTime = strtotime("+1 hour", strtotime($hour));
						//$schresult['end_time'] = date('h:i', $endTime);
						$schresult['end_time'] = $hour;
						$schresult['field_id']= $field->id;
						$schresult['title'] = $field->title;
						$schresult['status']=0;
					foreach($schedules as $schedule){
					    if($schedule->start_time <= $hour AND $schedule->end_time >= $hour){
						  $schresult['price']=$schedule->price;							  		
						  $schresult['date']=$schedule->date;							
						}						
					}
					foreach($times as $match){
					    if($match->start_time <= $hour AND $match->end_time > $hour){
						    $schresult['status']=1;
						}else{
							$schresult['status']=0;
						}
					}
					array_push($fullschedule,$schresult);
				}			
			}
	
			$response['schedules']= $fullschedule;	
					
			$response['error']=false;
		} catch (Exception $e) {
			$response['error'] = true;
		} finally {
			return Response::json($response);
		}
	}

	public function requestmatchcreate($userid,$fieldid,$starttime,$endtime,$date,$matchtype,$gametype,$numberofplayers,$format,$price,$description,$playgroundid)
	{	
		        $match = new Match;				
				$match->sort_id = 1;
				$match->user_id = intval($userid);	
				$match->field_id = intval($fieldid);
				$match->start_time = $starttime;
				$match->end_time = $endtime;
				$match->date = $date;
				$match->match_type = $matchtype;
				$match->game_type = $gametype;	
				$match->number_of_players = intval($numberofplayers);
				$match->game_format = $format;
				$match->price = intval($price);
				$match->description = $description;
				$match->playground_id = intval($playgroundid);		
				$match->status =0;
				if($match->save()){ 
							$response['error']=false;
							$response['message']="Match created success";  
						}
						else{  	 	     
						     $response['error']=true;
						     $response['message']="Create match failed";
						}
						 
				return Response::json($response);
			
	}
	    public function sendSms($phone,$code)
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
                        Storage::prepend('sms-log.txt', 'Message # ' . $messageInfo->id . " status:\t" . $messageInfo->status);
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

        Storage::prepend('sms-log.txt', PHP_EOL);

        return $response;
    }
}