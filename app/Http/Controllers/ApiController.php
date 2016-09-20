<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Response;
use DB;
use App;
use App\User;
use App\Sms;   
use App\Sports;  
use App\Areas; 
use App\Matchuser; 
use App\Matches; 
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
	public function index()
	{
		$user=User::wherePhone("Issayev")->first();
		return $user;
	}

	public function requestsms($mobile)
	{
					$free=" ";          
			
			$response = array();

			if(isset($mobile) && $mobile!=''){
			
				$free=User::wherePhone($mobile)->first();
				
				 if(!empty($free)){            
					$hex=hexdec(substr(md5($free->phone."<секретная строка>"), 7, 5));
					//Yii::$app->mycomponent->send_sms($mobile, "Ваш код подтверждения: ".$hex); 
					$response['error']=false;
					$response['message']="User updated success";
				 }else{
						$user = new User;        
						$user->phone = $mobile;
							if($user->save()){ 
									$sms=" "; 
							$hex=hexdec(substr(md5($mobile."<секретная строка>"), 7, 5));
							$sms=Sms::whereUserid($user->id)->first();
									 if(!empty($sms)){ 
											$sms->delete();
										}
													$smscodes= new Sms;
									$smscodes->userid =$user->id;
									$smscodes->smstypeid=1;
									$smscodes->code=$hex;
									if($smscodes->save()){
									
												// Yii::$app->mycomponent->send_sms($mobile, "Ваш код подтверждения: ".$hex);                                             
									
									}else{
										$response['error']=true;
										$response['message']="Failed sms code";  
									}
							$response['error']=false;
							$response['message']="User created success";  
						}
						else{            
								 $response['error']=true;
								 $response['message']="User create failed";
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
			
						$user= User::find($sms->userid);
						
						if($user->status==0){
						
								$response['olduser']=false;
							$user->status=1;            
								$user->save();  
							
						}else{
						
							 $response['olduser']=true;
							 
						}
						$response['profile']=$user;
						$response['error']=false;
						$response['code']=false;  
												
					}else{
					
						$response['error']=true;
						$response['code']=true;            
							
					}
			}else{
			
				$response['error']=true;  
				$response['code']=false;   
			}
			
			return Response::json($response);
			
	 }
		public function requestsports()
	{
		 try{           
						$sports = Sports::all();    
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
		 try {   
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
		 $org=DB::table('user')->select('user.id','user.name','user.email','user.phone')
					->where('user.id', '=', $organizer->user_id)
					->first();
		 array_push($res,$org);   
			 $mplayers = DB::table('match_user')->select('match_user.user_id')->where('match_user.match_id', '=', $matchid)->get();
		 foreach($mplayers as $d){
			 $user=DB::table('user')->select('user.id','user.name','user.email','user.phone')
					->where('user.id', '=', $d->user_id)
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
						$match_user = new Matchuser;        
				$match_user->sort_id = 1;
				$match_user->user_id = intval($userid);  
				$match_user->match_id = intval($matchid);
				$match_user->status =1;
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
			try{

				$days=array();
				$result=array();
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
							"11" => "Нбр", 
							"12" => "Дек");

							$day_r = array( 
							"0" => "Пнд", 
							"1" => "Втр", 
							"2" => "Срд", 
							"3" => "Чтв", 
							"4" => "Птн", 
							"5" => "Сбт", 
							"6" => "Вск");

						$result["year"] = $dt->format("Y-m-d");
						$result["month"] = $month_r[$dt->format("m")];
						$result["day"]= $dt->format("d");
						$result["weekday"]=$day_r[$dt->format("w")];
						array_push($days,$result);
				}  

				$response['days'] =$days;
				$schedules = DB::table('schedules')->join('fields', 'schedules.field_id', '=', 'fields.id')->select('fields.title','schedules.*')->where('schedules.area_id', '=', $playgroundid)->where('schedules.date', '=', $selecteddate)->get();             
				$response['schedules']= $schedules;
				$response['error']=false;
			}catch (Exception $e){
				$response['error']=true;
			}finally{
				return Response::json($response);
			}
		}

	public function requestmatchcreate($userid,$fieldid,$starttime,$endtime,$date,$matchtype,$gametype,$numberofplayers,$format,$price,$description,$playgroundid)
	{  
						$match = new Matches;        
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
}