<style>

    .borderless>tbody>tr>td {
        border: none;
    }

    .borderless>tbody>tr>td {
        width: 30%;
    }

    .borderless>tbody>tr>td:first-child {
        width: 20%;
    }

    .borderless>tbody>tr>td:nth-child(3) {
        width: 20%;
    }

    .borderless>tbody>tr>td{
        border: none;
    }

</style>

<div class="col-sm-12">

    <div class="box box-default box-solid">
        <div class="box-header with-border">
            <h3 class="box-title"><b>Filter</b> <small> Prospect Inquiry Details</small></h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <div class="box-body">
            <form class="form-horizontal">

            <div class="col-sm-12">
                <div class="col-sm-10">
                   
                    <table class="table borderless table-condensed" width="100%">
                        <tr>
                            <td>Dealer</td>
                            <td>
                                <select id="select-dealer" class="form-control input-sm">
                                <?php foreach ($filters['dealer_branch'] as $key => $value ): ?>
                                    <option value="<?= $key; ?>"> <?= $key; ?> </option>
                                <?php endforeach; ?>
                                </select>
                            </td>

                            <td>Body Type</td>
                            <td>
                                <select class="form-control input-sm">
                                    <option></option>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td>Branch</td>
                            <td>
                                <select id="select-branch" class="form-control input-sm">
                                    <?php foreach ($filters['dealer_branch'] as $key => $value ): ?>
                                        <?php foreach ($value as $k => $v ): ?>
                                            <option> <?= $value[$k]; ?> </option>
                                        <?php endforeach; ?>
                                    <?php endforeach; ?>
                                </select>
                            </td>

                            <td>Payment Mode</td>
                            <td>
                                <select class="form-control input-sm">
                                    <option></option>
                                </select>
                            </td>

                        </tr>

                        <tr>
                            <td>Inquiry Date</td>
                            <td>
                                <select class="form-control input-sm">
                                    <option></option>
                                </select>
                            </td>

                            <td>Financing Terms</td>
                            <td>
                                <select class="form-control input-sm">
                                    <option></option>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td>Base Model</td>
                            <td>
                                <select class="form-control input-sm">
                                    <option></option>
                                </select>
                            </td>

                            <td>Lead Source</td>
                            <td>
                                <select class="form-control input-sm">
                                    <option></option>
                                </select>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>Model Description</td>
                            <td>
                                <select class="form-control input-sm">
                                    <option></option>
                                </select>
                            </td>

                            <td>Sales Executive</td>
                            <td>
                                <select class="form-control input-sm">
                                    <option></option>
                                </select>
                            </td>
                        </tr>
                       
                        <tr>
                            <td>Color</td>
                            <td>
                                <select class="form-control input-sm">
                                    <option></option>
                                </select>
                            </td>

                            <td>Status</td>
                            <td>
                                <select class="form-control input-sm">
                                    <option></option>
                                </select>
                            </td>
                        </tr>

                    </table>

                </div>
                <div class="col-sm-2"></div>
            </div>       
            </form>

        </div>
    </div>

</div>


<script>

    $(function(){

        $(document).on('change', '#select-dealer', function(){

            var dealer = $('#select-dealer option:selected').val();
            var branches = $.parseJSON('<?php echo json_encode($filters['dealer_branch']); ?>');
            // console.log(branches);
            // console.log(branches[dealer]);
            var options = branches[dealer];

            $el = $('#select-branch');
            $el.empty();
            $.each(options, function(key, value){
                    $el.append($("<option></option>")
                    .attr("value", value).text(value));
                // console.log(value);
            });

        });

    });


</script>
