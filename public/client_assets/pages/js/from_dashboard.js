resizeDiv();
	  function resizeDiv() {
		vpw = $(window).width();
		vph = $(window).height()-107;
		$(".pdf_container").css({'height': vph + 'px'});
	  }
   $.ajax({
           url:"http://66.206.3.50:6062/get_token_for_dashbord/"+pspdf_file_id,
           method:'GET',
           contentType:"application/json",
           success : function(resp){
      PSPDFKit.load({
        container: "#pspdfkit",
         documentId: pspdf_file_id,
         authPayload: { jwt: resp },
         instant: true,
      })
        .then(function(instance) {
          /**Hide toolbar section**/
          const viewState = instance.viewState;
          const curr_page = viewState.currentPageIndex+1;
          instance.setViewState(viewState.set("showToolbar", false));
			const state = instance.viewState;
           	const newState = state.set("scrollMode", "PER_SPREAD");
            instance.setViewState(newState);
		  })
        .catch(function(error) {
          console.error(error.message);
        });
     }
   });