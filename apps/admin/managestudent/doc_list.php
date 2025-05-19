<div class="table-responsive">
<?php
load_fun('table');
load_fun('datatable');
$table_data=array();

    $table_data[]=array(
        //'no'=>$i,
        'doc_no'=>'อวท. 06',
        'doc_name'=>'ใบสมัครสมาชิกชมรมวิชาชีพ',
        '<a href="'.site_url('ajax/admin/afp_doc/afp_06/gid/'.$hGET['id']).'" target="_blank" class="btn btn-danger" title="PDF"><i class="material-icons">book</i></a>'
        );

    $table_data[]=array(
      //'no'=>$i,
      'doc_no'=>'อวท. 10',
      'doc_name'=>'ใบสมัครสมาชิกองค์การฯ ระดับสถานศึกษา',
      '<a href="'.site_url('ajax/admin/afp_doc/afp_10/gid/'.$hGET['id']).'" target="_blank" class="btn btn-danger" title="PDF"><i class="material-icons">book</i></a>'
      );

    $table_data[]=array(
        //'no'=>$i,
        'doc_no'=>'อวท. 15',
        'doc_name'=>'แบบสรุปผลการประเมินผล กิจกรรมองค์การวิชาชีพ',
        '<a href="'.site_url('ajax/admin/afp_doc/afp_17/gid/'.$hGET['id']).'" target="_blank" class="btn btn-danger" title="PDF"><i class="material-icons">book</i></a>'
        );
    $table_data[]=array(
        //'no'=>$i,
        'doc_no'=>'อวท. 17',
        'doc_name'=>'ประกาศการประเมินผลกิจกรรมชมรมวิชาชีพ',
        '<a href="'.site_url('ajax/admin/afp_doc/afp_17/gid/'.$hGET['id']).'" target="_blank" class="btn btn-danger" title="PDF"><i class="material-icons">book</i></a>'
        );

$data=array("head"=>array(
//'ที่',
'หมายเลขเอกสาร',
'ชื่อเอกสาร',
'พิมพ์',
),
'id'=>'doc_table',
'item'=>$table_data,
'pagelength'=>10,
'order'=>'[[ 0, "asc" ]]'
);
print datatable($data);
?>
</div>