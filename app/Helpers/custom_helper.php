<?php
use App\Witness_file;
function get_witness_files($wid)
{
	$witness_files=Witness_file::select(['witness_file.*','files.file_name'])->where('witness_id',$wid)->orderBy('list_order','ASC')->join('files','witness_file.doc_id','=','files.file_id')->get()->toArray();
	return $witness_files;
}

function getjObName($job_id)
{
	$job=Job::select('job_name')->where('job_id',$id)->get()->first();
	return $job->job_name;
}
?>