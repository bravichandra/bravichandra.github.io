<?php
	if($temp_content) {
		//Sorting with Custom sections
		$tsections = $this->_data['template_sections'];
		$ignored_sections = array();
		if($uCustTemplate['ignored_sections']) 
			$ignored_sections = $uCustTemplate['ignored_sections'];

		$ISleftNav=0;

		$newsections = array();
		foreach($temp_content as $tmpv) {
			$ISleftNav++;
			$partEle=array('name'=>'intro'.($ISleftNav>1?$ISleftNav:''),'title'=>$tmpv->sect_title,'content'=>$tmpv->sect_content,'sorder'=>$tmpv->sect_sort);
			$newsections[]=$partEle;
		}
		//Sort	
		$sorders = array();
		$t1= array();$ti=1;
		
		$si = 0;
		foreach($tsections as $sect) {
			if(in_array($sect->content_id,$ignored_sections)!==FALSE) continue;
			$this->_data['content_id']=$sect->content_id;
			//$this->_data['edittemp']=1;
			$sect->sect_content = $this->load->view('outputs/custom_content/custom_etemplate_data', $this->_data, TRUE);
			$indx = $ti++;
			$t1[$indx]=(array)$sect;
			$sorders[$indx]=$sect->sorting;
		}

		foreach($newsections as $t2) {
			$indx = $ti++;
			$t2['sect_content'] = $t2['content'];
			$t2['sect_title'] = $t2['title'];
			$t1[$indx]=$t2;						
			$sorders[$indx]=$t2['sorder'];
		}
		asort($sorders);
		$finalSort = array();
		$finalContents = array();
		$intros = '';
		foreach($sorders as $si=>$sval) {
			$ft1 = $t1[$si];
			$finalSort[$si] = $ft1;
			$finalContents[$si] = (object)$ft1;
		}

		$this->_data['template_sections'] = array();
		$temp_content=$finalContents;
		
		$tmpParts = $finalSort;


		$ISleftNav=$ti-1;

		
		
		$parts=$tmpParts;
		$pks = array_keys($parts);
		sort($pks);
		$lastid = end($pks);
	}	
?>