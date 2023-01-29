<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Document</title>
</head>

<body>

    <?php
    $cap_units = [
        "Pieces"  => "PCS",
        "Picks"  => "PI",
        "Meter"  => "MTR",
    ];

    ?>
    <?php
    foreach ($cap_units as $cap_id => $cap_unit) {
    ?>
        <label for="<?php echo $cap_id; ?>"><?php echo $cap_unit; ?></label>
        <input type="checkbox" key="mtr" id="<?php echo $cap_id; ?>" value="<?php echo $cap_unit; ?>" class="cap_unit" checked="true">
        <br><br>
    <?php
    }
    ?>
    <script>
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $('.cap_unit').change(function() {
            var all_chks = {};
            $('.cap_unit').each(function(ind, chk_bx) {
                all_chks[$(chk_bx).attr('id')] = $(chk_bx).is(':checked') ? $(chk_bx).val() : "";
            });

            console.log(all_chks);
            $.ajax({
                url: 'save',
                type: "POST",
                data: {
                    _token: CSRF_TOKEN,
                    all_chks : all_chks
                }
            }).done((res) => {
                console.log(res);
            }).fail((err) => {
                console.log(err);
            })
        });
    </script>

</body>

</html>