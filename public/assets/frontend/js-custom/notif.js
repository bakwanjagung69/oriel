var pageIndex = 0;
$( document ).ready(function() {  
  // getNotif();
  // handleInfiniteScroll();
  	
});

function handleInfiniteScroll() {
	$('.notif-list').scroll(function() {
	   if(Math.round($(this).scrollTop() + $(this).innerHeight()) == $(this)[0].scrollHeight) {
	   	 	getNotif();
	   }
	});
	return false;
}

function getNotif() {
	var url = baseURL +'/messagesnotif/getnotif';
	var last_idx = $('.notif-items').length;

	$.ajax({
      url : url,    
      type: "GET",
      data: { 
      	last_idx: last_idx,
      	sort : 'DESC'
      },
      dataType: "JSON",
      async: true,
      beforeSend: function(event) {
      	var elPlaceHolderLength = 2;
      	for (var i = 0; i < elPlaceHolderLength; i++) {
      		var html = '<li class="notif-placeholder">' +
	          '<a>' +
	            '<div class="pull-left">' +
	              '<div class="shimmerBG" style="min-width: 40px;height: 35px;border-radius: 10px;"></div>' +
	            '</div>' +
	            '<h4>' +
	              '<div class="shimmerBG" style="height: 17px;max-width: 135px;border-radius: 10px;"></div>' +
	              '<small class="shimmerBG" style="height: 12px;width: 50px;border-radius: 10px;"></small>' +
	            '</h4>' +
	            '<p class="shimmerBG" style="min-width: 188px;height: 12px;border-radius: 15px;margin-top: 5px;"></p>' +
	          '</a>' +
	        '</li>';
	      	$('.notif-list').append(html);
      	}
      	$('.notif-list').unbind('scroll');
      	$('.notif-list').animate({ scrollTop: ($('.notif-list').scrollTop() + 85) }, 15, 'linear');
      },
      success: function(data) {	 	
      	setTimeout(() => {
		 	if (data.length > 0) {
		 		$('.notif-no-notification').remove();
		 		$('.notif-count').text(data.length);

		 		if (($('.notif-items').length + 1) <= data.length) {
		 			for (var i = 0; i < data.aData.length; i++) {
		 					var urls = baseURL +'/admin/messages/readmail/' + data.aData[i].uuid + '?q=inbox';
		 					
					 		var html = '<li class="notif-items">' +
			                  '<a href="'+urls+'">' +
			                    '<div class="pull-left">' +
			                      '<i class="fa fa-envelope-o" style="font-size: 30px;"></i>' +
			                    '</div>' +
			                    '<h4 style="margin: 0 0 0 38px;">' +
			                      data.aData[i].name +
			                      '<small>'+ moment(data.aData[i].sendDate).format('DD MMM YYYY HH:mm') +'</small>' +
			                    '</h4>' +
			                    '<p style="margin: 5px 0 0 38px;white-space: initial;">'+ 
			                    	(data.aData[i].message.replace(/(<([^>]+)>)/ig,"").length >= 63 ? data.aData[i].message.replace(/(<([^>]+)>)/ig,"").slice(0, 63) + '...' : data.aData[i].message.replace(/(<([^>]+)>)/ig,"")) +
			                    '</p>' +
			                  '</a>' +
			                '</li>';
			            	$('.notif-list').append(html);
				 		}

			 		handleInfiniteScroll();
			 		$('.notif-placeholder').remove();
		 		} else {
		 			$('.notif-list').unbind('scroll');
		 			$('.notif-placeholder').remove();

			      	$('.notif-list').append('<li class="notif-no-more-data">No more data.</li>');
			      	setTimeout(() => {
			      		if ($('.notif-list').scrollTop() > ($('.notif-list').scrollTop() - 40)) {
			      			$('.notif-list').scrollTop(($('.notif-list').scrollTop() - 35), 0);
			      		} else {
			      			$('.notif-list').scrollTop($('.notif-list').scrollTop(), 0);
			      		}	  

			      		$('.notif-no-more-data').remove();
			      		handleInfiniteScroll();
			      	}, 5000);

		 		}
		 	} else {
		 		$('.notif-count').text('');
		 		$('.notif-placeholder, .notif-no-notification').remove();
		 		$('.notif-list').append('<li class="notif-no-notification">No notification.</li>');
		 	}
      	}, 2000);
      },
      error: function (jqXHR, textStatus, errorThrown) {
      	console.log(textStatus);
      }
  	});
}

function showNotif(e) {
	e.preventDefault();
	$('.notif-items, .notif-no-notification').remove();

	if ($('.showNotif').attr('aria-expanded') == 'false') {
		$('.showNotif').attr('aria-expanded','show');
		getNotif();
	} 

	if ($('.showNotif').attr('aria-expanded') == 'show') {
		$('.showNotif').attr('aria-expanded','hidden');
		$('.notif-no-more-data').remove();
	}
	return false;
}