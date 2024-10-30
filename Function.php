<?php
/*
Plugin Name: Contact Form Shortcode
Plugin URI: http://wordpress.org/plugins/contact-form-shortcode/
Description: A simple settings contact form. Just put <code>[contact]</code> into your post and fill out the five simple settings.
Version: 0.9
Author: <a href="http://profiles.wordpress.org/kidsguide">Websiteguy</a>
Author URL: http://profiles.wordpress.org/kidsguide
Compatible with WordPress 3.8
*/
/*
Copyright 2013 Websiteguy (email : mpsparrow@cogeco.ca)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

add_action('admin_menu', 'contactformshortcodesettings_menu');

function contactformshortcodesettings_menu() {
	add_options_page('Contact Form Settings', 'Contact Form SC', 'manage_options', 'contactformshortcode', 'contactformshortcodesettings');
}


function contactformshortcodesettings() {
	
	if (!current_user_can('manage_options'))  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}
	global $_POST;
	
	if(isset($_POST['email_address_setting'])) {
		
		if(!get_option("contactformshortcode_email")) {
			add_option( "contactformshortcode_email", $_POST['email_address_setting'], '', 'yes');
		} else {
			update_option( "contactformshortcode_email", $_POST['email_address_setting']);
		}
		
		if(!get_option("contactformshortcode_question")) {
			add_option( "contactformshortcode_question", $_POST['spam_question_setting'], '', 'yes');
		} else {
			update_option( "contactformshortcode_question", $_POST['spam_question_setting']);
		}
		
		if(!get_option("contactformshortcode_answer")) {
			add_option( "contactformshortcode_answer", $_POST['spam_answer_setting'], '', 'yes');
		} else {
			update_option( "contactformshortcode_answer", $_POST['spam_answer_setting']);
		}
		
		if(!get_option("contactformshortcode_thankyou")) {
			add_option( "contactformshortcode_thankyou", $_POST['thankyou_setting'], '', 'yes');
		} else {
			update_option( "contactformshortcode_thankyou", $_POST['thankyou_setting']);
		}
		
		if(isset($_POST['linkback_setting'])) {
			$linkback = "Yes";
		} else {
			$linkback = "No";
		}
		
		if(!get_option("contactformshortcode_linkback")) {
			add_option( "contactformshortcode_linkback", $linkback, '', 'no');
		} else {
			update_option( "contactformshortcode_linkback", $linkback);
		}
		
	}
	
?>

<div class="wrap">
<div class="icon32" id="icon-options-general"><br></div>
<h2>Contact Form Shortcode Settings</h2> <h3><a href="http://www.wordpress.org/plugins/contact-form-shortcode" target="_blank">Contact Form Shortcode</a> is made by <a href="http://profiles.wordpress.org/kidsguide" target="_blank">Websiteguy</a>.</h3>
<center><h4>Please complete the fields below and click the Save button.</h4></center>
<form method="post" id="contactformshortcodesettings" action="">
<table class="form-table">
	<tbody><tr>
		<th><label for="email_address_setting"><strong>Email Address:</strong></label></th> 
		<td><input type="text" name="email_address_setting" class="regular-text" value="<?php echo get_option('contactformshortcode_email');?>"></td>
		<td colspan="2">Put your e-mail address in the box.  ex) 123@example.com</label></td>
	</tr>
	<tr>
		<th><label for="spam_question_setting"><strong>Anti-Spam (Captcha) Question:</strong></label></th>
		<td><input type="text" name="spam_question_setting" class="regular-text" value="<?php echo get_option('contactformshortcode_question');?>"></td>
		<td colspan="2">This Anti-Spam question will appear under your form. Put your question here.  ex) 2x2</label></td>
	</tr>
	<tr>
		<th><label for="spam_answer_setting"><strong>Anti-Spam (Captcha) Answer:</strong></label></th>
		<td><input type="text" name="spam_answer_setting" class="regular-text" value="<?php echo get_option('contactformshortcode_answer');?>"></td>
		<td colspan="2">Put your Anti-Spam answer here.  ex) 4</label></td>
	</tr>
	<tr>
		<th><label for="thankyou_setting"><strong>Thank You Message:</strong></label></th>
		<td><input type="text" name="thankyou_setting" class="regular-text" value="<?php echo get_option('contactformshortcode_thankyou');?>"></td>
		<td colspan="2">Put your thank-you message here.  ex) Thank-you for sending use an e-mail!</label></td>
	</tr>
	<tr>
		<th><label for="linkback_setting"><strong>Show Author Link:</strong></label></th>
		<td><input type="checkbox" name="linkback_setting" value="Set" <?php if(get_option('contactformshortcode_linkback') == "no") { echo " checked"; }?>> Support the Author</td>
		<td colspan="2"><label for="linkback_setting">Support the author, by having a link to the plugin page under the contact form.</label></td>
	</tr>
	<tr>
		<td colspan="2"><br /><input class="button-primary" type="submit" value="Save Changes"></td>
	</tr>
</tbody></table>
<table class="form-table">
<tr>
<td>

<h2><u>Help</u></h2>

<h3>Shortcode</h3>
<p>The shortcode to embed your custom contact form is <code>[contact]</code>.</p>

<h3>Support</h3>
<p>If you are having any trouble with this plugin, check out our <a href="http://wordpress.org/support/plugin/contact-form-shortcode">support forum</a> and <a href="http://wordpress.org/plugins/contact-form-shortcode/">description </a> on WordPress.</p>

<center><h2>Watch our video tutorial!</h2><font size="50">?</font></center> 
</td>
<td>
<iframe width="600" height="350" src="//www.youtube.com/embed/DY5j9R5qEKU" frameborder="0" allowfullscreen></iframe>
</iframe>
</td>
</tr>
</tbody></table>
</form>
<div class="clear"></div>
</div>
<?
	
}

function contactformshortcode() {
	global $_POST;
	
	$final_error_message = "";
	
	if(!get_option("contactformshortcode_email")) {
		
		$final_error_message = "*** FORM HAS NOT BEEN CONFIGURED YET *** <br />The administrator should configure the form using the settings in the admin area.";
		
	}

	$email_to = get_option('contactformshortcode_email');
	$antispam_question = get_option('contactformshortcode_question');
	$antispam_answer = get_option('contactformshortcode_answer');
	$thank_you_message = get_option('contactformshortcode_thankyou');
	$linkback = get_option('contactformshortcode_linkback');
	
	if(isset($_POST['Full_Name'])) {

	
	if(	!isset($_POST['Email_Address']) ||
		!isset($_POST['Subject']) || 
		!isset($_POST['Website']) ||
		!isset($_POST['Your_Message']) || 
		!isset($_POST['AntiSpam'])		
		) {
		$final_error_message .= 'Sorry, there appears to be a problem with your form submission.';		
	}
	
	
	if(trim($final_error_message) == "") {
		
		if(get_magic_quotes_gpc()) {
			$full_name = stripslashes($_POST['Full_Name']); // required
			$email_from = stripslashes($_POST['Email_Address']); // required
			$website = stripslashes($_POST['Website']);
			$subject = stripslashes($_POST['Subject']); // not required
			$comments = stripslashes($_POST['Your_Message']); // required
			$antispam = stripslashes($_POST['AntiSpam']); // required
		} else {
			$full_name = $_POST['Full_Name']; // required
			$email_from = $_POST['Email_Address']; // required
			$website = $_POST['Website'];
			$subject = $_POST['Subject']; // not required
			$comments = $_POST['Your_Message']; // required
			$antispam = $_POST['AntiSpam']; // required
		}
		
		$email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
		if(preg_match($email_exp,$email_from)==0) {
			$final_error_message .= 'The content in the "Email Address" field does not appear to be valid.<br />';
		}
		if(strlen($full_name) < 2) {
			$final_error_message .= 'The content in the "Name" field does not appear to be valid.<br />';
		}
		if(strlen($subject) < 2) {
			$final_error_message .= 'The content in the "Subject" field does not appear to be valid.<br />';
		}
		if(strlen($comments) < 10) {
			$final_error_message .= 'The content in the "Message" field does not appear to be valid.<br />';
		}
		
		if($antispam <> $antispam_answer) {
			$final_error_message .= 'The answer in to the "Anti-Spam" question does not appear to be correct.<br />';
		}
	
		
		if(trim($final_error_message) == "") {
			$email_message = "Form details below.\r\n";
			$email_message .= "Full Name: ".trim($full_name)."\r\n";
			$email_message .= "Email: ".trim($email_from)."\r\n";
			if(trim($website) <> "") {
				$email_message .= "Website: ".trim($website)."\r\n";
			}
			$email_message .= "Message: ".trim($comments)."\r\n";
			
			$headers = 'From: '.$email_from."\r\n".
			'Reply-To: '.$email_from."\r\n" .
			'X-Mailer: PHP/' . phpversion();
			@mail($email_to, $subject, $email_message, $headers);
			$thank_you_active = true;
		}
		}
	}
	?>
	<script>
	function has_id(id){try{var tmp=document.getElementById(id).value;}catch(e){return false;}
	return true;}
	function has_name(nm){try{var tmp=cfrm.nm.type;}catch(e){return false;}
	return true;}
	function $$(id){if(!has_id(id)&&!has_name(id)){alert("Field "+id+" does not exist!\n Form validation configuration error.");return false;}
	if(has_id(id)){return document.getElementById(id).value;}else{return;}}
	function $val(id){return document.getElementById(id);}
	function trim(id){$val(id).value=$val(id).value.replace(/^\s+/,'').replace(/\s+$/,'');}
	var fcfrequired={field:[],add:function(name,type,mess){this.field[this.field.length]=[name,type,mess];},out:function(){return this.field;},clear:function(){this.field=[];}};var validate={check:function(cform){var error_message='Please fix the following errors:\n\n';var mess_part='';var to_focus='';var tmp=true;for(var i=0;i<fcfrequired.field.length;i++){if(this.checkit(fcfrequired.field[i][0],fcfrequired.field[i][1],cform)){}else{error_message=error_message+fcfrequired.field[i][2]+' must be supplied\n';if(has_id(fcfrequired.field[i][0])&&to_focus.length===0){to_focus=fcfrequired.field[i][0];}
	tmp=false;}}
	if(!tmp){alert(error_message);}
	if(to_focus.length>0){document.getElementById(to_focus).focus();}
	return tmp;},checkit:function(cvalue,ctype,cform){if(ctype=="NOT_EMPTY"){if(this.trim($$(cvalue)).length<1){return false;}else{return true;}}else if(ctype=="EMAIL"){exp=/^[a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;if($$(cvalue).match(exp)==null){return false;}else{return true;}}},trim:function(s){if(s.length>0){return s.replace(/^\s+/,'').replace(/\s+$/,'');}else{return s;}}};
	fcfrequired.add('Full_Name','NOT_EMPTY','Full Name');
	fcfrequired.add('Email_Address','EMAIL','Email Address');
	fcfrequired.add('Subject','NOT_EMPTY','Subject');
	fcfrequired.add('Your_Message','NOT_EMPTY','Your Message');
	fcfrequired.add('AntiSpam','NOT_EMPTY','Anti-Spam Question');
	</script>
	
	<form name="contactformshortcode" method="post" action="" onsubmit="return validate.check(this)">
	<tr>
	 <td colspan="2">
	  
	 <?php
	if(trim($final_error_message) <> "") {
	?>
	<br />
	<div style="font-weight:bold;padding:10px;border:1px dotted #F00">
		<?php echo $final_error_message; ?>
	</div>
	<br /><br />
	<?php
	}
	?>
	
	<?php
	if(isset($thank_you_active)) {
		// reset values
		$_POST['Full_Name'] = "";
		$_POST['Email_Address'] = "";
		$_POST['Subject'] = "";
		$_POST['Your_Message'] = "";
		$_POST['AntiSpam'] = "";
	?>
	<br />
	<div style="font-weight:bold;padding:10px;border:1px dotted #3BAA21">
		<?php echo $thank_you_message; ?>
	</div>
	<br /><br />
	<?php
	}
	?>
	 

	  <br />
	  
	  
	 </td>
	</tr>
	<tr>
	 <td valign="top">
	  <label for="Full_Name">Your Name<span class="required_star"> * </span></label>
	 </td>
	 <td valign="top">
	  <input type="text" name="Full_Name" id="Full_Name" maxlength="80" value="<?php if(isset($_POST['Full_Name'])){ echo $_POST['Full_Name']; }?>" style="width:260px">
	 </td>
	</tr>
	<tr>
	 <td valign="top">
	  <label for="Email_Address">Email Address<span class="required_star"> * </span></label>
	 </td>
	 <td valign="top">
	  <input type="text" name="Email_Address" id="Email_Address" maxlength="100" value="<?php if(isset($_POST['Email_Address'])){ echo $_POST['Email_Address']; }?>" style="width:260px">
	 </td>
	</tr>
	<tr>
	 <td valign="top">
	  <label for="Website">Website</label>
	 </td>
	 <td valign="top">
	  <input type="text" name="Website" id="Website" maxlength="100" value="<?php if(isset($_POST['Website'])){ echo $_POST['Website']; }?>" style="width:260px">
	 </td>
	</tr>
	<tr>
	 <td valign="top">
	  <label for="Subject">Subject<span class="required_star"> * </span></label>
	 </td>
	 <td valign="top">
	  <input type="text" name="Subject" id="Subject" maxlength="100" value="<?php if(isset($_POST['Subject'])){ echo $_POST['Subject']; }?>" style="width:260px">
	 </td>
	</tr>
	<tr>
	 <td valign="top">
	  <label for="Your_Message">Message<span class="required_star"> * </span></label>
	 </td>
	 <td valign="top">
	  <textarea style="width:320px;height:160px" name="Your_Message" id="Your_Message" maxlength="2000"><?php if(isset($_POST['Your_Message'])){ echo $_POST['Your_Message']; }?></textarea>
	 </td>
	</tr>
	<tr>
	 <td colspan="2" style="text-align:center" >
	  <div class="antispammessage">
	  <br /><br />
		  <div class="antispamquestion">
		   <?php echo $antispam_question; ?><span class="required_star"> * </span> &nbsp; 
		   <input type="text" name="AntiSpam" id="AntiSpam" maxlength="100" value="<?php if(isset($_POST['AntiSpam'])){ echo $_POST['AntiSpam']; }?>" style="width:60px">
		  </div>
	  </div>
	 </td>
	</tr>
	<tr>
	 <td colspan="2" style="text-align:center" >
	 <br /><br />
	  <input type="submit" value=" Submit ">
	  <br /><br />
	  <?php
	  if($linkback == "Yes") {
	  ?>
	  <div style="font-size:0.8em"><a href="http://www.wordpress.org/plugins/contact-form-shortcode" target="_blank">This Contact Form <small>(Contact Form Shortcode)</small></a> is made by <a href="http://profiles.wordpress.org/kidsguide" target="_blank">Websiteguy</a>.</div>
	  <br /><br />
	  <?php
	  }
	  ?>
	 </td>
	</tr>
	</form>
	<div class="clear"></div>
	<?php
}

add_shortcode( 'contact', 'contactformshortcode' );
?>