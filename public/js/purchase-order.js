"use strict";
$(document).on('change', '.item_qty', function (e) {
    NProgress.start();
    $.ajax({
        type: 'GET',
        url: base_url + '/products/details/' + $('.selectProduct').val() + '/' + $(this).val(),
        data: {},
        dataType: "json",
        success: function (resultData) {
            $('.amount').val(resultData.data.amount);
            NProgress.done();
        }
    });
});
$(document).on('change', '.selectCustomer', function (e) {
    if ($(this).val() === '') return false;
    NProgress.start();
    $.ajax({
        type: 'GET',
        url: base_url + '/customers/details/' + $(this).val(),
        data: {},
        dataType: "json",
        success: function (resultData) {
            if (resultData.data.length === 0) {
                $('.selectAccountNumber').html('<option value="">Select Customer Account</option>');
                NProgress.done();
                return false;
            }
            let html = '';
            $.each(resultData.data, function (i) {
                html += '<option value="' + resultData.data[i].account_no + '">' + resultData.data[i].account_no + '</option>';
            });
            $('.selectAccountNumber').html(html);
            NProgress.done();
        }
    });
});
/**
 * Append Service
 */
$(document).on('click', '.addService', function (e) {
    let selectPlan = $('.selectPlan');
    let selectFrequency = $('.selectFrequency');
    if ((selectPlan.val() === '') && (selectFrequency.val() === '')) return false;
    NProgress.start();
    $.ajax({
        type: 'GET',
        url: base_url + '/purchase/service/details/' + selectPlan.val() + '/' + selectFrequency.val(),
        data: {},
        dataType: "json",
        success: function (resultData) {
            console.log(resultData);
            let $trTd = '<tr>\n' +
                '<td class="col-md-8">' + resultData.data.plan_name + '</td>\n' +
                '<td class="col-md-1">' + resultData.data.price + '</td>\n' +
                '<td class="col-md-1">' + resultData.data.frequency + '</td>\n' +
                '<td class="col-md-1">--</td>\n' +
                '<td class="col-md-2"><input type="hidden" class="subTotal" value="' + resultData.data.subtotal + '">' + resultData.data.subtotal + '&nbsp;(<span class="currency">Rs</span>)/-</td>\n' +
                '<td style="widtd: 10px !important; text-align: center;"><a href="javascript:void(0);"><i class="fa fa-trash-o text-danger removeService" id="removeService"></i></a></td>\n' +
                '</tr>';
            $('#myTable').append($trTd);
            calculateSum();
            NProgress.done();
            $('.addService').hide('slow');
        }
    });
});
$(document).on('click', '.addItems', function (e) {
    let selectProduct = $('.selectProduct');
    let item_qty = $('.item_qty');
    if ((selectProduct.val() === '') && (item_qty.val() === '')) return false;
    NProgress.start();
    $.ajax({
        type: 'GET',
        url: base_url + '/purchase/item/details/' + selectProduct.val() + '/' + item_qty.val(),
        data: {},
        dataType: "json",
        success: function (resultData) {
            console.log(resultData);
            let $trTd = '<tr data-amount="' + resultData.data.price + '">\n' +
                '<td class="col-md-8"><input type="hidden" name="product_name[]" value="' + resultData.data.product_name + '">' + resultData.data.product_name + '</td>\n' +
                '<td class="col-md-1"><input type="hidden" name="price[]" value="' + resultData.data.price + '">' + resultData.data.price + '</td>\n' +
                '<td class="col-md-1"><input type="hidden" name="quantity[]" value="' + resultData.data.quantity + '">' + resultData.data.quantity + '</td>\n' +
                '<td class="col-md-1"><input type="text" name="discount[]" class="form-control" value="0"></td>\n' +
                '<td class="col-md-2"><input type="hidden" name="sub_total[]" class="subTotal" value="' + resultData.data.subtotal + '">' + resultData.data.subtotal + '&nbsp;(<span class="currency">Rs</span>)/-</td>\n' +
                '<td style="widtd: 10px !important; text-align: center;"><a href="javascript:void(0);"><i class="fa fa-trash-o text-danger removeNew" id="removeNew"></i></a></td>\n' +
                '</tr>';
            $('#myTable').append($trTd);
            calculateSum();
            NProgress.done();
        }
    });
});
$(document).on('click', '.removeNew', function (e) {
    $(this).closest("tr").remove();
    calculateSum();
});
$(document).on('click', '.removeService', function (e) {
    $(this).closest("tr").remove();
    calculateSum();
    $('.addService').show('slow');
});
function calculateSum() {
    var sum = 0;
    //iterate through each textboxes and add the values
    $(".subTotal").each(function () {
        //add only if the value is number
        if (!isNaN(this.value) && this.value.length != 0) {
            sum += parseFloat(this.value);
        }
    });
    //.toFixed() method will roundoff the final sum to 2 decimal places
    $(".total_amount").html(sum.toFixed(2));
    $(".final_amount").val(sum.toFixed(2));
}
