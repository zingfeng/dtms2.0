<?php
return  array( 
	
	'original_path' => $_SERVER['DOCUMENT_ROOT'].'/uploads/images/userfiles/',
	'resize' => array( 'path' => $_SERVER['DOCUMENT_ROOT'].'/uploads/images/resize/',
						'size' => array(50,100,200,300,550,750,800)
					),
	'crop' => array( 'path' => $_SERVER['DOCUMENT_ROOT'].'/uploads/images/crop/',
						'size' => array('260x156','200x300','250x250','235x330','26x26','300x180','960x576','310x125')
				),
);

?>