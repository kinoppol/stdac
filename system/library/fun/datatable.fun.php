<?php
	
function datatableInit(){
	return '<link rel="stylesheet" type="text/css" href="'.
		site_url("system/jquery/datatable/media/css/jquery.dataTables.css",true).'">'.
		'<link rel="stylesheet" type="text/css" href="'.
		site_url("system/jquery/datatable/examples/resources/syntax/shCore.css",true).'">'.
		

		'<script type="text/javascript" language="javascript" src="'.
		site_url("system/jquery/datatable/media/js/jquery.dataTables.js",true).'"></script>'.
		'<script type="text/javascript" language="javascript" src="'.
		site_url("system/jquery/datatable/examples/resources/syntax/shCore.js",true).'"></script>';
		/*'<script type="text/javascript" language="javascript" src="'.
		site_url("system/jquery/datatable/examples/resources/demo.js",true).'"></script>';*/
}

function datatable($data,$linkArr=NULL){
	global $systemFoot;
	$ret='';
	static $dtInit=false;
	if(!$dtInit){
		$ret=datatableInit();
	}
$systemFoot.='<script type="text/javascript" language="javascript" class="init">
	

$(document).ready(function() {
	var table=$(\'#'.$data['id'].'\').DataTable( {
	            '.$data['attr'].'
	            responsive: true,
               "pageLength":'.$data['pagelength'].',
              "oSearch": {"sSearch": "'.$data['keyword'].'" },
					"order":'.$data['order'].',
                    "oLanguage": {
                    "sLengthMenu": "แสดง _MENU_ แถว ต่อหน้า",
                    "sZeroRecords": "ไม่พบข้อมูลที่ค้นหา",
                    "sInfo": "แสดงแถวที่ _START_ ถึง _END_ ของ _TOTAL_ แถว",
                    "sInfoEmpty": "แสดงแถวที่ 0 ถึง 0 ของ 0 แถว",
                    "sInfoFiltered": "(จากทั้งหมด _MAX_ แถว)",
                    "sSearch": "ค้นหา :",
                    "oPaginate": {
                            "sFirst": "เริ่มต้น",
                            "sPrevious": "ก่อนหน้า",
                            "sNext": "ถัดไป",
                            "sLast": "สุดท้าย"
              }
            }
} );

$(\'#'.$data['id'].' tbody\').on(\'click\',\'tr\',function(){
   if($(this).hasClass(\'selected\')){
      $(this).removeClass(\'selected\');
   }else{
      $(this).addClass(\'selected\');
   }
});

$(\'.delete-btn\').click(function(){
//alert(\'555\');
   table.row($(this).parents(\'tr\')).remove().draw(false);
});

} );


	</script>';
	
	$ret.=rhTable($data,$linkArr);
	return $ret;
}

function datatable_ajax($data){
	global $systemFoot;
	$ret='';
	static $dtInit=false;
	if(!$dtInit){
		$ret=datatableInit();
	}
$systemFoot.='<script type="text/javascript" language="javascript" class="init">
	var table;

$(document).ready(function() {
	table=$(\'#'.$data['id'].'\').DataTable( {
	            '.$data['attr'].'
					"bProcessing": true,
         			"serverSide": true,
		 			"responsive": true,
		 			"ajax":{
            			url :"'.$data['datasource'].'", // json datasource
            			type: "'.$data['method'].'",  // type of method  ,GET/POST/DELETE
            			error: function(){
              				$("#'.$data['id'].'_processing").css("display","none");
            			}
          			},
          			
					"pageLength":'.$data['pagelength'].',
               "order":'.$data['order'].',
                    "oSearch": {"sSearch": '.$data['keyword'].' },
                    "oLanguage": {
                    "sProcessing": "<i class=\"fa fa-spinner fa-spin\"></i> กำลังประมวลผล..<br>",
                    "sLengthMenu": "แสดง _MENU_ แถว ต่อหน้า",
                    "sZeroRecords": "ไม่พบข้อมูลที่ค้นหา",
                    "sInfo": "แสดงแถวที่ _START_ ถึง _END_ ของ _TOTAL_ แถว",
                    "sInfoEmpty": "แสดงแถวที่ 0 ถึง 0 ของ 0 แถว",
                    "sInfoFiltered": "(จากทั้งหมด _MAX_ แถว)",
                    "sSearch": "ค้นหา :",
                    "oPaginate": {
                            "sFirst": "เริ่มต้น",
                            "sPrevious": "ก่อนหน้า",
                            "sNext": "ถัดไป",
                            "sLast": "สุดท้าย"
              }
            }
}

);

$(\'#'.$data['id'].' tbody\').on(\'click\',\'tr\',function(){
   if($(this).hasClass(\'selected\')){
      $(this).removeClass(\'selected\');
   }else{
      $(this).addClass(\'selected\');
   }
});



} );


function '.$data['id'].'_delRow(ID){
   alert(\'5556\'+ID);
   
   table.row($(\'#\'+ID).parents(\'tr\')).remove().draw(false);
}


	</script>';
	
	$ret.=rhTable($data);
	return $ret;
}
/*"columns": [
                                    { "data": "id" },
                                    { "data": "doc_from" },
                                    { "data": "doc_title" },
                                    { "data": "send_time" }
                                    ],
                                    */