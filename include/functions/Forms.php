<?php

function get_post_values($fields, $post_values) {
	for($i=0; $i<count($fields); $i++) {
		$data[$fields[$i]['name']] = $_POST[$fields[$i]['name']];
	}
	return $data;
}

//display admin control
function display_forms($criteria=array()) {
	$fields = $criteria['fields'];
	$submit = $criteria['submit'];
	
	if($submit['name']=='') $submit['name']='submit';
	if($submit['value']=='') $submit['value']='Save';
	
	echo '<form method="post">';
	
		for($i=0; $i<count($fields); $i++) {
			
			if($fields[$i]['class']!='') $fields[$i]['class'] = 'class="'.$fields[$i]['class'].'"';
			
			if($fields[$i]['type']=='select') {
				echo '<div id="'.$fields[$i]['name'].'_box">';
					echo '<p style="padding-bottom:5px;"><label>'.$fields[$i]['title'].'</label></p>';
					echo '<p style="padding-bottom:5px;"><select '.$fields[$i]['class'].' id="'.$fields[$i]['name'].'" name="'.$fields[$i]['name'].'">';
					echo '<option value=""></option>';
					foreach($fields[$i]['select_values'] as $ind=>$value) {
						if($ind==$fields[$i]['value']) echo '<option value="'.$ind.'" selected>'.$value.'</option>';
						else echo '<option value="'.$ind.'">'.$value.'</option>';
					}
					echo '</select></p>';
				echo '</div>';
			}
			elseif($fields[$i]['type']=='checkbox') {
				echo '<div id="'.$fields[$i]['name'].'_box">';
					echo '<p style="padding-bottom:5px;"><label>';
					if($options[$fields[$i]['value']]=='on') $checked='checked';
					else $checked='';
					echo '<input '.$fields[$i]['class'].' type="checkbox" id="'.$fields[$i]['name'].'" name="'.$fields[$i]['name'].'" '.$checked.' style="margin-bottom:4px;" style="width:100%">';
					echo ' '.$fields[$i]['title'];
					echo '</label></p>';
				echo '</div>';
			}
			elseif($fields[$i]['type']=='textarea') {
				echo '<div id="'.$fields[$i]['name'].'_box">';
					if($fields[$i]['rows']!='') $fields[$i]['rows'] = 'rows="'.$fields[$i]['rows'].'"';
					echo '<p style="padding-bottom:5px;"><label>'.$fields[$i]['title'].'</label></p>';
					echo '<p style="padding-bottom:5px;">
					<textarea '.$fields[$i]['class'].' id="'.$fields[$i]['name'].'" name="'.$fields[$i]['name'].'" style="width:100%" '.$fields[$i]['rows'].'>'.$fields[$i]['value'].'</textarea></p>';
				echo '</div>';
			}
			elseif($fields[$i]['type']=='hidden') {
				echo '<p style="padding-bottom:5px;"><input '.$fields[$i]['class'].' type="hidden" id="'.$fields[$i]['name'].'" name="'.$fields[$i]['name'].'" 
				style="width:100%" value="'.$fields[$i]['value'].'"></p>';
			}
			else {
				echo '<div id="'.$fields[$i]['name'].'_box">';
					echo '<p style="padding-bottom:5px;"><label>'.$fields[$i]['title'].'</label></p>';
					echo '<p style="padding-bottom:5px;"><input '.$fields[$i]['class'].' type="text" id="'.$fields[$i]['name'].'" name="'.$fields[$i]['name'].'" 
					style="width:100%" value="'.$fields[$i]['value'].'"></p>';
				echo '</div>';
			}
		}
		
		echo '<div id="'.$submit['name'].'_box">';
			echo '<p class="submit" style="padding-top:10px;">';
			echo '<input type="submit" id="'.$submit['name'].'" name="'.$submit['name'].'" value="'.$submit['value'].'">';
			echo '</p>';
		echo '</div>';
	
	echo '</form>';
}

?>