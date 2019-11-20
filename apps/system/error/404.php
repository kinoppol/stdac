<?php
  $title="Error-404";
  $subtitle="ไม่พบไฟล์ที่ระบุ";
    ?>
<div class="row">
							<div class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->

								<div class="error-container">
									<div class="well">
										<h1 class="grey lighter smaller">
											<span class="blue bigger-125">
												<i class="ace-icon fa fa-sitemap"></i>
												404
											</span>
											Page Not Found
										</h1>

										<hr />
										<h3 class="lighter smaller">เราไม่พบไฟล์ที่คุณต้องการ!</h3>
                              <?php
                                 print $url;
                              ?>
										<div>

											<div class="space"></div>
											<h4 class="smaller">ลองตรวจสอบดังต่อไปนี้:</h4>

											<ul class="list-unstyled spaced inline bigger-110 margin-15">
												<li>
													<i class="ace-icon fa fa-hand-o-right blue"></i>
													ตรวจสอบ URL ที่คุณระบุอีกครั้ง
												</li>

												<li>
													<i class="ace-icon fa fa-hand-o-right blue"></i>
													อ่าน "คำถามที่พบบ่อย"
												</li>

												<li>
													<i class="ace-icon fa fa-hand-o-right blue"></i>
													บอกเราให้ทราบถึงปัญหาที่คุณพบ
												</li>
											</ul>
										</div>

										<hr />
										<div class="space"></div>

										<div class="center">
											<a href="javascript:history.back()" class="btn btn-grey">
												<i class="ace-icon fa fa-arrow-left"></i>
												ย้อนกลับ
											</a>

											<a href="<?php print site_url(); ?>" class="btn btn-primary">
												<i class="ace-icon fa fa-home"></i>
												หน้าหลัก
											</a>
										</div>
									</div>
								</div>

								<!-- PAGE CONTENT ENDS -->
							</div><!-- /.col -->
						</div><!-- /.row -->
