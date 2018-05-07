<?php
    
    /**
     * Class Inputs
     */
    class Inputs {
        
        public static function text($name, $label = null, $maxlength = 25) {
            $rs = "<div class='form-group m-form__group'>";
            if(!!$label) $rs .= "<label class='form-control-label' for='gm-input--$name'>$label</label>";
            $rs .= "<input class='form-control m-input gm-css--input_text gm-js--input_text gm-input--$name' name='$name' maxlength='$maxlength' id='gm-input--$name'/>";
            $rs .= "</div>";
            return $rs;
        }
    
        public static function email($name, $label = null) {
            $rs = "<div class='form-group m-form__group'>";
            if(!!$label) $rs .= "<label class='form-control-label' for='gm-input--$name'>$label</label>";
            $rs .= "<input type='email' class='form-control gm-css--input_text gm-js--input_text gm-input--$name' name='$name' maxlength='100' id='gm-input--$name'/>";
            $rs .= "<span class='form-control-feedback'></span>";
            $rs .= "</div>";
            return $rs;
        }
        
        public static function date($name, $label = null, $default = null) {
            $rs = "<div class='form-group m-form__group'>";
            if(!!$label) $rs .= "<label class='form-control-label' for='gm-input--$name'>$label</label>";
            $rs .= "<input class='form-control gm-css--input_date gm-js--input_date gm-input--$name' name='$name' id='gm-input--$name' value='$default'/>";
            $rs .= "<span class='form-control-feedback'></span>";
            $rs .= "</div>";
            return $rs;
        }
        
        public static function status($name, $label = null) {
            $rs = "<div class='form-group m-form__group'>";
            if(!!$label) $rs .= "<label class='form-control-label' for='gm-input--$name'>$label</label>";
            $rs .= "<select class='form-control gm-css--input_select gm-css--input_select gm-input--$name' name='$name' id='gm-input--$name'>
                        <option value='enable'>Enable</option>
                        <option value='disable'>Disable</option>
                   </select>";
            $rs .= "<span class='form-control-feedback'></span>";
            $rs .= "</div>";
            return $rs;
        }
        
        public static function number($name, $label, $min, $max, $step, $model) {
            $value = old($name, $model[$name]);
            $rs    = "<div class='form-group m-form__group'>";
            $rs    .= "<label for='gm-input--edit-user__$name'>$label</label>";
            $rs    .= "<input type='number' min='$min' max='$max' step='$step' class='form-control m-input' name='$name' id='gm-input--edit-user__$name' value='$value'/>";
            $rs    .= "<span class='m-form__help'></span>";
            $rs    .= "</div>";
            echo $rs;
        }
        
        public static function switch($name, $label, $model) {
            $checked = $model[$name] > 0 ? "checked" : "";
            echo "<div class='m-form__group form-group row'>
						<label class='col-9 col-form-label' for='gm-input--edit-user__$name'>$label</label>
						<div class='col-3'>
							<span class='m-switch m-switch--icon m-switch--primary'>
								<label>
									<input type='checkbox' $checked name='$name'/>
									<span></span>
								</label>
							</span>
						</div>
					</div>";
        }
        
        public static function select($name, $label, $model, $errors = null, $data = []) {
            $value = old($name, $model[$name]);
            $rs    = "<div class='form-group m-form__group'>";
            $rs    .= "<label for='gm-input--edit-user__$name'>$label</label>";
            $rs    .= "<select class='form-control m-input' name='$name' id='gm-input--edit-user__$name'>";
            foreach($data as $item) {
                $optValue = $item['value'];
                $selected = (string)$optValue === (string)$value ? 'selected' : '';
                $text     = $item['text'];
                $rs       .= "<option value='$optValue' $selected>$text</option>";
            }
            $rs .= "</select>";
            $rs .= "<span class='m-form__help'></span>";
            $rs .= "</div>";
            echo $rs;
        }
        
        public static function textarea($name, $label, $model, $errors) {
            $value       = old($name, $model[$name]);
            $labelStatus = $errors->has($name) ? 'has-danger' : '';
            $inputStatus = $errors->has($name) ? 'form-control-danger' : '';
            $textError   = $errors->first($name, ':message');
            $rs          = "<div class='form-group m-form__group m--margin-bottom-15 $labelStatus'>";
            $rs          .= "<label class='form-control-label' for='gm-input--edit-user__$name'>$label</label>";
            $rs          .= "<textarea class='form-control m-input m-input--air $inputStatus' name='$name' id='gm-input__$name'>$value</textarea>";
            $rs          .= "<span class='form-control-feedback'>$textError</span>";
            $rs          .= "</div>";
            
            return $rs;
        }
        
        public static function tinyEditor($name, $label, $data, $errors) {
            $value = !empty($data) ? old($name, $data[$name]) : '';
            return "
				<div class='form-group has-info'>
					<label class='control-label' for='$name'>$label</label>
					<div class=''>
						<textarea class='app-editor gm-input gm-input__textarea gm-input__textarea--tinyeditor gm-input__$name' name='$name' id='$name' rows='10' style='width:100%'>$value</textarea>
					</div>
				</div>
			";
        }
        
        public static function selectImage($name, $label, $data, $size = ['300px', '300px']) {
            if(!isset($data) || empty($data[$name]) || $data[$name] == "/public/images/no-image.jpg") {
                $src        = "/public/images/no-image.jpg";
                $showRemove = "display:none";
            } else {
                $src        = $data[$name] == "" ? "/public/images/no-image.jpg" : $data[$name];
                $showRemove = "";
            }
            
            $inputSelectImage = "<div class='gm-css__div-image--responsive' style='width:" . $size[0] . "; height:" . $size[1] . "'>";
            $inputSelectImage .= "<a href='" . asset("public/plugins/filemanager/dialog.php") . "?type=1&field_id=$name&lang=en_EN&akey=" . md5(date("YmddmYYmddmYYmddmY")) . "' class='thumbnail resfile-btn'>";
            $inputSelectImage .= "<img src='" . old('avatar', $src) . "' class='img-responsive gm-image gm-image__$name' alt=''>";
            $inputSelectImage .= "</a>";
            $inputSelectImage .= "<input type='hidden' name='$name' id='$name' class='gm-css__input gm-js__input gm-input__$name' value='" . old($name, $src) . "'>";
            $inputSelectImage .= "<button type='button' class='btn btn-sm m-btn--pill m-btn--air btn-danger gm-js__btn--remove-image gm-js__btn--remove-image-$name' data-field-id='$name' style='$showRemove'><i class='fa fa-remove'></i></button>";
            $inputSelectImage .= "</div>";
            
            $rs = "<div class='form-group has-info'>";
            if(empty($label)) {
                $rs .= "<div class='col-md-12'>$inputSelectImage</div>";
            } else {
                $rs .= "<label class='control-label' for='$name'>$label</label>";
                $rs .= "<div class=''>$inputSelectImage</div>";
            }
            $rs .= "</div>";
            
            return $rs;
        }
        
    }