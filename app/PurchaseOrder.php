<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string po_number
 * @property integer user_id
 * @property integer customer_id
 * @property  string customer_account_no
 * @property  string company_name
 * @property string order_date
 * @property integer number_of_item
 * @property double total
 * @property double discount
 * @property double sgst
 * @property double cgst
 * @property double igst
 * @property double taxable
 * @property double grand_total
 */
class PurchaseOrder extends Model {

    protected $fillable = [
        'po_number', 'agent_id', 'customer_id', 'customer_account_no', 'company_name', 'order_date', 'number_of_item', 'total', 'discount', 'sgst', 'cgst', 'igst', 'taxable', 'grand_total'
    ];

    public function items() {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function invoices() {
        return $this->hasMany(Invoice::class, 'order_id', 'id');
    }

    public function attachments() {
        return $this->hasMany(PurchaseOrderAttachment::class, 'order_id', 'id');
    }

    public function customerAccount() {
        return $this->belongsTo(CustomerAccount::class, 'customer_account_no', 'account_no');
    }

    public function getIndianCurrency(float $number) {
        $decimal = round($number - ($no = floor($number)), 2) * 100;
        $hundred = null;
        $digits_length = strlen($no);
        $i = 0;
        $str = array();
        $words = array(0 => '', 1 => 'one', 2 => 'two',
            3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
            7 => 'seven', 8 => 'eight', 9 => 'nine',
            10 => 'ten', 11 => 'eleven', 12 => 'twelve',
            13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
            16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
            19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
            40 => 'forty', 50 => 'fifty', 60 => 'sixty',
            70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
        $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
        while ($i < $digits_length) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += $divider == 10 ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str [] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural . ' ' . $hundred : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural . ' ' . $hundred;
            } else $str[] = null;
        }
        $Rupees = implode('', array_reverse($str));
        $paise = ($decimal > 0) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
        return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
    }
}
