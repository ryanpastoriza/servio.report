<?php

    var_dump($_SESSION);

?>
<div class="col-sm-12">
   
    <div class="box box-default box-solid">
        <div class="box-header with-border">
            <h3 class="box-title"><b>Details</b> <small> Prospect Inquiry Report</small></h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table id="" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>Dealer</th>
                            <th>Branch</th>
                            <th>Inquiry No</th>
                            <th>Inquiry Date</th>
                            <th>Customer Name</th>
                            <th>Mobile No</th>
                            <th>Email Address</th>
                            <th>Address</th>
                            <th>Base Model</th>
                            <th>model Description</th>
                            <th>Body Type</th>
                            <th>Color</th>
                            <th>Vehicle Type</th>
                            <th>Payment Mode</th>
                            <th>Financing Term</th>
                            <th>Lead Source</th>
                            <th>Sales Executive</th>
                            <th>Status</th>
                            <th>Disqualification Reason</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php  $no = 0; foreach($pi_records as $row) : ?>

                            <tr>
                                <td nowrap> <?=  ++$no ; ?> </td>
                                <td nowrap> <?= $row->dealer; ?></td> 
                                <td nowrap> <?= $row->branch; ?> </td>
                                <td nowrap> <?= $row->name; ?> </td>
                                <td nowrap> <?= date("M-d-Y", strtotime($row->inquiry_date_c)); ?> </td>
                                <td nowrap> <?=  ucwords($row->fname_c .' '. $row->mname_c .' '. $row->lname_c) ; ?> </td>
                                <td nowrap> <?= $row->mobile_no_c; ?> </td>
                                <td nowrap> <?= $row->email_c; ?> </td>
                                <td nowrap> <?= $row->basic_address_c.','.$row->city; ?> </td>
                                <td nowrap> <?= $row->base_model; ?> </td>
                                <td nowrap> <?= $row->model_description; ?> </td>
                                <td nowrap> <?= $row->body_type; ?> </td>
                                <td nowrap> <?= $row->color; ?> </td>
                                <td nowrap> <?= $row->vehicle_type; ?> </td>
                                <td nowrap> <?= $row->payment_terms_c; ?> </td>
                                <td nowrap> <?= $row->financing_term; ?> </td>
                                <td nowrap> <?= $row->lead_source; ?> </td>
                                <td nowrap> <?= $row->first_name .' '.$row->last_name ; ?> </td>
                                <td nowrap> <?= $row->status_c; ?> </td>
                                <td nowrap> <?= $row->disq_reason_c; ?> </td>
                            </tr>

                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
