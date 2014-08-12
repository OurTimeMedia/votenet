{include(file='header.tpl')}
<style>
#blanket {
background-color:#111;
opacity: 0.65;
filter:alpha(opacity=65);
position:absolute;
z-index: 9001;
top:0px;
left:0px;
width:100%;
}
#popUpDiv {
position:absolute;
background-color:#eeeeee;
width:300px;
height:300px;
z-index: 9002;
top: 145px !important;
}
</style>
<script type="text/javascript" src="js/csspopup.js"></script>
{if $hide_steps == "0"}
<div class="step">
  <ul>	
	<li  id="step1">Register</li>
	<li  id="step2">Review</li>
	<li class="step-act" id="step3">Share</li>	
  </ul>
</div>
{/if}
<div>
    <div class="content">
      <div class="step1-main">
        <div class="step1">
          <h1>{$reg_step} 3: {$LANG_SPREAD_WORD_SOCIAL_NETWORK}</h1>
          <div class="step-table">
            {include(file='registration_step3.php')}
          </div>
        </div>
		<div class="step1">
          <h1>{$LANG_ADD_TO_YOUR_CALENDER}</h1>
          <div class="step-table">
            {include(file='registration_step4.php')}
          </div>
        </div>
      </div>
    </div>
  </div>
{if $issponsers == 1}
{include(file="slider.tpl")}
{/if} 
{include(file='footer.tpl')}  

