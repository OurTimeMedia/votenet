<script>
var urlToPost = '<?php echo SITE_URL ?>' + 'demo-db.php';
	function showvideo()
	{
		$('a.close, #mask').trigger('click');
		$("#faceBookDemoLinkHidden").trigger('click');
	}
	
	$(document).ready(function() {
		$("#faceBookDemoLinkHidden").fancybox({'type'	: 'iframe', autoDimensions: false, width:750, height:500});
		
		$('a.login-window').click(function() {
		
                //Getting the variable's value from a link 
		var loginBox = $(this).attr('href');

		//Fade in the Popup
		$(loginBox).fadeIn(300);
		
		//Set the center alignment padding + border see css style
		var popMargTop = ($(loginBox).height() + 24) / 2; 
		var popMargLeft = ($(loginBox).width() + 24) / 2; 
		
		$(loginBox).css({ 
			'margin-top' : -popMargTop,
			'margin-left' : -popMargLeft
		});
		
		// Add the mask to body
		$('body').append('<div id="mask"></div>');
		$('#mask').fadeIn(300);
		
		return false;
	});
	
	$('a.login-window-bottom').click(function() {
		
                //Getting the variable's value from a link 
		var loginBox = $(this).attr('href');

		//Fade in the Popup
		$(loginBox).fadeIn(300);
		
		//Set the center alignment padding + border see css style
		var popMargTop = ($(loginBox).height() + 24) / 2; 
		var popMargLeft = ($(loginBox).width() + 24) / 2; 
		
		$(loginBox).css({ 
			'margin-top' : -popMargTop,
			'margin-left' : -popMargLeft
		});
		
		// Add the mask to body
		$('body').append('<div id="mask"></div>');
		$('#mask').fadeIn(300);
		
		return false;
	});
	
	$('a.login-window-button').click(function() {
		
                //Getting the variable's value from a link 
		var loginBox = $(this).attr('href');

		//Fade in the Popup
		$(loginBox).fadeIn(300);
		
		//Set the center alignment padding + border see css style
		var popMargTop = ($(loginBox).height() + 24) / 2; 
		var popMargLeft = ($(loginBox).width() + 24) / 2; 
		
		$(loginBox).css({ 
			'margin-top' : -popMargTop,
			'margin-left' : -popMargLeft
		});
		
		// Add the mask to body
		$('body').append('<div id="mask"></div>');
		$('#mask').fadeIn(300);
		
		return false;
	});
	
	// When clicking on the button close or the mask layer the popup closed
	$('a.close, #mask').live('click', function() { 
	  $('#mask , .login-popup').fadeOut(300 , function() {
		$('#mask').remove();  
	}); 
	return false;
	});
});

function validateForm()
{
	var returnFlag	= true;
	
	$('input[type=text]').css('border-color','#000000 #333333 #333333 #000000');
	$('input[type=text]').css('border-style','solid');
	$('input[type=text]').css('border-width','1px');
    
	if($('#first_name_video').val() == '')
	{
		$('#first_name_video').css('border','1px solid red');
		returnFlag = false;
	}
	
	if($('#last_name_video').val() == '')
	{
		$('#last_name_video').css('border','1px solid red');
		returnFlag = false;
	}
	
	if($('#organization_video').val() == '')
	{
		$('#organization_video').css('border','1px solid red');
		returnFlag = false;
	}
	
	if($('#email_video').val() == '')
	{
		$('#email_video').css('border','1px solid red');
		returnFlag = false;
	}
	
	if($('#email_video').val() == '')
	{
		$('#email_video').css('border','1px solid red');
		returnFlag = false;
	}
	
	if(!isValidEmail($('#email_video').val()))
	{
		$('#email_video').css('border','1px solid red');
		returnFlag = false;
	}
	

	
	if(returnFlag)
	{
	
		var first_name_video = $("#first_name_video").val();
		
		var last_name_video = $("#last_name_video").val();
		var organization_video = $("#organization_video").val();
		var email_video = $("#email_video").val();
		var mode = 'showVideo';
		
		dataToPost = '';
	
		dataToPost +=  '&first_name_video='+ first_name_video;
		dataToPost +=  '&last_name_video='+ last_name_video;
		dataToPost +=  '&organization_video='+ organization_video;
		dataToPost +=  '&email_video='+ email_video;
		dataToPost +=  '&mode='+ mode;
		

	
		 	$.ajax({
     	type: "POST",
     	url: urlToPost,
     	async: false,
    	data: dataToPost,
 			dataType: "json",
 			success: function(msg){

 	
 				if(msg['message'] != '')
			{
				
				$('#loginContent_video').html(msg['message']);
			}
			else
			{
				$('input[type=text]').css('border-color','#000000 #333333 #333333 #000000');
				$('input[type=text]').css('border-style','solid');
				$('input[type=text]').css('border-width','1px');
				
				if(msg['first_name_video'] == 'yes')
				{
					$('#first_name_video').css('border','1px solid red');
					returnFlag = false;
				}
				
				if(msg['last_name_video'] == 'yes')
				{
					$('#last_name_video').css('border','1px solid red');
					returnFlag = false;
				}
				
				if(msg['organization_video'] == 'yes')
				{
					$('#organization_video').css('border','1px solid red');
					returnFlag = false;
				}
				
				if(msg['email_video'] == 'yes')
				{
					$('#email_video').css('border','1px solid red');
					returnFlag = false;
				}
			}
			return false;
 		
 	}});
	}
	
	

	
	return false;
	
	return returnFlag;
}

