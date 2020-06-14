<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer order_id
 * @property integer customer_account_no
 * @property string status
 * @property string plan
 * @property string amount
 * @property string frequency
 * @property string start_date
 * @property string expire_date
 * @property string service_expire_reminder
 * @property float|int sgst
 * @property float|int cgst
 * @property float|int igst
 * @property float|int taxable
 * @property float|int grand_total
 * @property  string sac_code
 */
class CustomerService extends Model {

    const ACTIVE = 'ACTIVE';
    const DEACTIVE = 'DE-ACTIVE';
    protected $fillable = [
        'order_id', 'customer_account_no', 'status', 'plan', 'amount', 'frequency', 'expire_date', 'service_expire_reminder'
    ];

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
