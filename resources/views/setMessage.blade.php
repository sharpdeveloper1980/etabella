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
				<div class="form-group">
					<label>Enter Message</label>
					<input type="text" id="message" class="form-control" placeholder="Enter Message">
				</div>
			</div>
			<div class="col-sm-12">
				<div class="form-group">
					<label>Select File</label>
					<select class="form-control" id="file">
						@foreach($files as $key => $data)
						<option value="{{ $data['download_id'] }}">{{ $data['file_name'] }}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="col-sm-12">
				<div class="form-group">
					<button class="btn btn-info" id="save_info">Save</button>
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-4">
	
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
		var file=$('#file').val();
	    if(message=='')
			alert('Enter Message');
		else if(file=='')
			alert('Please Select File')
		else 
		{
			if(message=='Start Presentation')
			{
				var data={'message':message,'file':file};
				send_message(data);
				window.location.href="{{ url('') }}/open_presentation_admin/"+file;
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
	      alert('Notification Send')
	      contactsRef.on("child_added", function(snap,prevChildKey) {
	        
	      });
	 }
</script>
</body>
</html>