function checkValidate()
{
	var returnFlag	= true;
	
	$('input[type=text]').css('border-color','#000000 #333333 #333333 #000000');
	$('input[type=text]').css('border-style','solid');
	$('input[type=text]').css('border-width','1px');
    
	if($('#first_name').val() == '')
	{
		$('#first_name').css('border','1px solid red');
		returnFlag = false;
	}
	
	if($('#last_name').val() == '')
	{
		$('#last_name').css('border','1px solid red');
		returnFlag = false;
	}
	
	if($('#organization').val() == '')
	{
		$('#organization').css('border','1px solid red');
		returnFlag = false;
	}
	
	if($('#email').val() == '')
	{
		$('#email').css('border','1px solid red');
		returnFlag = false;
	}
	
	if($('#email').val() == '')
	{
		$('#email').css('border','1px solid red');
		returnFlag = false;
	}
	
	if(!isValidEmail($('#email').val()))
	{
		$('#email').css('border','1px solid red');
		returnFlag = false;
	}
	
	
	if(returnFlag)
	{
		
				first_name= $('#first_name').val(),
				last_name= $('#last_name').val(),
				organization= $('#organization').val(),
				email= $('#email').val()
				
				dataToPost = '';
				
				dataToPost += '&first_name=' + first_name;
				dataToPost += '&last_name=' + last_name;
				dataToPost += '&organization=' + organization;
				dataToPost += '&email=' + email;
				
				
		
		$.ajax({
     	type: "POST",
     	url: urlToPost,
     	async: false,
    	data: dataToPost,
 			dataType: "json",
 			success: function(msg){
 	
 			
 						//alert( "Data Saved: " + msg['email'] );
			if(msg['message'] != '')
			{
			
				$('#loginContent').html(msg['message']);
			}
			else
			{
				alert('message is blank');
				
				$('input[type=text]').css('border-color','#000000 #333333 #333333 #000000');
				$('input[type=text]').css('border-style','solid');
				$('input[type=text]').css('border-width','1px');
				
				if(msg['first_name'] == 'yes')
				{
					$('#first_name').css('border','1px solid red');
					returnFlag = false;
				}
				
				if(msg['last_name'] == 'yes')
				{
					$('#last_name').css('border','1px solid red');
					returnFlag = false;
				}
				
				if(msg['organization'] == 'yes')
				{
					$('#organization').css('border','1px solid red');
					returnFlag = false;
				}
				
				if(msg['email'] == 'yes')
				{
					$('#email').css('border','1px solid red');
					returnFlag = false;
				}
			}
			return false;
 			
 			
 			
 		
 	}});
		
		
		
	}
	
	
	if(0)
	{
		$.ajax({
		  type	: "POST",
		  url	: urlToPost,
		  dataType: "json",
		  data	: {
				first_name: $('#first_name').val(),
				last_name: $('#last_name').val(),
				organization: $('#organization').val(),
				email: $('#email').val()
			}
		}).success(function( msg ) 
		{
			
		
			
			//alert( "Data Saved: " + msg['email'] );
			if(msg['message'] != '')
			{
				alert('message not blank');
				$('#loginContent').html(msg['message']);
			}
			else
			{
				alert('message is blank');
				
				$('input[type=text]').css('border-color','#000000 #333333 #333333 #000000');
				$('input[type=text]').css('border-style','solid');
				$('input[type=text]').css('border-width','1px');
				
				if(msg['first_name'] == 'yes')
				{
					$('#first_name').css('border','1px solid red');
					returnFlag = false;
				}
				
				if(msg['last_name'] == 'yes')
				{
					$('#last_name').css('border','1px solid red');
					returnFlag = false;
				}
				
				if(msg['organization'] == 'yes')
				{
					$('#organization').css('border','1px solid red');
					returnFlag = false;
				}
				
				if(msg['email'] == 'yes')
				{
					$('#email').css('border','1px solid red');
					returnFlag = false;
				}
			}
			return false;
		}
		);
	}
	return false;
	
	return returnFlag;
}

