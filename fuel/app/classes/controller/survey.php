<?php
	class Controller_Survey extends Controller_Hybrid{
	
	 
	public function before()
    {
        parent::before();
        Log::debug('Controller_REST Controller: ' . $this->request->controller);
        Log::debug('Controller_REST     Action: ' . $this->request->action);
    }    


	public function action_bbnew()
	{
		// if (!$this->authenticated) {
  //           $this->response(array('empty' => true, 'message' => 'Not logged in.'), 204);
  //           Response::redirect('/','refresh' );
  //           return;
  //       }
		if(isset($id) and $id != 'all' and $id != 'list' and $id !== false ){
			$result['q'] =DB::select('*')
					->from('releases')
					->join('divisions','LEFT')
					->on('divisions.division_id', '=', 'releases.funds_division')
					->join('districts','LEFT')
					->on('districts.id', '=', 'releases.funds_district')
					->where('releases.deleted','=',0)
					->order_by('funds_date','asc')
					->order_by('district_name','asc')
					->order_by('division_name','asc')
					->as_object()
					->execute();
		}else
		{

				$result['q'] =DB::select('*')
					->from('districts')
					->order_by('district_name')
					->as_object()
					->execute();
		}
        $this->template->title = 'MAPPING MIS VILLAGE WITH SURVEY';
        $this->template->content = View::forge('survey/bbnew', $result, false);
	}

	public function action_delete($id)
	{
		if(isset($id) and $id != 'all' and $id !='list' and $id != 'false')
		{
			$result =DB::delete('service_level')
					->where('service_level.sid','=',$id)
					->execute();
			$data =array('deleted' => 1);
			Session::set_flash('success','Record Deleted Successully');
			Response::redirect('survey/report','refresh' );		
		}
	}	

	public function action_save_survey()
	{
	

		if(Input::post('save_survey')){
			$survey = Input::all();
			//var_dump($funds);
			Log::debug("Service Level :" . print_r($survey,true));
			$wing_id 		= $survey['wing_id'];
			$circle_id		= $survey['circle_id'];
			$district_id 	= $survey['district'];
			$division_id 	= $survey['division'];
			$habitation_id	= $survey['habitation'];


    		$result =DB::select('*')
				->from('service_level')
				->where('wing_id', '=', $wing_id)
				->where('circle_id', '=', $circle_id)
				->where('district_id', '=', $district_id)
				->where('division_id','=', $division_id)
				->where('village_id','=', $habitation_id)
				->execute();

				$num_rows = count($result);
				if($num_rows >0)	
				{
				Session::set_flash('error','Record Already EXIST');		
				}else {

			$data =array(
					'wing_id'			=> $survey['wing_id'],
					'circle_id'			=> $survey['circle_id'],
					'district_id'		=> $survey['district'],
					'division_id'		=> $survey['division'],
					'village_id'		=> $survey['habitation'],
					'component'			=> $survey['component'],
					'supply_hours'		=> $survey['supply_hr'],
					'cost_recovery'		=> $survey['recovery'],
					// 'coverage_status'	=> $survey['coverage'],
					// 'house_connections' => $survey['connections'],
			);

			
					$result = DB::insert('service_level',array_keys($data))
						->values(array_values($data))
						->execute();


					
					session::set_flash('success','Data Added Successully');
				}	
     	
			Response::redirect('survey/bbnew' );
			#Response::redirect('statefunds/index');			
		}
	}

	public function action_slevel()
	{
	
    	$result['q'] =DB::select('*')
			->from('circle_component_2a')
			->join('circles','LEFT')
			->on('circle_component_2a.circle_id', '=', 'circles.id')
			->join('wings','LEFT')
			->on('circle_component_2a.wing_id', '=', 'wings.id')
			->order_by('wing_name','asc')
			->order_by('circle_name','asc')					
			->as_object()
			->execute();
		
		$this->template->content = View::forge('survey/slevel', $result, false);
	}

    public function action_report()
	{
		
				$result['q'] =DB::select('*')
					->from('service_level')
					->join('villages','left')
					->on('villages.village_misid','=','service_level.village_id')
					->join('divisions','LEFT')
					->on('divisions.division_id', '=', 'service_level.division_id')
					->join('districts','LEFT')
					->on('districts.id', '=', 'service_level.district_id')
					->where('service_level.deleted', '=',0)
					->order_by('district_name','asc')
					->order_by('division_name','asc')
					->order_by('village_name','asc')
					->as_object()
					->execute();
		

        $this->template->title = 'Funds Released';
        $this->template->content = View::forge('survey/report', $result, false);
	}
	public function get_mydivn()
	{
		\Log::Debug("In function GET inmydivn:");
		
		$this->response(array("test" => "hello"));
	}
	public function post_mydivn()
	{
		\Log::Debug("In function Post inmydivn:" . print_r($_POST,true));
		$id = \Input::post("districtid");
		// $this->param("id");//District ID
		\Log::Debug("In function Post inmydivn:" . $id);

		if(isset($id) and $id != 'all' and $id != 'list' and $id !== false ){
			
			$result =DB::select('*')
					->from('divisions')
					->join('districts','LEFT')
					->on('districts.id', '=', 'divisions.district_id')
					->join('circles','LEFT')
					->on('circles.id', '=', 'districts.circle_id')
					->where('divisions.district_id','=',$id)
					->order_by('division_name','asc')
					->as_assoc()
					->execute();
			
			$data['response'] = 'true';
			$data['message'] = array();
			foreach($result as $model){
				\Log::Debug("Returning Model:" . print_r($model,true));
				$data['message'][] = array('value' => $model['division_id'],
										   'text'  => $model['division_name'] );
			}		
			\Log::Debug("Returning data:" . print_r($data,true));
			$this->response($data);
		}	
	}
	public function post_myvill()
	{
		\Log::Debug("In function Post in my Village:" . print_r($_POST,true));
		$id = \Input::post("divisionid");
		// $this->param("id");//District ID
		\Log::Debug("In function Post in myvill:" . $id);

		if(isset($id) and $id != 'all' and $id != 'list' and $id !== false ){
			
			$result =DB::select('*')
					->from('underprogress')					
					->join('villages', 'left')
					->on('underprogress.code','=','villages.village_misid')
					->join('divisions','LEFT')
					->on('divisions.division_id', '=', 'villages.division_id')
					->where('villages.division_id','=',$id)
					->order_by('village_name','asc')
					->as_assoc()
					->execute();
			
			$data['response'] = 'true';
			$data['vill'] = array();
			foreach($result as $model){
				\Log::Debug("Returning Model:" . print_r($model,true));
				$data['vill'][] = array('value' => $model['village_misid'],
										'text'  => $model['village_name'],
										'wingid'  => $model['zone_id'],
										'circleid'  => $model['circle_id']
										    );
			}		
			\Log::Debug("Returning data:" . print_r($data,true));
			$this->response($data);
		}	
	}

	public function post_myhab()
	{
		\Log::Debug("In function Post in my Habitation:" . print_r($_POST,true));
		$id = \Input::post("habitationid");
		// $this->param("id");//District ID
		\Log::Debug("In function Post in my Habs:" . $id);

		if(isset($id) and $id != 'all' and $id != 'list' and $id !== false ){
			
			$result =DB::select('*')
					->from('villages')
					->where('villages.village_misid','=',$id)
					->as_assoc()
					->execute();
			
			$data['response'] = 'true';
			$data['habs'] = array();
			foreach($result as $model){
				\Log::Debug("Returning Model:" . print_r($model,true));
				$data['habs'][] = array('wingid' => $model['zone_id'],
								'circleid'  => $model['circle_id'] );
			}		
			\Log::Debug("Returning data:" . print_r($data,true));
			$this->response($data);
		}	
	}


}