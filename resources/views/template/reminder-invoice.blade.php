<!DOCTYPE html>
<html>
<head>
    <title></title>
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>-->
</head>
<style type="text/css">
</style>
<body style="font-style: sans-serif;font-size: 12px">
<div style="width: 750px;margin: auto; display: block;">
    <!-- Header -->
    <div style="width: 60%; float: left;">
        <img src="{{ $organization->logo }}" style="width: 350px; height: 50px; margin: 15px 0 0 0">
    </div>
    <div style="width: 40%; float: left;">
        <h4 style="font-size: 20px;"><strong>{{ $organization->name }}</strong></h4>
        <p>Regd. Office: {{ $organization->address->address1 }}, {{ $organization->address->address2 }}, {{ $organization->address->address3 }}<br> {{ $organization->address->city }}
            , {{ $organization->address->state }}</p>
        <p>Ph No.: {{ $organization->address->phone1 }}, {{ $organization->address->phone2 }}</p>
        <p>Web: ekowebtech.net</p>
    </div>
    <!-- body -->
    <div style="clear: both;"></div>
    <h2 style="border: 1px solid #000000; padding: 3px; text-align: center;font-weight: 600; font-size: 20px;"> Tax Invoice</h2>
    <div style="width: 60%; float: left;">
        <p style="margin: 2px"><strong>Bill To:</strong></p>
        <p style="margin: 2px">Customer: {{ $customer->first_name }} {{ $customer->last_name }}</p>
        <p style="margin: 2px">Company Name: {{ $customer->company->name }}</p>
        <p style="margin: 2px">Contact Person: {{ $customer->company->contact_person }}</p>
        <p style="margin: 2px">Contact No: {{ $customer->company->contact_number }}</p>
        <br>
        <p style="margin: 2px">GSTIN : {{ $customer->company->gst_number }}</p>
        <p style="margin: 2px">State Code : 07</p>
    </div>
    <div style="width: 40%; float: left;">
        <table>
            <tr>
                <td style="padding: 3px;">Invoice No :</td>
                <td style="padding: 3px;">#{{ $invoice->id }}</td>
            </tr>
            <tr>
                <td style="padding: 3px;">Invoice Date :</td>
                <td style="padding: 3px;">{{ $invoice->created_at->toDateString() }}</td>
            </tr>
            <tr>
                <td style="padding: 3px;">Due Date :</td>
                <td style="padding: 3px;">{{ $invoice->due_date }}</td>
            </tr>
            <tr>
                <td style="padding: 3px;">Account Id :</td>
                <td style="padding: 3px;">{{ $invoice->customer_account_no }}</td>
            </tr>
            <tr>
                <td style="padding: 3px;">PO No :</td>
                <td style="padding: 3px;">{{ $invoice->po_number }}</td>
            </tr>
        </table>
    </div>
    <!--  -->
    <div style="clear: both;"></div>
    {{--<div style="width: 100%; display: inline-block;">
        <div style="margin-left: 425px;float: left;width: 135px;text-align: center; font-weight: 600">From <br> 20/06/2016</div>
        <div style="margin-left: 142px;float: left;width: 135px;text-align: center; font-weight: 600">To <br> 19/12/2016</div>
    </div>--}}
    <div style="clear: both;"></div>
    <table style="border: 1px solid #000000; width: 100%;">
        <tr>
            <td style="border: 0.5px solid #000000;padding: 3px;">S.No.</td>
            <td style="border: 0.5px solid #000000;padding: 3px;">Item Description</td>
            <td style="border: 0.5px solid #000000;padding: 3px;">Unit</td>
            <td style="border: 0.5px solid #000000;padding: 3px;">Month</td>
            <td style="border: 0.5px solid #000000;padding: 3px;">SAC Code</td>
            <td style="border: 0.5px solid #000000;padding: 3px;">Rate</td>
            <td style="border: 0.5px solid #000000;padding: 3px;">Amt</td>
        </tr>
        <tr>
            <td style="border: 0.5px solid #000000;padding: 3px;">1</td>
            <td style="border: 0.5px solid #000000;padding: 3px;">{{ $customerService->plan }}</td>
            <td style="border: 0.5px solid #000000;padding: 3px;">1</td>
            <td style="border: 0.5px solid #000000;padding: 3px;">1</td>
            <td style="border: 0.5px solid #000000;padding: 3px;">{{ $customerService->sac_code }}</td>
            <td style="border: 0.5px solid #000000;padding: 3px;text-align: right;">{{ $customerService->amount }}</td>
            <td style="border: 0.5px solid #000000;padding: 3px;text-align: right;">{{ $customerService->amount }}</td>
        </tr>
        <tr>
            <td colspan="4" rowspan="5" style="border: 0.5px solid #000000;padding: 3px;"></td>
            <td style="border: 0.5px solid #000000;padding: 3px;">CGST : 9%</td>
            <td style="border: 0.5px solid #000000;text-align: right;padding: 3px;"></td>
            <td style="border: 0.5px solid #000000;text-align: right;padding: 3px;">{{ $customerService->cgst }}</td>
        </tr>
        <tr>
            <td style="border: 0.5px solid #000000;padding: 3px;">SGST : 9%</td>
            <td style="border: 0.5px solid #000000;padding: 3px;"></td>
            <td style="border: 0.5px solid #000000;text-align: right;padding: 3px;">{{ $customerService->sgst }}</td>
        </tr>
        <tr>
            <td style="border: 0.5px solid #000000;padding: 3px;">IGST : 18%</td>
            <td style="border: 0.5px solid #000000;padding: 3px;"></td>
            <td style="border: 0.5px solid #000000;text-align: right;padding: 3px;">{{ $customerService->igst }}</td>
        </tr>
        <tr>
            <td style="border: 0.5px solid #000000;padding: 3px;">Taxable Amt.</td>
            <td style="border: 0.5px solid #000000;padding: 3px;"></td>
            <td style="border: 0.5px solid #000000;text-align: right;padding: 3px;">{{ $customerService->taxable }}</td>
        </tr>
        <tr>
            <td style="border: 0.5px solid #000000;text-align: right;padding: 3px;"><strong>Total</strong></td>
            <td style="border: 0.5px solid #000000;padding: 3px;"></td>
            <td style="border: 0.5px solid #000000;text-align: right;padding: 3px;"><strong>{{ $customerService->grand_total }}</strong></td>
        </tr>
    </table>
    <div style="clear: both;"></div>
    <table style="border: 1px solid #000000; width: 100%;margin-top: 25px;">
        <tr>
            <td style="border: 0.5px solid #000000;padding: 3px; text-align: right"><strong>Rs. {{ ucfirst($customerService->getIndianCurrency($customerService->grand_total)) }}</strong></td>
        </tr>
    </table>
    <div style="clear: both;"></div>
    <table style="border: 1px solid #000000; width: 100%;margin-top: 25px;">
        <tr>
            <td>
                <p>PAN No. : {{ $organization->pan_no }}</p>
                <p>GSTIN. : {{ $organization->gstin_no }}</p>
                <p>Whether Tax is Payable on Reverse Charge Basis : Yes / No</p>
                <p>Powered by :- IAXN Technologies</p>
            </td>
            <td>
                <h4 style=" margin: 8px 0 4px;">Bank Detail</h4>
                <p>Name : Ekowebtech IT Services Pvt.Ltd.</p>
                <p>Bank : Axis Bank</p>
                <p>A/c No : 917020084536034</p>
                <p>Branch : Sector-37, Faridabad</p>
                <p>IFSC : UTIB0001575</p>
            </td>
        </tr>
    </table>
    <!-- //body -->
    <!-- Footer -->
    <div style="clear: both;"></div>
    <div>
        <h5><strong>Term & Condition</strong></h5>
        <div style="width: 60%; float: left;">
            <ol style="padding-left: 25px;">
                <li>1 Payment to be made by Cross cheque / Bank Draft in Favour of Ekowebtech IT Services Pvt. Ltd.</li>
                <li>2 Delay in payment beyond due date will carry a penal interest of 15% p.a.</li>
                <li>3 Ekowebtech IT Services Pvt. Ltd. Reserves the right to suspend service in case of non payment by due date and customer shall continue to be liable for the charges during any period of suspension.
                </li>
                <li>4 For New Connection billing start from the date of commissioning.</li>
                <li>5 Ekowebtech IT Services Pvt. Ltd. Reserves the right to change, from time to time, the terms & conditions of the contract by giving notice of the change.</li>
                <li>6 In case of any billing clarification, please contact Ph. 0129 - 2982297, 9811355626</li>
            </ol>
        </div>
        <div style="width: 35%; margin-left: 5%; float: left;">
            <h4 style=" text-align: right;margin: 0px 0px 70px;">Ekowentech IT service Pvt Ltd</h4>
            <p style='text-align: right;'>Authorised Signature</p>
        </div>
    </div>
    <!-- //Footer -->
</div>
</body>
</html>