function isValidEmail(email){ 
	var RegExp = /^((([a-z]|[0-9]|!|#|$|%|&|'|\*|\+|\-|\/|=|\?|\^|_|`|\{|\||\}|~)+(\.([a-z]|[0-9]|!|#|$|%|&|'|\*|\+|\-|\/|=|\?|\^|_|`|\{|\||\}|~)+)*)@((((([a-z]|[0-9])([a-z]|[0-9]|\-){0,61}([a-z]|[0-9])\.))*([a-z]|[0-9])([a-z]|[0-9]|\-){0,61}([a-z]|[0-9])\.)[\w]{2,4}|(((([0-9]){1,3}\.){3}([0-9]){1,3}))|(\[((([0-9]){1,3}\.){3}([0-9]){1,3})\])))$/ 
    if(RegExp.test(email)){ 
        return true; 
    }else{ 
        return false; 
    } 
} 
</script>      
      <!--top end --> 
      <?php //require_once 'demo-db.php'; ?>
	  
      <!-- Header start -->
	<div id="header-sub">
		<h1><?php echo trim($arcms[0]['cms_title']); ?></h1>
		<p class="register"><?php echo trim($arcms[0]['cms_sub_title']); ?></p>
	</div>
      <!-- Header end --> 
      
      <!-- middle start -->
      <div id="middle-sub">
        
		<?php $msg->display_msg(); ?>
		<?php echo trim($arcms[0]['cms_content']); ?>
		<br />
		<div class="midd-left1"><a href="#login-box" class="login-window"><img src="<?php echo SITE_URL; ?>images/demo-img1.jpg" width="406" height="301" alt="Facebool app" /></a><br />
		<br />
		<div id="login-box" class="login-popup">
           	<h2>VIEW DEMO</h2>
			<a href="#" class="close"><img src="<?php echo SITE_URL; ?>images/close_pop.png" class="btn_close" title="Close Window" alt="Close" /></a>
          <form method="post" class="signin" action="" onsubmit="return checkValidate();">
          	<div id="loginContent">
          
                <fieldset class="textbox">
            	<label class="first_name">
                <span>First Name</span>
                <input id="first_name" name="first_name" value="" type="text" autocomplete="on" placeholder="First Name">
                </label>
                <label class="last_name">
                <span>Last Name</span>
                <input id="last_name" name="last_name" value="" type="text" placeholder="Last Name">
                </label>
                <label class="password">
                <span>Organization</span>
                <input id="organization" name="organization" value="" type="text" placeholder="Organization">
                </label>
                 <label class="password">
                <span>Email</span>
                <input id="email" name="email" value="" type="text" placeholder="Email">
                </label>
                <button class="submit button" type="submit">Sign in</button>
                </fieldset>
                	</div>
          </form>
		</div>
		<div id="login-box-video" class="login-popup">
            <h2>VIEW VIDEO</h2>
			<a href="#" class="close"><img src="<?php echo SITE_URL; ?>images/close_pop.png" class="btn_close" title="Close Window" alt="Close" /></a>
			<form method="post" class="signin" action="" onsubmit="return validateForm();">
				<div id="loginContent_video">
					<fieldset class="textbox">
					<label class="first_name">
					<span>First Name</span>
					<input id="first_name_video" name="first_name_video" value="" type="text" autocomplete="on" placeholder="First Name">
					</label>
					<label class="last_name">
					<span>Last Name</span>
					<input id="last_name_video" name="last_name_video" value="" type="text" placeholder="Last Name">
					</label>
					<label class="password">
					<span>Organization</span>
					<input id="organization_video" name="organization_video" value="" type="text" placeholder="Organization">
					</label>
					 <label class="password">
					<span>Email</span>
					<input id="email_video" name="email_video" value="" type="text" placeholder="Email">
					</label>
					
					<button class="submit button" type="submit">Sign in</button>
				   
					</fieldset>
				</div>
			</form>
		</div>
		
       <h2 class="c"><a href="#login-box" class="login-window-bottom">See Election Impact in Action</a></h2></div>
       <div class="midd-right1"><a href="#login-box-video" class="login-window"><img src="<?php echo SITE_URL; ?>images/demo-img2.jpg" width="406" height="301" alt="Facebool app" /></a><br />
<br />
<h2 class="c"><a href="#login-box-video" class="login-window">Watch the Election Impact<br />  for Facebook Video</a></h2></div>
        <div class="clear"></div>
        <p class="aboutbtn" align="center"><a href="<?php echo SITE_URL; ?>demo"><img src="<?php echo SITE_URL; ?>images/view-demo-sub.gif" width="281" height="73" /></a> 
        	<a href="<?php echo SITE_URL; ?>request-info"><img src="<?php echo SITE_URL; ?>images/request-information-btn-sub.gif" width="402" height="73" /></a></p>
		
		<a href="http://youtube.googleapis.com/v/zatr73gsU7I" id="faceBookDemoLinkHidden">&nbsp;</a>
      </div>
      <!-- middle end-->
    </div>