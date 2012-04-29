<?php
Class Slickform {
	public function __construct($id, $method, $action, $class = false, $well = false,  $ajax = false, $validate = false, $tooltippos = "right", $customval = false, $oldinput = false) {
		$this->oldinput = $oldinput;	
		$this->formid = $id;
		$this->css_class = $class;
		$this->tooltippos = $tooltippos;
		$this->wrap_begin = "";
		$this->wrap_end = "";
		$this->field_wrap_begin = "";
		$this->field_wrap_end = "";
		$this->label_class = "";
		$this->jshead="";
		$this->successid = $id."_success";
		$this->errorid = $id."_error";
		$custom_submit = "";
		if ($well) {
			$this->css_class .= " well";
		}
		$this->form_start = "<form id=\"$id\" method=\"$method\" action=\"$action\" class=\"$class\">";
		$this->form_middle = "";
		$this->form_end = "</form>";
		if ($this->css_class = "form-horizontal") {
			$this->wrap_begin = "<div class=\"control-group\">";
			$this->wrap_end	= "</div>";
			$this->field_wrap_begin = "<div class=\"controls\">";
			$this->field_wrap_end = "</div>";
			$this->label_class = "control-label";
			$this->help_type = "span";
			$this->help_class = "help_inline";
		} else {
			$this->help_type = "p";
			$this->help_class = "help-block";
		}
		if ($validate) {
			$this->jshead = "
			<script type=\"text/javascript\" src=\"http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js\"></script>\n
			<script type=\"text/javascript\" src=\"http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/additional-methods.min.js\"></script>\n
			";
		}
		$this->jsmain_begin = "<script type=\"text/javascript\">
		\$(function(){
		 ";
		$this->jsmain_middle = "";
		if ($customval and is_array($customval)) {
			foreach($customval as $customjs) { 
				$method_name = $customjs['name'];
				$method_func   = $customjs['function'];
				$method_msg	 = $customjs['msg'];
				$this->jsmain_middle .= "
					jQuery.validator.addMethod(\"$method_name\", $method_func, \"$method_msg\");\n
				";
			}
		}
		if ($validate) {
			if ($ajax) {
				$ajaxfunc = $id."_submit(form)";
				$submithandle = "
					$ajaxfunc;
				";
				$custom_submit = "
					function $ajaxfunc{
						var formtarget = \$(form);
						var formdata = formtarget.serialize();
						\$.ajax({
							url: '$action',
							data: formdata,
							async: false,
							type: 'POST',
							dataType: 'json',
							success: function(data) {
								if (data.success) {
									\$('#$id').remove();
									\$('#$this->errorid').hide();
									\$('#$this->successid').show();
								} else {
									\$('#$id').remove();
									\$('#$this->errorid').show();
									\$('#$this->successid').hide();
								}
							},
							error: function(data) {
								\$('#$id').remove();
								\$('#$this->errorid').show();
								\$('#$this->successid').hide();
							}
 						});
					}
				";
			} else {
				$submithandle = "
					\$(form).submit();
				";
			}
			$this->jsmain_middle .= "
			\$('#$id').validate({
   				debug: true,
   				focusInvalid: true,
   				focusCleanup: false,
   				errorClass: 'error',
   				validClass: 'success',
   				errorElement: 'p',
   				errorPlacement: function(error, element) {
   					console.log(error);
     				element.after(error);
   				},
   				success: function(label) {
   					\$(label).parents('div.control-group').addClass('success');
   				},
   				highlight: function(element, errorClass, validClass) {
   					\$(element).parents('div.control-group').removeClass(validClass).addClass(errorClass);
   				},
   				unhighlight: function(element, errorClass, validClass) {
   					\$(element).parents('div.control-group').removeClass(errorClass).addClass(validClass);
   				},
   				submitHandler: function(form) {
   					$submithandle
   				}
			});
			$custom_submit;
			
			";
		}
		
		$this->jsmain_end = "
		});
		</script>
		";
	}
	public function returnForm() {
		return $this->form_start.$this->form_middle.$this->form_end;
	}
	public function returnJSHead() {
		return $this->jshead;
	}
	public function returnJSForm() {
		return $this->jsmain_begin.$this->jsmain_middle.$this->jsmain_end;
	}
	public function returnJSAll() {
		return $this->jshead.$this->jsmain_begin.$this->jsmain_middle.$this->jsmain_end;
	}
	public function addBr() {
		$this->form_middle .= "<br/>";
	}
	public function addSpace() {
		$this->form_middle .= "&nbsp;";
	}
	public function addFieldset($legend = false) {
		$this->form_middle .= "<fieldset>";
		if ($legend) {
			$this->form_middle .= "<legend>$legend</legend>";
		}
	}
	public function processField($name, $label = false, $class = false, $required = false, $help = false, $tooltip = false, $customval = false, $extraval = false, $icon = false, $value) {
		$label_class = $this->label_class;
		$help_type = $this->help_type;
		$help_class = $this->help_class;
		$tooltippos = $this->tooltippos;
		$label_begin = "";
		$label_end = "";
		$title = "";
		$help_out = "";
		$field_class = "";
		$field_div_begin = "";
		$field_div_end = "";
		$validation = "";
		if ($label) {
			$label_begin = "<label for=\"$name\" class=\"$label_class\">$label";
			$label_end = "</label>";
		}
		if ($tooltip) {
			$title = $tooltip;
			$this->jsmain_middle .= "\$('#$name').tooltip({'placement' : '$tooltippos', 'trigger' : 'focus'}); ";
		}
		if ($help) {
			$help_out = "<$help_type class=\"$help_class\">$help</$help_type>";
		}
		if ($class) {
			$field_class = "$class";
		}
		if ($required) {
			$field_class .= " required ";
		}
		if ($customval) {
			$field_class .= " $customval";
		}
		if ($icon) {
			$field_div_begin = "<div class=\"input-prepend\"><span class=\"add-on\"><i class=\"icon-$icon\"></i></span>";
			$field_div_end = "</div>";
		}
		if ($extraval and is_array($extraval)) {
			foreach ($extraval as $validrule => $validvalue) {
				$validation.= "$validrule=\"$validvalue\" ";
			}
		}
		if ($value) {
			$field_value = $this->oldinput[$value];
		} else {
			$field_value = "";
		}
		$field_return = array();
		$field_return['label_class'] = $label_class;
		$field_return['help_type'] = $help_type;
		$field_return['help_class'] = $help_class;
		$field_return['tooltip_pos'] = $tooltippos;
		$field_return['label_begin'] = $label_begin;
		$field_return['label_end'] = $label_end;
		$field_return['title'] = $title;
		$field_return['help_out'] = $help_out;
		$field_return['field_class'] = $field_class;
		$field_return['field_div_begin'] = $field_div_begin;
		$field_return['field_div_end'] = $field_div_end;
		$field_return['validation'] = $validation;
		$field_return['field_value'] = $field_value;
		return $field_return;
	}
	public function addTextField($name, $label = false, $class = false, $required = false, $help = false, $tooltip = false, $customval = false, $extraval = false, $icon = false, $value = false) {
		$extracted = $this->processField($name, $label, $class, $required, $help, $tooltip, $customval, $extraval, $icon, $value);
		extract($extracted);
		$field_begin = $this->wrap_begin.$label_begin.$label_end.$this->field_wrap_begin.$field_div_begin;
		$field_data = "<input rel=\"tooltip\" name=\"$name\" id=\"$name\" type=\"text\" class=\"$field_class \" $validation title=\"$title\" value=\"$field_value\" />".$help_out;
		$field_end = $field_div_end.$this->field_wrap_end.$this->wrap_end;
		$this->form_middle .= $field_begin.$field_data.$field_end;
	}
	public function addLongTextField($name, $label = false, $class = false, $required = false, $help = false, $tooltip = false, $customval = false, $extraval = false, $icon = false, $value = false) {
		$extracted = $this->processField($name, $label, $class, $required, $help, $tooltip, $customval, $extraval, $icon, $value);
		extract($extracted);
		$field_begin = $this->wrap_begin.$label_begin.$label_end.$this->field_wrap_begin.$field_div_begin;
		$field_data = "<textarea rel=\"tooltip\" name=\"$name\" id=\"$name\" type=\"text\" class=\"$field_class \" $validation title=\"$title\" />$field_value</textarea>".$help_out;
		$field_end = $field_div_end.$this->field_wrap_end.$this->wrap_end;
		$this->form_middle .= $field_begin.$field_data.$field_end;
	}
	public function addPasswordField($name, $label = false, $class = false, $required = false, $help = false, $tooltip = false, $customval = false, $extraval = false, $icon = false, $value = false) {
		$extracted = $this->processField($name, $label, $class, $required, $help, $tooltip, $customval, $extraval, $icon, $value);
		extract($extracted);
		$field_begin = $this->wrap_begin.$label_begin.$label_end.$this->field_wrap_begin.$field_div_begin;
		$field_data = "<input rel=\"tooltip\" name=\"$name\" id=\"$name\" type=\"password\" class=\"$field_class \" $validation title=\"$title\" value=\"$field_value\" />".$help_out;
		$field_end = $field_div_end.$this->field_wrap_end.$this->wrap_end;
		$this->form_middle .= $field_begin.$field_data.$field_end;
	}
 	public function endFieldset() {
		$this->form_middle .= "</fieldset>";
	}
	public function addFormActions() {
		$this->form_middle .= "<div class=\"form-actions\">";
	}
	public function endFormActions() {
		$this->form_middle .= "</div>";
	}
	public function addButton($id = "submit", $text = "Submit", $type = "submit", $class = "primary", $size = false, $icon = false, $iconcol = "white") {
		$btn_size = "";
		$btn_icon = "";	
		if ($size) {
			$btn_size = "btn-".$size;
		}
		if ($icon) {
			$btn_icon = "<i class=\"icon-$icon icon-$iconcol\"></i>";
		}
		$btn_class = "btn btn-$class ".$btn_size;
		$this->form_middle .= "<button name=\"$id\" id=\"$id\" type=\"$type\" class=\"$btn_class\" >$btn_icon $text</button>";
	}
	public function addConfirm($title_success, $msg_success, $title_error, $msg_error) {
		$successid = $this->successid;
		$errorid = $this->errorid;
		$this->form_end .= "<div id=\"$successid\" class=\"alert alert-success alert-block\" style=\"display:none;\">
    		<h4 class=\"alert-heading\">$title_success</h4>
    		$msg_success
   		</div>
   		<div id=\"$errorid\" class=\"alert alert-error alert-block\" style=\"display:none;\">
    		<h4 class=\"alert-heading\">$title_error</h4>
    		$msg_error
   		</div>";
	}
}
