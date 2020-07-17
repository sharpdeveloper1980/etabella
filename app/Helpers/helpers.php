<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;
use App\Witness_file;
use App\Tagstatus;
use App\Tag;
use App\Download;
use App\Job;

class Helper
{
    public static function humanFileSize($size,$unit="") {
    {
      if( (!$unit && $size >= 1<<30) || $unit == "GB"){
	    	return number_format($size/(1<<30),2)."GB";
      	}elseif( (!$unit && $size >= 1<<20) || $unit == "MB"){
	    	return number_format($size/(1<<20),2)."MB";      	
      	}elseif( (!$unit && $size >= 1<<10) || $unit == "KB"){}
	    	return number_format($size/(1<<10),2)."KB";
	  		return number_format($size)." bytes";
    	}
	}

	public function get_witness_files($wid)
	{
		$witness_files=Witness_file::select(['witness_file.*','files.file_name','files.file_upload_name'])->where('witness_id',$wid)->orderBy('list_order','ASC')->join('files','witness_file.doc_id','=','files.file_id')->get()->toArray();
		return $witness_files;
	}
	public function get_file_tag($client_id,$file_id)
	{
		$tag_id=Tagstatus::where('client_id',$client_id)->where('file_id',$file_id)->get()->toArray();
		if(isset($tag_id[0]))
		{
		$color=Tag::where('id',$tag_id[0]['tag_id'])->get()->toArray();
		return $color[0]['color_tag'];
		}
		
		
	}
	public static function getjObName($job_id)
	{
		$job=Job::select('job_name')->where('job_id',$job_id)->get()->first();
		return $job->job_name;
	}
	public static function getJobs($job_id)
	{
		$alljobs = explode(',', $job_id); 
		return $jobs = Job::whereIn('job_id',$alljobs)->get();
	}
/*public function get_download_id($doc_id)
{
	$doc_info = Download::where('')
}*/
}