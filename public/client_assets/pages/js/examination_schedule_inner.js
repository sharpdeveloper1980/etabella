		 $( function() {
		$( "#sortable" ).sortable({
			stop: function(event, ui) {
			
				//console.log("New position: " + ui.item.index());
				//console.log();
				ids=[];
				for(i=0;i<$('#sortable').children().length;i++)
				{
					ids.push($($('#sortable').children()[i]).attr('id'))
				}
				$.post(baseurl+"/clients/change_order",{'id':ids,_token:$("input[name='_token']").val()},function(fb){
					console.log(fb);
				})
			}
		});
		$( "#sortable" ).disableSelection();
	  } );
	  $(document).on('click','#Modify',function(){
			id=$("input[class='witness']:checked").val();
			var c1=0;
			$(':checkbox:checked').each(function(i){
			  c1++;
			});
			if(id)
			{
				if(c1>1)
				{
					 toastr.error('Please select Only One Witness','Warning');
				}
				else 
				{
					var title=$('#wit_name_'+id).text();
					$('#witness_name').val(title);
					$('#witness_id').val(id);
					$('#Modify_witness').modal('show');
				}
			}
			else 
			{
				 toastr.error('Please select One Witness','Warning');
			}
			
	  });
	  $(document).on('click','#Delete',function(){
			id=$("input[class='witness']:checked").val();
			 var val = [];
			$(':checkbox:checked').each(function(i){
			  val[i] = $(this).val();
			});
			if(id)
			{
				swal({
				  title: "Are you sure?",
				  text: "Do You Want To Delete This Witness",
				  icon: "warning",
				  buttons: true,
				  dangerMode: true,
				})
				.then((willDelete) => {
				  if (willDelete) {
					$.post(baseurl+"/clients/delete_witness",{'id':val,_token:$("input[name='_token']").val()},function(fb){
						location.reload();
					})
					
				  }
				});
			}
			else 
			{
				 toastr.error('Please select Any Witness','Warning');
			}
			
	  });
	   function refreshPage(whchjobs){
			 $("#con").hide();
			 $(".hr_new3").hide();
			 $(".loader").show();
			 setTimeout(function () {
				window.location.reload();
				$('.loader').hide();
				$(".hr_new3").show();
				$("#treeDemo").show();  
			 }, 1000);
		  }
		$(document).on('click','#copy_witness',function(){
			id=$("input[class='witness']:checked").val();
			var c1=0;
			$(':checkbox:checked').each(function(i){
			  c1++;
			});
			if(id)
			{
				if(c1>1)
				{
					toastr.error('Please select Only One Witness','Warning');
				}
				else 
				{
					$('#witness_old_id').val(id);
					$('#copy_witness_popup').modal('show');
				}
			}
			else 
			{
				toastr.error('Please select Any Witness','Warning');
			}
		});
		$(document).on('keyup','.search_witness',function(){
			var value=$(this).val();
			$.post(baseurl+"/clients/search_witness",{'value':value,_token:$("input[name='_token']").val()},function(fb){
				var resp=$.parseJSON(fb);
				console.log(resp);
				if(resp.status=='true')
				{
					$('#witness_container').html('<ul class="list-group" id="sortable" ></ul>');
					console.log(resp.data);
					for(i=0;i<resp.data.length;i++)
					{
						var url=baseurl+"/clients/manage_docs/"+resp.data[i].id+"/{{ Session::get('job_id') }}";
						$('#sortable').append('<li class="list-group-item" id="'+resp.data[i].id+'" data-id="'+resp.data[i].id+'" ><div style=" float: left; width: 25px; padding-top: 3px; "><input class="witness" type="checkbox" value="'+resp.data[i].id+'" ></div><a href="'+url+'"><div><span id="wit_name_'+resp.data[i].id+'">'+resp.data[i].witness_name+'<i style=" float: right; " class="fa fa-chevron-right float-right" aria-hidden="true"></i></div></a></li>');
					}
					if(resp.mode=='ALL')
					{				
						$('#sortable').sortable({
							connectWith: '#mycontainer ul',
							placeholder: 'myplaceholder'
						});
					}
				}
				else 
				{
					$('#witness_container').html('<h3 align="center">Witness Not Found</h3>');
				}
			})
		});

		function goBack(job){
			window.location.href=baseurl+"/clients/examination_schedule/"+job;
		}