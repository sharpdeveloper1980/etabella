<!DOCTYPE html>
<html>
<head>
	<title>Firebase</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>
<body>
<div class="row">
	<div class="col-sm-4"></div>
	<div class="col-sm-4 pl-2 pt-4 pr-2">
		<div class="row">
			<div class="col-sm-12">
				<h4>Client Page For Notification</h4>
			</div>
		</div>
	</div>
	<div class="col-sm-4">
	<div class="backup"></div>
	</div>
</div>
<!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/7.14.1/firebase-app.js"></script>

<!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#available-libraries -->
<script src="https://www.gstatic.com/firebasejs/7.14.1/firebase-analytics.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.14.1/firebase-auth.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.14.1/firebase-database.js"></script>

<script>
  // Your web app's Firebase configuration
  var firebaseConfig = {
    apiKey: "AIzaSyD0sy08Pmdf4G4JTQPcwPB2jMKOMEfF5Vg",
    authDomain: "education-2896a.firebaseapp.com",
    databaseURL: "https://education-2896a.firebaseio.com",
    projectId: "education-2896a",
    storageBucket: "education-2896a.appspot.com",
    messagingSenderId: "842700054615",
    appId: "1:842700054615:web:dcbd0af61b4b970edc4312",
    measurementId: "G-L0M7KR2M0T"
  };
  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);
  firebase.analytics();
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script type="text/javascript">
	$(document).on('click','#save_info',function(){
		var message=$('#message').val();
	    if(message=='')
			alert('Enter Message');
		else 
		{
			alert(message)
			if(message=='Start Presentation')
			{
				var data={'message':message};
				send_message(data)
				$('#message').val('');
			}
			else 
			{
				alert('Please Enter Valid Text')
			}
		}
	});
	function send_message(data)
	{
	  
	      var dbRef = firebase.database();
	      var contactsRef = dbRef.ref('notification/');
	      contactsRef.push(data)
	      contactsRef.on("child_added", function(snap,prevChildKey) {
	        alert('g')
	      });
	 }

	
	var i=1;
	var file_id=0;
	 function get_message()
	 {
	 	var token=0;
	    var dbRef1 = firebase.database();
	    var contactsRef1 = dbRef1.ref('notification/');
	    contactsRef1.on("value", function(data) {
	    d1=data.val();
	     // console.log(Object.keys(d1).length);
		 // alert(alert(Object.keys(d1).length))
		  $.each(d1, function (index, value) {
		  	
		  	//console.log(value);
		  	if(token)
		  	{
		  		//alert(value.file)
		  		console.log(i+' '+	Object.keys(d1).length)
		  		if(i==Object.keys(d1).length)
				{
					//alert('value.file')
					//alert(value.file)
					//alert("{{ url('open_presentation') }}/"+value.file)
					//alert(i+' '+	Object.keys(d1).length+' '+token)
					$("#join_Presentation").attr("href","{{ url('open_presentation') }}/"+value.file);
					$('#notification_popup').modal('show');	
				}
		  			
		  	}
			
			i++;
			if(i==Object.keys(d1).length+1)
			{
				i=1;
				token=1;
			}
	        });
	    });
	    
	 }
	 get_message();
</script>
</body>
</html>
<!-- The Modal -->
<div class="modal" id="notification_popup">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Presentation Started</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <a href="javascript:;" id="join_Presentation" class="btn btn-info btn-sm">Accept</a>
        <a href="javascript:;"  data-dismiss="modal" class="btn btn-danger btn-sm">Cancel</a>
      </div>
    </div>
  </div>
</div>