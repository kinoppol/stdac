<div class="table-responsive">
<?php
load_fun('table');
load_fun('datatable');
$table_data=array();

  $table_data[]=array(
    //'no'=>$i,
    'doc_name'=>'ใบสมัครสมาชิกองค์การฯ ระดับสถานศึกษา',
    'doc_no'=>'อวท. 10',
    '<a href="'.site_url('ajax/admin/afp_doc/afp_10/gid/'.$hGET['id']).'" target="_blank" class="btn btn-danger" title="PDF"><i class="material-icons">book</i></a>'
    );

    $table_data[]=array(
        //'no'=>$i,
        'doc_name'=>'ใบสมัครสมาชิกชมรมวิชาชีพ',
        'doc_no'=>'อวท. 06',
        '<a href="'.site_url('ajax/admin/afp_doc/afp_06/gid/'.$hGET['id']).'" target="_blank" class="btn btn-danger" title="PDF"><i class="material-icons">book</i></a>'
        );

$data=array("head"=>array(
//'ที่',
'ชื่อเอกสาร',
'หมายเลขเอกสาร',
'พิมพ์',
),
'id'=>'doc_table',
'item'=>$table_data,
'pagelength'=>10,
'order'=>'[[ 1, "asc" ]]'
);
print datatable($data);
?>
</div>